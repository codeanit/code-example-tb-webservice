<?php 
namespace Test;

require_once './autoload.php';

use Model\UserModel as User;
use PHPUnit\Framework\TestCase as TestCase;

class SampleTest  extends \PHPUnit_Framework_TestCase
{

  /**
   * [Test Case for PAID status in GetRemittance Method]
   */
  public function  testChangePassword() 
  {
    $user = new User();

    $output = $user->changePassword('40162', '123456', 'manish') ;

    if($output==true)
    {
      $check = $user->authenticateUser('40162', '123456');
    }
    
    $this->assertFalse($check);
  }

}

   