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

abstract class WebServiceModel
{
    protected $return;

    protected $parameter;

    abstract protected function formatReturnData($test);

    abstract protected function getUnAuthorizedData();

    /**
     * [main description]
     * 
     * @param  [type] $functionName [description]
     * @param  array  $param        [description]
     * @return [type]               [description]
     */
    public function execute()
    {
        
        // return $this->parameters;
        // $authStatus = $this->isAuthorized($param['username'], $param['password']);

        // if ($authStatus == false) {
        //        
        //         return $this->convertToString($resultData);             
        // } else {           
            
        //     if ($this->checkRefNoTransactionExists($param['refNo'])  == true) {           
        //         $resultData = $this->{$functionName}($param);

        //     } else {               
        //         $resultData = array('sessionID' => $param['sessionID'], 'status'=>'4');
        //     }

        //     return $this->convertToString($resultData);
        // }
        
        // call the function 
        $operation = $this->parameters['operation'];
        $this->$operation();
        $this->formatReturnData();
    }

    public function getReturn()
    {
        return $this->return;
    }
}
