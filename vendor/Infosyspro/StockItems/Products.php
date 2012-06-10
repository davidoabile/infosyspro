<?php

  /*
   * To change this template, choose Tools | Templates
   * and open the template in the editor.
   */

  namespace Infosyspro\StockItems;

  /**
   * Description of Products
   *
   * @author infosyspro
   */
  class Products implements AbstractStockItems
  {
      /* The variables below defines objects which is the subfolders of stockItems directory */

      protected $alsoBought = null;
      protected $coupons = null;
      protected $favourites = null;
      protected $pricePolicy = null;
      protected $quotes = null;
      protected $relatedProducts = null;
      protected $reviews = null;
      protected $stockCategories = null;
      protected $wishList = null;
      /* end DI objects */

      /* Single instance of this object */
      protected static $instance;

      /* Prohibit objects of this class to be instantiated from outside the class */

      protected function __construct()
      {         
      }

      /* Prepare the instance */

      public static function getInstance()
      {
          if (self::$instance === null) {
              self::$instance = new Products();
          }

          return self::$instance;
      }

       /**
       *  Get a list of all active products
       *  Products must be both web enabled and active
       * 
       * @uses Zend\Db\Db
       * @return array Zend\DB
       */
      public function getProductsByGroup($groupID)
      {
          /* STOCKGROUP is the primary group for these products 
           * STOCKGROUP2 is the parent of STOCKGROUP
           */
          $db = $this->getDb();
          $select = $db->select()
                        ->from('TbSTOCK_ITEMS')
                        ->joinUsing('TbSTOCK_WEB', 'STOCKCODE')
                        ->where('ISACTIVE = ?', 'Y')
                        ->where('WEB_SHOW = ?', 'Y' )
                        ->where('STOCKGROUP = ?', $groupID)
                        ->order($this->config->stockItemGroupOrder);
          $stmt = $db->query($select);
          return $stmt->fetchAll();
      }

     
      /**
       *  Get a list of all active products
       *  Products must be both web enabled and active
       * 
       * @uses Zend\Db\Db
       * @return array Zend\DB
       */
      public function getProducts()
      {
          //if stockpricegroup is 0
          $db = $this->getDb();
          $select = $db->select()
                        ->from('TbSTOCK_ITEMS')
                        ->joinUsing('TbSTOCK_WEB', 'STOCKCODE')
                        ->where('ISACTIVE = ?', 'Y')
                        ->where('WEB_SHOW = ?' , 'Y' )
                        ->order($this->config->stockItemProductsOrder);
          
          $stmt = $db->query($select);
          return $stmt->fetchAll();
      }


      public function getNewProducts()
      {
          //if stockpricegroup is 0
          $db = $this->getDb();
          $select = $db->select()
                        ->from('TbSTOCK_ITEMS')
                        ->joinUsing('TbSTOCK_WEB', 'STOCKCODE')
                        ->where('ISACTIVE = ?', 'Y')
                        ->where('WEB_SHOW = ?' , 'Y' )
                        ->where('NEW_ARRIVALS = ?', 'Y');
          
          $stmt = $db->query($select);
          return $stmt->fetchAll();
      }
      
      /**
       * Get extra fields form the stock item
       * These are fields set by the owner e.g. sugarfree = y
       * Glucosefree = Yes etc
       *  
       */
      public function extraFields() {
         return json_decode($this->product->ATTRIBUTES); 
      }
      
      public function alsoBought()
      {
          if ($this->alsoBought === null) {
              $this->alsoBought = new AlsoBought\AlsoBought;
          }
          return $this->alsoBought;
      }

      /* Get the coupons object */

      public function getCoupons()
      {
          if ($this->coupons === null) {
              $this->coupons = new Coupons\Coupons();
          }
          return $this->coupons;
      }

      /* Get favourites objects */

      public function getFavourites()
      {
          if ($this->favourites === null) {
              $this->favourites = new Favourites\Favourites();
          }
          return $this->favourites;
      }

      /* get price policy object */

      public function getPricePolicy()
      {
          if ($this->pricePolicy === null) {
              $this->pricePolicy = new PricePolicy\PricePolicy();
          }
          return $this->pricePolicy;
      }

      /* Get Quotes */

      public function getQuotes()
      {
          if ($this->quotes === null) {
              $this->quotes = new Coupons\Coupons();
          }
          return $this->quotes;
      }

      public function getRelatedProducts()
      {
          if ($this->relatedProducts === null) {
              $this->relatedProducts = new RelatedProducts\RelatedProducts();
          }
          return $this->relatedProducts;
      }

      public function getReviews()
      {
          if ($this->reviews === null) {
              $this->reviews = new Reviews\Reviews();
          }
          return $this->reviews;
      }

      /* products categories object */

      public function getStockGroups()
      {
          if ($this->stockCategories === null) {
              $this->stockCategories = new StockGroups\StockGroups();
          }
          return $this->stockCategories;
      }

      /* wish list object */

      public function getWishList()
      {
          if ($this->wishList === null) {
              $this->wishList = new WishList\WishList();
          }
          return $this->wishList;
      }

    
  }

?>
