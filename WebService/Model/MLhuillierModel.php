<?php

/**
 * First Global Data
 *
 * @category DEX_API
 * @package  Api\WebServiceBundle\Tests\Controller
 * @author   Anit Shrestha Manandhar <ashrestha@firstglobalmoney.com>
 * @license  http://firstglobalmoney.com/license description
 * @version  v1.0.0
 * @link     (remittanceController, http://firsglobaldata.com)
 */

namespace Model;

use Model\TransactionModel as Transaction;
use Model\WebServiceModel as WebService;
use Model\UserModel as User;


/**
 * Bridge to call TB DBAL
 *
 * @category DEX_API
 * @package  Api\WebServiceBundle\Tests\Controller
 * @author   Anit Shrestha Manandhar <ashrestha@firstglobalmoney.com>
 * @license  http://firstglobalmoney.com/license Usage License
 * @version  v1.0.0
 * @link     (remittanceController, http://firsglobaldata.com)
 */

class MLhuillierModel extends WebService
{

    private $_transactionObj;
    private $_check;

    /**
     * If sets Dex parameter to $parameter variable and checks if the transaction existes for refNo from that parameter 
     * 
     * @param array $postParameters Dex parameter  
     *
     * @return void
     */
    public function __construct($postParameters)
    {
        $this->parameters = $postParameters;
        $this->_transactionObj = new Transaction();
        $this->_check = $this->checkRefNoTransactionExists($postParameters['refNo']);
    }

    /**
     * Show remittance details.
     * 
     * @return void
     */
    public function showRemittanceDetail()
    {              
        if ($this->_check==true) {

            if ($this->return['status'] == 'approved') {
                    $this->formatReturnData('get');  

            } elseif ($this->return['status'] == 'paid') {
                    $this->return = $this->parameters['sessionID'].'|1';      

            } else {
                    $this->return = $this->parameters['sessionID'] .'|3';           
            }
        }

    }

    /**
     * Checks if status is approved then updates status to Paid 
     * 
     * @return void
     */
    public function tagAsCompleted()
    {
        if ($this->_check==true) {

            if ($this->return['status'] == 'approved') {
                    $this->_transactionObj->connection->update('f1_transactions', array('status' => 'paid'), array('control_number' => $this->return['control_number']));
                    $this->formatReturnData('update');


            } elseif ($this->return['status'] == 'paid') {
                    $this->return = $this->parameters['sessionID'].'|2';            

            } else {
                    $this->return = $this->parameters['sessionID'].'|3';   
                            
            }
        }
    }
    /**
     * It checks if status is Paid or not in Transaction Table 
     * 
     * @return void
     */
    public function inquireTagAsCompleted()
    {
        if ($this->_check==true) {

            if ($this->return['status'] == 'paid') {
                    $this->formatReturnData('check');
            } else {
                    $this->return = $this->parameters['sessionID'].'|1';              
            }
        }
    }

    /**
     * [checkRefNoTransactionExists description]
     * 
     * @param varchar $refNo reference number
     * 
     * @return void 
     */
    public function checkRefNoTransactionExists($refNo)
    {
        $this->return = $this->_transactionObj->connection->fetchAssoc('SELECT c.name,f.status,f.control_number,f.remitting_amount,fc.firstName,fc.lastName,fc.middleName,fc.mobile,fc.street FROM f1_transactions f JOIN f1_customer fc ON fc.id=f.beneficiary_id JOIN f1_currencies c ON c.id=f.receiving_currency_id WHERE f.control_number = ?', array($refNo));
        $state=count($this->return);
        if ($state<2) {
                $this->return = $this->parameters['sessionID'].'|4';
        }
        return ($state<2)?false:true;
    }

    /**
     * Set return data to error code 5 for incorrect username and password
     * 
     * @return void
     */
    public function getUnAuthorizedData()
    {
        if ($this->parameters['operation']=='changePassword') {
            $this->return =$this->parameters['sessionID'] .'|1';            
        } else {
            $this->return =$this->parameters['sessionID'] .'|5';
        }
    }

    /**
     * sets return variable to Mulhiller formated string according to $type
     *
     * @param string $type update/get/check
     * 
     *  @return void
     */
    public function formatReturnData($type)
    {
        if ($type=='update') {
                $this->return=$this->parameters['sessionID'].'|0|'.$this->parameters['traceNo'].'|'.$this->return['control_number'].'|'.$this->return['remitting_amount'].'|'.$this->return['name'].'|'.$this->return['lastName'].'|'.$this->return['firstName'].'|'.
                $this->return['middleName'].'|'.$this->return['street'].'|zero'; 
        }
        if ($type=='get') {
                $this->return= $this->parameters['sessionID'].'|0|'.$this->return['control_number'].'|'.$this->return['remitting_amount'].'|'.$this->return['name'].'|'.$this->return['lastName'].'|'.$this->return['firstName'].'|'.
                $this->return['middleName'].'|'.$this->return['street'].'|'.$this->return['mobile'];
        }
        if ($type=='check') {
                $this->return=$this->parameters['sessionID'].'|0|'.$this->parameters['traceNo'].'|'.$this->return['control_number'].'|'.$this->return['remitting_amount'].'|'.$this->return['name'].'|'.$this->return['lastName'].'|'.$this->return['firstName'].'|'.
                $this->return['middleName'].'|'.$this->return['street'].'|zero';
        }
         
    }

    /**
     * [changePassword description]
     * 
     * @return [type] [description]
     */
    public  function changePassword() 
    {
        if ($this->parameters['newPassword'] !=' ') {
            $user = new User();
            $status=$user->changePassword($this->parameters['username'], $this->parameters['newPassword']); 
            if ($status == true) {
                $this ->return =$this->parameters['sessionID'].'|0';
            } else {
                $this->return = 'error in changing password';
            }         

        }

    }

    /**
     * set return data 
     * 
     * @return string 
     */
    public function getReturn()
    {
        return $this->return;
    }
}
