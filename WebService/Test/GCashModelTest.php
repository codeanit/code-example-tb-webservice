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
namespace Test;

require_once './autoload.php';

use Model\GCashModel as GCash;
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

class GCashModelTest  extends \PHPUnit_Framework_TestCase
{
    /**
     * [$_model description]
     * 
     * @var [type]
     * 
     */
    private $_model;

    /**
     * Test Case for PAID status in GetRemittance Method
     * 
     * @return void
     */

    public function testGetRemittanceWithPaidRefNo() 
    {
        
        $postParam = array('refNo' => '502000098',);
            
        $this->_model = new GCash($postParam);
        $expected='502000098|1|200.00|Bhjkgfj|Teest||null|null|null|Ertertwe|' ;
        
        $this->_model->showRemittanceDetail();
        $result = $this->_model->getReturn();      
        $this->assertEquals($expected, $result);
    
    }

    /**
     * Test Case for Approved status in GetRemittance Method
     * 
     * @return void
     */
    public function testGetRemittanceWithApprovedRefNo()
    {
          $postParam = array('refNo' => '502000008');    

          $this->_model = new GCash($postParam);
          $expected='502000008|0|20.00|Ali|Nadia||null|null|null|687 Main|';

          $this->_model->showRemittanceDetail();
          $result = $this->_model->getReturn();    

          $this->assertEquals($expected, $result);
    }

    /**
     * Test Case for Other status like (cancelled deleted void hold) in GetRemittance Method
     * 
     * @return void
     */
    public function testGetRemittanceWithOtherRefNo()
    {
          $postParam = array('refNo' => '502000039',);
          
          $this->_model = new GCash($postParam);
          $expected = '3';    
       
          $this->_model->showRemittanceDetail();
          $result = $this->_model->getReturn();
           
          $this->assertEquals($expected, $result);
    }
    /**
     * Test Case for PAID status in TagAsComplete Method
     * 
     * @return void
     */

    public function testTagAsCompleteWithPaidRefNo() 
    {
        
        $postParam = array('refNo' => '502000098',);
            
        $this->_model = new GCash($postParam);
        $expected='2' ;
        
        $this->_model->tagAsCompleted();
        $result = $this->_model->getReturn();    
        
        $this->assertEquals($expected, $result);
    
    }

    /**
     * Test Case for Approved status in TagAsComplete Method
     * 
     * @return void
     */
    public function ptestTagAsCompleteWithApprovedRefNo()
    {
          $postParam = array('refNo' => '502000011','traceNo'=>'T77');    

          $this->_model = new GCash($postParam);
          $expected='';

          $this->_model->tagAsCompleted();
          $result = $this->_model->getReturn();    

          $this->assertEquals($expected, $result);
    }

    /**
     * Test Case for Other status like (cancelled deleted void hold) in TagAsComplete Method
     * 
     * @return void
     */
    public function testTagAsCompleteWithOtherRefNo()
    {
          $postParam = array('refNo' => '502000039','traceNo'=>'T77');
          
          $this->_model = new GCash($postParam);
          $expected = '3';    
       
          $this->_model->tagAsCompleted();
          $result = $this->_model->getReturn();
           
          $this->assertEquals($expected, $result);
    }

    /**
     * Test Case for PAID status in inquireTagAsCompleted Method
     * 
     * @return void
     */

    public function testInquireTagAsCompletedWithPaidRefNo() 
    {
        
        $postParam = array('refNo' => '502000098','traceNo'=>'T77');
            
        $this->_model = new GCash($postParam);
        $expected='T77|502000098|0|200.00|Bhjkgfj|Teest||null|null|null|Ertertwe|' ;       
        
        $this->_model->inquireTagAsCompleted();
        $result = $this->_model->getReturn();    
        
        $this->assertEquals($expected, $result);
    
    }

    /**
     * Test Case for Approved status in inquireTagAsCompleted Method
     * 
     * @return void
     */
    public function testInquireTagAsCompletedWithApprovedRefNo()
    {
          $postParam = array('refNo' => '502000011','traceNo'=>'T77');    

          $this->_model = new GCash($postParam);
          $expected='1';

          $this->_model->inquireTagAsCompleted();
          $result = $this->_model->getReturn();    

          $this->assertEquals($expected, $result);
    }
   
    /**
     * Check if refNo exists in Database
     * 
     * @return void
     */
    public function testTransactionExistsWithCorrectRefNo()
    {
        $postParam = array('refNo' => '');
        
        $this->model = new GCash($postParam);

        $expected=true;
        $result = $this->model->checkRefNoTransactionExists('502000098');
        $this->assertEquals($expected, $result);
    }

     /**
     * Check if refNo exists in Database
     * 
     * @return void
     */
    public function testTransactionExistsWithoutCorrectRefNo()
    {
        $postParam = array('refNo' => '');
        
        $this->model = new GCash($postParam);

        $expected=false;
        $result = $this->model->checkRefNoTransactionExists('manisfasfh');
        $this->assertEquals($expected, $result);
    }

    /**
     * [testChangePassword description]
     * 
     * @return [type] [description]
     */
    public function testChangePassword()
    {
        $postParam = array('refNo' => '','username'=>'AWARFA','newPassword'=>'123456');        
        $this->_model = new GCash($postParam);
        $this->_model->changePassword();
        $result = $this->_model->getReturn();
        $this->assertEquals('0', $result);
    }   
}

?>