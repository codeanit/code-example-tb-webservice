<?php 
namespace Test;

require_once './autoload.php';

use Model\MLhuillierModel as MLhuillier;
use PHPUnit\Framework\TestCase as TestCase;

class SampleTest  extends \PHPUnit_Framework_TestCase
{

    public function setUp(){ }
    public function tearDown(){ }


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

    // $expected= array('sessionID' => 2, 'status'=> 1);

    
    // $this->model->showRemittanceDetail();
    // $result = $this->model->getReturn();
var_dump($this->model->connection);
    $this->assertEquals($expected =1, $result =1);
    
  }

}

   