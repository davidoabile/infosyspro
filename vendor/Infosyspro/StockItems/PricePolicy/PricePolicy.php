<?php

  /*
   * To change this template, choose Tools | Templates
   * and open the template in the editor.
   */

  namespace Infosyspro\StockItems\PricePolicy;

  use Company\UserManager;

  class PricePolicy implements AbstractStockItems
  {

      protected $inAccount;
      protected $userInfo;

      public function getBestPrice()
      {
          $product_price = $this->getStockPrice();

          $this->userInfo = $this->user->getUserInfo();
          //
          // if($this->productOnSpecial )          
          if ($this->user->isLoggedIn()) {
              if (!empty($this->userInfo->PRICEBANDNO))
                  $product_price = $this->userInfo->PRICEBANDNO;


              //check price from the policy rules
              //TODO:  $policy	= price_policy_checkPricePolicy($products_price,$products_id);
              /* No price policy set for the user return base price */
              //$rules = price_policy_checkPriceRules($products_id,$products_price);
              $cheap = $products_price;
              if ($policy && $rules) {

                  #list all price from policy and rules, find the cheapest one
                  if ($policy) {
                      #if the policy is fixed, using thie fiex price
                      if (!is_null($policy['fixed'])) {
                          $cheap_fix = $policy['fixed'][0]["price"];
                          //$price['fixed']=$policy['fixed'];
                          for ($i = 0; $i < sizeof($policy['fixed']); $i++) {
                              if ($policy['fixed'][$i]['price'] < $cheap_fix)
                                  $cheap_fix = $policy['fixed'][$i]['price'];
                          }
                      } else {
                          #list all price from policy to price array
                          for ($i = 0; $i < sizeof($policy); $i++) {
                              $price[] = $policy[$i];
                          }
                      }
                  }

                  #sign all price from rules to price array
                  if ($rules)
                      $price[] = $rules;

                  if (!empty($cheap_fix) && $cheap_fix > 0) {
                      $cheap = $cheap_fix;
                  } else {
                      $cheapT = $products_price;
                      $cheap = $price[0];
                      #find the cheapest price for the price array
                      for ($i = 0; $i < sizeof($price); $i++) {
                          if ($price[$i]['price'] < $cheapT) {
                              $cheap = $price[$i];
                              $cheapT = $price[$i]['price'];
                          }
                      }
                  }
              }
              if (is_array($cheap)) $cheap = $cheap['price'];
              
              $final_price = $cheap; // $this->getFinalPrice($cheap);
          }


          if ($special_price) {
              if ($special_price < $final_price) {
                  return $this->getFinalPrice($special_price);
              } else {
                  $temp = $final_price;
                  $temp_fix = false;
                  $fixed_bonus = false;
                  $bonus_price = price_policy_bonus($products_id, $final_price);
                  if (!$bonus_price[$products_id] == false && sizeof($bonus_price[$products_id]) > 0) {
                      foreach ($bonus_price[$products_id] AS $index => $prices) {
                          if (sizeof($bonus_price[$products_id]['fixed']) > 0 && isset($bonus_price[$products_id]['fixed'])) {
                              $fixed_price[] = $prices;
                          } elseif ($prices < $temp && !is_array($prices)) {
                              $temp = $prices > 0 ? $prices : $temp;
                          }
                      }

                      if (sizeof($fixed_price) > 0) {
                          $temp_fix = $fixed_price[0];
                          for ($i = 0; $i < sizeof($fixed_price); $i++) {
                              $temp_fix = ($fixed_price[$i] < $temp_fix) ? $fixed_price[$i] : $temp_fix;
                          }
                      }
                      if (isset($bonus_price[$products_id]["bonus"]) && sizeof($bonus_price[$products_id]["bonus"]) > 0) {
                          foreach ($bonus_price[$products_id]["bonus"] AS $index => $value) {
                              $fixed_bonus = $value["fixed"];
                          }
                          if ($fixed_bonus == "Y" && !$fixed_bonus == false) {
                              if (!$temp_fix == false && $temp_fix < $final_price) {
                                  $final_price = $temp_fix;
                              } else {
                                  if ($cheap_fix > 0) {
                                      if (get_basePrice(1, $products_id) <= $final_price) {
                                          $_SESSION['bonus'] = $bonus_price[$products_id]["bonus"];
                                          $final_price = get_basePrice(1, $products_id);
                                      }
                                  } else {
                                      $_SESSION['bonus'] = $bonus_price[$products_id]["bonus"];
                                      $final_price = get_basePrice(1, $products_id);
                                  }
                              }
                          } else {
                              if (!$temp_fix == false) {
                                  $final_price = $temp_fix;
                              } elseif ($cheap_fix > 0) {
                                  if ($cheap_fix < $final_price)
                                      $final_price = $cheap_fix;
                              } else {
                                  if ($temp < $final_price) {
                                      $final_price = $temp;
                                  } else {
                                      if (get_basePrice(1, $products_id) <= $final_price) {
                                          $_SESSION['bonus'] = $bonus_price[$products_id]["bonus"];
                                          $final_price = get_basePrice(1, $products_id);
                                      }
                                  }
                              }
                          }
                      } else {
                          if (!$temp_fix == false && $temp_fix < $final_price) {
                              $final_price = $temp_fix;
                          } else {
                              $final_price = $temp;
                          }
                      }
                  }
                  return $final_price;
              }
          } else {
              $temp = $final_price;
              $temp_fix = false;
              $fixed_bonus = false;
              $bonus_price = price_policy_bonus($products_id, $final_price);
              if (!$bonus_price[$products_id] == false && sizeof($bonus_price[$products_id]) > 0) {
                  foreach ($bonus_price[$products_id] AS $index => $prices) {
                      if (sizeof($bonus_price[$products_id]["fixed"]) > 0 && isset($bonus_price[$products_id]["fixed"])) {
                          $fixed_price[] = $prices;
                      } elseif ($prices < $temp && !is_array($prices)) {
                          $temp = $prices > 0 ? $prices : $temp;
                      }
                  }
                  if (sizeof($fixed_price) > 0) {
                      $temp_fix = $fixed_price[0];
                      for ($i = 0; $i < sizeof($fixed_price); $i++) {
                          $temp_fix = ($fixed_price[$i] < $temp_fix) ? $fixed_price[$i] : $temp_fix;
                      }
                  }
                  if (isset($bonus_price[$products_id]["bonus"]) && sizeof($bonus_price[$products_id]["bonus"]) > 0) {
                      foreach ($bonus_price[$products_id]["bonus"] AS $index => $value) {
                          $fixed_bonus = $value["fixed"];
                      }
                      if ($fixed_bonus == "Y" && !$fixed_bonus == false) {
                          if (!$temp_fix == false && $temp_fix < $final_price) {
                              $final_price = $temp_fix;
                          } else {
                              if ($cheap_fix > 0) {
                                  if (get_basePrice(1, $products_id) <= $final_price) {
                                      $_SESSION['bonus'] = $bonus_price[$products_id]["bonus"];
                                      $final_price = get_basePrice(1, $products_id);
                                  }
                              } else {
                                  $_SESSION['bonus'] = $bonus_price[$products_id]["bonus"];
                                  $final_price = get_basePrice(1, $products_id);
                              }
                          }
                      } else {
                          if (!$temp_fix == false) {
                              $final_price = $temp_fix;
                          } elseif ($cheap_fix > 0) {
                              if ($cheap_fix < $final_price) {
                                  $final_price = $cheap_fix;
                              }
                          } else {
                              if ($temp < $final_price) {
                                  $final_price = $temp;
                              } else {
                                  if (get_basePrice(1, $products_id) <= $final_price) {
                                      $_SESSION['bonus'] = $bonus_price[$products_id]["bonus"];
                                      $final_price = get_basePrice(1, $products_id);
                                  }
                              }
                          }
                      }
                  } else {
                      if (!$temp_fix == false && $temp_fix < $final_price) {
                          $final_price = $temp_fix;
                      } else {
                          $final_price = $temp;
                      }
                  }
              }
              return $final_price;
          }
      }

      /* Check if in cart meet the policy requirement */

      protected function _checkQuantityRequirements()
      {
          //todo: get shopping cart instance
      }

      protected function _checkPriceRules($products_price)
      {
          
      }
      protected function _checkPricePolicy($product_price) {
          
      }
      /* Get price policy groups if it has been assigned */

      protected function _getGroups($policy_no)
      {
          $this->inAccount = false;
      }
      
      protected function _getCategoryIdByProducts(){
          if( strtolower($this->config->UseStockGroupField) == 'stockgroup')
              $price = $this->product->STOCKGROUP;
          elseif(!empty($this->product->STOCKPRICEGROUP))
              $price = $this->product->STOCKPRICEGROUP;
          else
              $price = 0;
          
          return $price;
      }
      
      
/**
       *
       * get the price rules details
       * @param        String $where the SQL conditions 
       * @param        Float $products_price the current products price 
       * @return       Array list of all price and SEQNO of the rules
       */
      protected function _getRules($where, $products_price, $products_id)
      {
          //TODO: Check if there is no price policy table in exo
          $today = date('Y-m-d', time());
          $categories_id = $this->_getCategoryIdByProducts;
                   
          if ($categories_id > 0) {
              $tsql = "OR categories=$categories_id";
          }

          $sql = "SELECT * FROM `price_rules` $where AND (products_id is not NULL OR stock_price_group is not NULL OR categories>-1) 
                 AND(discount <>0 OR price_amount is not NULL OR base_price is not NULL) AND(start_date<='$today' AND end_date>='$today') 
                 AND (products_id=$products_id $tsql)";

          $query = tep_db_query($sql);
          $price = array();

          if (tep_db_num_rows($query) > 0) {

              $cheapest_price = 0;
              $i = 0;
              while ($result = tep_db_fetch_array($query)) {
               
                      #check if the products or category prodcuts meet the min_qty
                      if (price_policy_checkQty($result['SEQNO'])) {

                          $price[$i]['SEQNO'] = $result['SEQNO'];
                          #if discount using %
                          if ($result['discount'] > 0) {
                              $price[$i]['price'] = $products_price * (1 - $result['discount'] / 100);
                          }
                          #if sub price, using this price
                          elseif ($result['price_amount'] > 0) {

                              $price[$i]['price'] = $result['price_amount'];
                          }
                          #if base price, using base price
                          elseif ($result['base_price'] > 0) {
                              $price[$i]['price'] = get_basePrice($result['base_price'], $products_id);
                          } else {
                              $price[$i]['price'] = $products_price;
                          }
                          $i++;
                      }
                  }
              
              if (sizeof($price) > 0) {
                  return $price;
              } 
          } 
          
          return false;
          
      }
      
      
protected function _getBonus($products_id, $orginal_price)
{

	$sql   	 = "SELECT pp.policy_ref, pp.fixed, pp.policy_no from price_policy pp LEFT JOIN price_rules pr ON(pr.policy_no=pp.policy_no) 
				WHERE pr.products_id=$products_id 
				AND pr.policy_no IS NOT NULL 
				AND (pp.policy_ref LIKE 'ALL%' OR pp.policy_ref LIKE 'ANY%' OR pp.policy_ref LIKE 'GROUP%')" ;
	$query   = tep_db_query($sql);
	if(tep_db_num_rows($query)>0)
	{
		
		while ($results =  tep_db_fetch_array($query))
		{
				
			if(strrpos($results['policy_ref'],'ANY')>-1)
			{
				
				if(strrpos($results['policy_ref'],'_')>-1)
				{
			
					$group_no = explode("_",$results['policy_ref']);
					$group_no = $group_no[1];
				}
				
				$out[$products_id]["bonus"]=price_policy_bonus_any($products_id, $orginal_price, $results['policy_no'],$results['policy_ref'],$results["fixed"]);
					
				
				 //$out[$products_id]= price_policy_bonus_any($products_id, $orginal_price, $results['policy_no'],$results['policy_ref']);
			}
			elseif(strrpos($results['policy_ref'],'ALL')>-1)
			{
				if(strrpos($results['policy_ref'],'_')>-1)
				{
					$group_no = explode("_",$results['policy_ref']);
					$group_no = $group_no[1];
					
				}
				
				if(in_array($group_no,$backToSchool_only)&&!isset($_SESSION["backToSchool"]))
				{
					/****/
					$out[$products_id]= false;
				}
				else 
				{
					$out[$products_id]["bonus"]=price_policy_bonus_all($products_id, $orginal_price, $results['policy_no'],$results['policy_ref'],$results["fixed"]);							
					
				}
					
			}
			elseif (strrpos($results['policy_ref'],'GROUP')>-1)
			{
		
				
				if(strrpos($results['policy_ref'],'_')>-1)
				{
					$group_no = explode("_",$results['policy_ref']);
					$group_no = $group_no[1];
					
				}
			
				if(in_array($group_no,$backToSchool_only)&&!isset($_SESSION["backToSchool"]))
				{
					/**/
				//	$out[$products_id]= false;
				
				}
				else 
				{
		
					$price=price_policy_bonus_group($products_id, $orginal_price, $results['policy_no'],$results['policy_ref']);
					$out[$products_id][]=  $price;
					if($results["fixed"]=="Y")
					{
						$out[$products_id]["fixed"]=  $price;
					}
					
						

				}
			}
		
		
		} 
		 
	
		return $out;
	}
	
	 
}



  }

  