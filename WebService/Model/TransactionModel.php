<?php
/**
 * First Global Data
 *
 * @category API
 * @package  Api
 * @author   Anit Shrestha Manandhar <ashrestha@firstglobalmoney.com>
 * @license  http://firstglobalmoney.com/license description
 * @version  v1.0.0
 * @link     (remittanceController, http://firsglobaldata.com)
 */

namespace Model;

use  Model\MainModel as Main;


/**
 * Active Records Class
 *
 * @category API
 * @package  Api
 * @author   Anit Shrestha Manandhar <ashrestha@firstglobalmoney.com>
 * @license  http://firstglobalmoney.com/license Usage License
 * @version  v1.0.0
 * @link     (remittanceController, http://firsglobaldata.com)
 */

class TransactionModel extends Main
{
    
    function __construct() {
		parent::__construct();    	
    }



}
