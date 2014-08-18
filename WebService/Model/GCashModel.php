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

class GCashModel extends WebService
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
                    $this->formatReturnData('showApproved');  

            } elseif ($this->return['status'] == 'paid') {
                    $this->formatReturnData('showPaid');

            } else {
                    $this->return = '3';           
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
                    $this->return = '2';            

            } else {
                    $this->return = '3';   
                            
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
                    $this->formatReturnData('update');
            } else {
                    $this->return = '1';              
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
        $this->return = $this->_transactionObj->connection->fetchAssoc('SELECT f.status,f.control_number,f.remitting_amount,fc.firstName,fc.lastName,fc.middleName,fc.phone,fc.street FROM f1_transactions f JOIN f1_customer fc ON fc.id=f.beneficiary_id  WHERE f.control_number = ?', array($refNo));
        $state=count($this->return);
        if ($state<2) {
                $this->return = '4';
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
          $this->return  ='5';
    }

    /**
     * sets return variable to GCASH formated string according to $type
     *
     * @param string $type update/get/check
     * 
     *  @return void
     */
    public function formatReturnData($type)
    {
        if ($type=='showApproved') {
                $this->return=$this->return['control_number'].'|0|'.$this->return['remitting_amount'].'|'.$this->return['lastName'].'|'.$this->return['firstName'].'|'.
                $this->return['middleName'].'|null|null|null|'.$this->return['street'].'|'.$this->return['phone']; 
        }
        if ($type=='showPaid') {
                $this->return=$this->return['control_number'].'|1|'.$this->return['remitting_amount'].'|'.$this->return['lastName'].'|'.$this->return['firstName'].'|'.
                $this->return['middleName'].'|null|null|null|'.$this->return['street'].'|'.$this->return['phone']; 
        }
        if ($type=='update') {
                $this->return=$this->parameters['traceNo'].'|'.$this->return['control_number'].'|0|'.$this->return['remitting_amount'].'|'.$this->return['lastName'].'|'.
                $this->return['firstName'].'|'.$this->return['middleName'].'|null|null|null|'.$this->return['street'].'|'.$this->return['phone']; 
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
