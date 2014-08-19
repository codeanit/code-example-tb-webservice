<?php

/**
 * First Global Data Corp. Inc.
 *
 * @category DEX_API
 * @package  Api\WebServiceBundle\Tests\Controller
 * @author   Anit Shrestha Manandhar <ashrestha@firstglobalmoney.com>
 * @license  http://firstglobalmoney.com/license description
 * @version  v1.0.0
 * @link     (remittanceController, http://firsglobaldata.com)
 */

require_once 'autoload.php';

use  Model\ModelFactory as Factory;
use  Model\MLhuillierModel as MLhuillier;
use  Model\GCashModel as GCash;


// define('BASEPATH', 'DEXInterface');
define('DEX_SERVER_IP', '127.0.0.1');
/**
 * DEX webservice interface
 *
 * @category DEX_API
 * @package  Api\WebServiceBundle\Tests\Controller
 * @author   Anit Shrestha Manandhar <ashrestha@firstglobalmoney.com>
 * @license  http://firstglobalmoney.com/license Usage License
 * @version  v1.0.0
 * @link     (remittanceController, http://firsglobaldata.com)
 */
final class DEXInterface
{

    private $_return;
    /**
     * [__construct description]
     * 
     * @param array $postParam [description]
     *
     * @return void 
     */
    public function __construct(array $postParam)
    {
        if ($postParam['model'] == "MLhuillier") {
            $factory = new Factory(new MLhuillier($_POST));
            $this->_return = $factory->returnData();
        }
        if ($postParam['model'] == "GCash") {
            $factory = new Factory(new GCash($_POST));
            $this->_return = $factory->returnData();
        }                
    }

    /**
     * [getReturn description]
     * 
     * @return String String of data
     */
    public function getReturn()
    {
        return $this->_return;
    }

    /**
     * Check if the index.php is executed by DEX server.
     * 
     * @return [type] [description]
     */
    static function _checkRemoteAddress()
    {
        $remoteAddress = "";
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $remoteAddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $remoteAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $remoteAddress = $_SERVER['REMOTE_ADDR'];
        }

        return  $remoteAddress == DEX_SERVER_IP ? true : false;
    }

}

$return = "500 Error! Please try again!";

if ($_SERVER['REQUEST_METHOD'] == "POST" && DEXInterface::_checkRemoteAddress() == true  && $_POST['model'] != ' ') {
    $indexObj = new DEXInterface($_POST ); 
    $return = $indexObj->getReturn();
}
else {
    // TO DO
    // store ip
    // send email to system admin
 }

echo $return;


