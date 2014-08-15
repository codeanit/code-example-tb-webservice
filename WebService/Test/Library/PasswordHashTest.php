<?php 
/**
 * First Global Data Corp.
 *
 * @category DEX_API
 * @package  Api\WebServiceBundle\Tests\Controller
 * @author   Anit Shrestha Manandhar <ashrestha@firstglobalmoney.com>
 * @license  http://firstglobalmoney.com/license description
 * @version  v1.0.0
 * @link     (remittanceController, http://firsglobaldata.com)
 */

namespace Test\Library;

require_once './autoload.php';

use Library\PasswordHash as PasswordHash;
use  Model\UserModel as User;


/**
 * User Entity
 *
 * @category DEX_API
 * @package  Api\WebServiceBundle\Tests\Controller
 * @author   Anit Shrestha Manandhar <ashrestha@firstglobalmoney.com>
 * @license  http://firstglobalmoney.com/license Usage License
 * @version  v1.0.0
 * @link     http://firsglobaldata.com
 */
class PasswordHashTest  extends \PHPUnit_Framework_TestCase
{

    /**
    * Test Password_Verify() from PasswordHash Class
    *  
    * @return void
    */
   
    public function ptestPasswordHashPasswordVerifyMethodWithCorrectPassword()
    {
        $this->hashObj= new PasswordHash();
        $this->output = $this->hashObj->password_verify('123456', '$2y$10$WgHIzfIaMvwVyKJBoqfuzOpEWJ1m/vYjHkonbqjlym6M21Z0h0inO');
        $this->assertTrue($this->output, 'Password and Hash Donot Match.');
    }

    /**
     *  Test Password_Verify method with Bad password
     *  
     * @return void
     */
    public function ptestPasswordHashPasswordVerifyMethodWithInCorrectPassword()
    {
        $this->hashObj= new PasswordHash();
        $this->output = $this->hashObj->password_verify('123', '$2y$10$WgHIzfIaMvwVyKJBoqfuzOpEWJ1m/vYjHkonbqjlym6M21Z0h0inO');
        $this->assertFalse($this->output, 'Password and Hash Matched.');
    }

    /**
     * Test User Model
     * 
     * @return void
     */
    public function testUserModelAuthenticateUser()
    {
        $userObj = new User();
        $this->output=$userObj->authenticateUser('ALIAHMED', '123456');   
        $this->assertTrue($this->output, 'Authentication Failed.');     

    }

    /**
     * Test User Model with bad username 
     *
     * @return  void
     */
    public function testUserModelAuthenticateUserWithBadUser()
    {
        $userObj = new User();
        $this->output=$userObj->authenticateUser('ALIAHMEDasfasf', '123456');   
        $this->assertFalse($this->output, 'Authentication Success.');     

    }
}
   