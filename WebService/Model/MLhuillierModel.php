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

class MLhuillierModel extends WebService
{

    private $transactionObj;
    private $check;

    public function __construct($postParameters)
    {
        $this->parameters = $postParameters;
        $this->transactionObj = new Transaction();
        $this->check = $this->checkRefNoTransactionExists($postParameters['refNo']);
    }

    /**
     * Show remittance details.
     * 
     * @return void
     */
    public function showRemittanceDetail()
    {              
        if($this->check==true)
            {
                if ($this->return['status'] == 'approved') {
                    $this->formatReturnData('get');            

                } elseif ($this->return['status'] == 'paid') {
                    $this->return = $this->parameters['sessionID'].'|1';          

                } else {
                    $this->return = $this->parameters['sessionID'] .'|3';           
                }
            }

    }

    public function tagAsCompleted()
    {
        if($this->check==true)
            {
                if ($this->return['status'] == 'approved') {
                    $this->transactionObj->connection->update('f1_transactions', array('status' => 'paid'), array('control_number' => $this->return['control_number']));
                    $this->formatReturnData('update');


                } elseif ($this->return['status'] == 'paid') {
                    $this->return = $this->parameters['sessionID'].'|2';            

                } else {
                    $this->return = $this->parameters['sessionID'].'|3';   
                            
                }
            }
    }

    public function inquireTagAsCompleted()
    {
        if($this->check==true)
            {
                if ($this->return['status'] == 'paid') {
                    $this->formatReturnData('check');
                } else {
                    $this->return = $this->parameters['sessionID'].'|3';              
                }
            }
    }

    public function checkRefNoTransactionExists($refNo)
    {
        $this->return = $this->transactionObj->connection->fetchAssoc('SELECT c.name,f.status,f.control_number,f.remitting_amount,fc.firstName,fc.lastName,fc.middleName,fc.mobile,fc.street FROM f1_transactions f JOIN f1_customer fc ON fc.id=f.beneficiary_id JOIN f1_currencies c ON c.id=f.receiving_currency_id WHERE f.control_number = ?', array($refNo));
        $state=count($this->return);
        if($state<2)
            {
                $this->return = $this->parameters['sessionID'].'|4';

            }
        return ($state<2)?false:true;
    }

    public function getUnAuthorizedData()
    {
          $this->return  = $this->parameters['sessionID'] .'|5';
    }

    /**
     * Set return data
     *
     *  @return void
     */
    public function formatReturnData($type)
    {
        if($type=='update')
        {
                $this->return=$this->parameters['sessionID'].'|0|'.$this->parameters['traceNo'].'|'.$this->return['control_number'].'|'.$this->return['remitting_amount'].'|'.$this->return['name'].'|'.$this->return['lastName'].'|'.$this->return['firstName'].'|'.
                $this->return['middleName'].'|'.$this->return['street'].'|zero'; 
        }
        if($type=='get')
        {
                $this->return= $this->parameters['sessionID'].'|0|'.$this->return['control_number'].'|'.$this->return['remitting_amount'].'|'.$this->return['name'].'|'.$this->return['lastName'].'|'.$this->return['firstName'].'|'.
                $this->return['middleName'].'|'.$this->return['street'].'|'.$this->return['mobile'];
        }
        if($type=='check')
        {
                $this->return=$this->parameters['sessionID'].'|0|'.$this->parameters['traceNo'].'|'.$this->return['control_number'].'|'.$this->return['remitting_amount'].'|'.$this->return['name'].'|'.$this->return['lastName'].'|'.$this->return['firstName'].'|'.
                $this->return['middleName'].'|'.$this->return['street'].'|zero';
        }
         
    }

    public function getReturn()
    {
        return $this->return;
    }
}
