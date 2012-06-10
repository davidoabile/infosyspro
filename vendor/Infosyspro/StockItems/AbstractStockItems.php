<?php

  /*
   * To change this template, choose Tools | Templates
   * and open the template in the editor.
   */

  namespace Infosyspro\StockItems;

  /**
   * Description of AbstractStockItems
   *
   * @author infosyspro
   */
  abstract class AbstractStockItems
  {

      protected $basePrice = 0;
      /* Get the DI object */
      protected $locator = null;
      protected $config = null;
      protected $product = null;
      protected $company = null;
      protected $user = null;
      protected $userGroups = null;
      protected $currency = null;
      protected $currentlang = null;

      public function __construct(\Zend\Di\Locator $locator = null)
      {
          $this->_setUp($locator);
      }

      /* Set The DI to be used by all children */

      public function setLocator(\Zend\Di\Locator $locator)
      {
          $this->_setUp($locator);
          
          return $this;
      }

      /**
       * Get tax rate:
       * 
       * Order matter: Product Tax (SALESTAXRATE)  first => Customer tax (TAXSTATUS)
       * follows else config taxrate
       * @param int $rateID
       * @return double 
       */
      public function getTaxRate($rateID = false)
      {
          $table = $this->_getDbTable();
          $price = 0.1;
          //TODO: Get the tax table
          $this->table->setOptions(array('name' => 'TbTAXRATE'));

          if ($rateID)
              $id = $rateID;
          elseif (!empty($this->userInfo->TAXSTATUS))
              $id = $this->userInfo->TAXSTATUS;
          elseif ($this->config->taxRateId > -1)
              $id = $this->config->taxRateId;

          $rate = $table->find($id);
          /* If there is now rate set return default Australian 10% */
          $price = $rate[0]['TAXRATE'] > 0 ? $rate[0]['TAXRATE'] / 100 : 0.1;

          return $price;
      }

      /**
       * Get the final product price 
       * 
       * This is after checking all policies related to the product
       * 
       * @param type $price
       * @param type $productTax 
       */
      public function getFinalPrice($price, $productTax = false)
      {
          /* setup Zend\Currency based on the config */
          $currConfig = json_decode($this->config->defaultCurrency);
          $this->currency = new \Zend\Currency\Currency(array(
                      'value' => 0,
                      'currency' => $currConfig->defaultCurrency,
                      'format' => $currConfig->format,
                      'symbol' => $currConfig->symbol,
                      'position' => $currConfig->position,
                  ));

          $productPrice = array();
          $priceConf = strtolower($this->config->displayPriceWithTax);
          /* If client want price to be displayed with both GS or EX-gst */
          if ($priceConf == 'both' || $priceConf == 'true') {
              $product_price_tax = $price + $price * $this->getTaxRate($productTax);
              $productPrice['incGST'] = $this->currency->setValue($product_price_tax);
              if ($priceConf == 'both') {
                  $productPrice['exGST'] = $this->currency->setValue($price);
              }
          } else {
              $productPrice['exGST'] = $this->currency->setValue($price);
          }

          return $productPrice;
      }

      /* This is not a simple matter of getting a single price because
       * Each debtor can have a different price policy
       */

      public function getStockPrice($price, $productTax = false)
      {
          if (sizeof($this->product) == 0) {

              $this->_setError('error', '$product rowset expected on STOCKITEMS::getStockPrice, none provided');
          }

          $priceConf = strtolower($this->config->displayPriceWithTax);
          /* If client wants price to be displayed with both GST or EX-GST */
          if ($priceConf == 'both' || $priceConf == 'true') {
              $productPrice['GST'] = $price + $price * $this->getTaxRate($productTax);

              if ($priceConf == 'both') {
                  $productPrice['exGST'] = $price;
              }
          } else {
              $productPrice['exGST'] = $price;
          }

          return $productPrice;
      }

      /* This is not a simple matter of getting a single price because
       * Each debtor can have a different price policy
       */

      public function getBasePrice()
      {
          if (sizeof($this->product) == 0) {

              $this->_setError('error', '$product rowset expected on STOCKITEMS::getStockPrice, none provided');
          }
          /* Get the default base price.. this should be set in the config under category stockItems */
          if ($this->config->baseprice > 0) {
              $this->basePrice = $this->product->SELLPRICE . $this->config->baseprice;
          } else {
              $this->basePrice = $this->product->SELLPRICE1;
          }
      }

      public function getProductById($id)
      {
          $db = $this->getDb();
          $select = $db->select()
                  ->from('TbSTOCK_ITEMS')
                  ->joinUsing('TbSTOCK_WEB', 'STOCKCODE')
                  ->where('ID = ?', $id);

          $stmt = $db->query($select);
          $this->product = $stmt->fetchAll();
          return $this->product;
      }

      public function getProductByStockCode($code)
      {
          $db = $this->getDb();
          $select = $db->select()
                  ->from('TbSTOCK_ITEMS')
                  ->joinUsing('TbSTOCK_WEB', 'STOCKCODE')
                  ->where('STOCKCODE = ?', $code);

          $stmt = $db->query($select);
          $this->product = $stmt->fetchAll();
          return $this->product;
      }

      public function getSpecialPrice()
      {
          $table = $this->_getDbTable();
          $price = 0;
          $this->table->setOptions(array('name' => 'TbDR_PRICES'));
      }

      protected function _setUp($locator)
      {
          $this->locator = $locator;
          /* We need the locator to do work otherwise everything will fail */
           if (!$this->locator instanceof \Zend\Di\Locator) {
              trigger_error('Stock Item library $locator must be an instanceof \Zend\Di', E_USER_ERROR);
          }
          
          $config = $locator->get('appConfig');
          $where = array('where' => array('moduleName' => 'stockItems'),
              'orWhere' => array('moduleName' => 'site'),
          );

          $this->lang = $locator->get('translator');
          $this->currentlang = $this->lang->getLocale();
          $this->config = $config->loadDbConfig($where);
          /* Load the user session */
          $this->_getUserSession();
      }
      
      /**
       * Get DI
       * $locator is the core of this framework and 
       * it is needed almost everywhere
       * @return void 
       */
      protected function _getLocator()
      {
          if ($this->locator instanceof \Zend\Di\Locator) {
              return $this->locator;
          }
          trigger_error('Stock Item library $locator must be an instanceof \Zend\Di', E_USER_ERROR);
      }

      protected function _getUserSession()
      {
          $this->user = $this->_getLocator()->get('userSessionManager');
          $this->userGroups = $this->user->getUserGroup();
      }

      protected function _getDb()
      {

          return $this->_getLocator()->get('Db');
      }

      protected function _getDbTable()
      {
          return $this->_getLocator()->get('Dbtable');
      }

      protected function _getCompany()
      {
          return $this->_getLocator()->get('Company');
      }

      protected function _setError($type, $message)
      {
          $this->_getCompany()
                  ->getSession()
                  ->setKey('message', array('type' => $type,
                      'message' => $message));
      }

  }

  