<?php 
namespace Test;

require_once './autoload.php';

use Model\MLhuillierModel as MLhuillier;


class TransactionModelTest  extends \PHPUnit_Framework_TestCase
{
   
  private $model;

  public function __construct() 
  {
		
  }
  	
  /**
   * [Test Case for PAID status in GetRemittance Method]
   */
  public function  testGetRemittancePaid() 
  {
    
    $postParam = array(
            'model' => 'MLhuillier',
            'operation' => 'transactionTest',           
            'sessionID' => '2',
            'username' => 'manish',
            'password' => 'pass',
            'refNo' => '502000098',
            'signature'=> 'fasdfsadf');
    
    $this->model = new MLhuillier($postParam);

    $expected= '2|1';

    
    $this->model->showRemittanceDetail();
    $result = $this->model->getReturn();

    $this->assertEquals($expected, $result);
    
  }

  /**
   * [Test Case for Approved status in GetRemittance Method]
   */
  public function testGetRemittanceApproved()
  {
    $postParam = array(
            'model' => 'MLhuillier',
            'operation' => 'transactionTest',           
            'sessionID' => '2',
            'username' => 'manish',
            'password' => 'pass',
            'refNo' => '502000008',
            'signature'=> 'fasdfsadf');    

    $this->model = new MLhuillier($postParam);
    $expected='2|0|502000008|20.00|US Dollar|Ali|Nadia||687 Main|';

    $this->model->showRemittanceDetail();
    $result = $this->model->getReturn();    

    $this->assertEquals($expected,$result);
  }

  /**
   * [Test Case for Other status like (cancelled deleted void hold) in GetRemittance Method]
   */
  public function testGetRemittanceOther()
  {
    $postParam = array(
            'model' => 'MLhuillier',
            'operation' => 'transactionTest',           
            'sessionID' => '2',
            'username' => 'manish',
            'password' => 'pass',
            'refNo' => '502000039',
            'signature'=> 'fasdfsadf');
    
    $this->model = new MLhuillier($postParam);
    $expected = '2|3';    
 
    $this->model->showRemittanceDetail();
    $result = $this->model->getReturn();
     
    $this->assertEquals($expected,$result);
  }

  public function  testupdateStatusPaid() 
  {
    $postParam = array(
            'model' => 'MLhuillier',
            'operation' => 'transactionTest',           
            'sessionID' => '2',
            'username' => 'manish',
            'password' => 'pass',
            'refNo' => '502000098',
            'signature'=> 'fasdfsadf');
    
    $this->model = new MLhuillier($postParam);
    $expected='2|2';

    $this->model->inquireTagAsCompleted();
    $result = $this->model->getReturn();
        
    $this->assertEquals($expected,$result);
    
  }

  /**
   * [Test Case for Approved status in updateStatus Method]
   * @todo update checking
   */
  public function ptestupdateStatusApproved()
  {
    $postParam = array(
            'model' => 'MLhuillier',
            'operation' => 'transactionTest',           
            'sessionID' => '2',
            'username' => 'manish',
            'password' => 'pass',
            'refNo' => '6100000001',
            'traceNo'=>'T743',
            'signature'=> 'fasdfsadf');
    
    $this->model = new MLhuillier($postParam);
    $expected = '';
   
    
   $this->model->inquireTagAsCompleted();
    $result = $this->model->getReturn();  
    $this->assertEquals($expected,$result);
  }

  /**
   * [Test Case for Other status like (cancelled deleted void hold) in updateStatus Method]
   */
  public function testupdateStatusOther()
  {
    $postParam = array(
            'model' => 'MLhuillier',
            'operation' => 'transactionTest',           
            'sessionID' => '2',
            'username' => 'manish',
            'password' => 'pass',
            'refNo' => '502000039',
            'traceNo'=>'123',
            'signature'=> 'fasdfsadf');
    
    $this->model = new MLhuillier($postParam);

    $expected ='2|3';    
    
    $this->model->inquireTagAsCompleted();
    $result = $this->model->getReturn(); 
    
    $this->assertEquals($expected,$result);
  }

  public function testCheckStatusOther()
  {
    $postParam = array(
            'model' => 'MLhuillier',
            'operation' => 'transactionTest',           
            'sessionID' => '2',
            'username' => 'manish',
            'password' => 'pass',
            'refNo' => '502000039',
            'traceNo'=>'123',
            'signature'=> 'fasdfsadf');
    
    $this->model = new MLhuillier($postParam);

    $expected = '2|3';

    $this->model->tagAsCompleted();
    $result = $this->model->getReturn(); 
       
    $this->assertEquals($expected,$result);
  }

  public function testCheckStatusPaid()
  {
    $postParam = array(
            'model' => 'MLhuillier',
            'operation' => 'transactionTest',           
            'sessionID' => '2',
            'username' => 'manish',
            'password' => 'pass',
            'refNo' => '502000098',
            'traceNo'=>'123',
            'signature'=> 'fasdfsadf');
    
    $this->model = new MLhuillier($postParam);

    $expected = '2|0|123|502000098|200.00|US Dollar|Bhjkgfj|Teest||Ertertwe|zero';
    
    $this->model->tagAsCompleted();
    $result = $this->model->getReturn();     
    $this->assertEquals($expected,$result);
  }
  

  public function testTransactionExistsWithCorrectRefNo()
  {
    $postParam = array(
            'model' => 'MLhuillier',
            'operation' => 'transactionTest',           
            'sessionID' => '2',
            'username' => 'manish',
            'password' => 'pass',
            'refNo' => '502000098',
            'traceNo'=>'123',
            'signature'=> 'fasdfsadf');
    
    $this->model = new MLhuillier($postParam);

    $expected=True;
    $result = $this->model->checkRefNoTransactionExists('502000098');
    $this->assertEquals($expected,$result);
  }
  public function testTransactionExistsWithoutCorrectRefNo()
  {
    $postParam = array(
            'model' => 'MLhuillier',
            'operation' => 'transactionTest',           
            'sessionID' => '2',
            'username' => 'manish',
            'password' => 'pass',
            'refNo' => '502000098',
            'traceNo'=>'123',
            'signature'=> 'fasdfsadf');
    
    $this->model = new MLhuillier($postParam);

    $expected=False;
    $result = $this->model->checkRefNoTransactionExists('manisfasfh');
    $this->assertEquals($expected,$result);
  }


  
    
}

?>