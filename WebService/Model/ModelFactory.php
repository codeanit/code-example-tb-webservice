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

use Model\WebServiceModel as WebService;
use Model\UserModel as User;

/**
 * Remittance Controller Class
 *
 * @category DEX_API
 * @package  Api\WebServiceBundle\Tests\Controller
 * @author   Anit Shrestha Manandhar <ashrestha@firstglobalmoney.com>
 * @license  http://firstglobalmoney.com/license Usage License
 * @version  v1.0.0
 * @link     (remittanceController, http://firsglobaldata.com)
 */

class ModelFactory
{
    /**
     * asddsa
     * 
     * @var array S
     */
    private $_returnData;

    /**
     * adsasd
     * 
     * @param Main $obj Object of Main class sub-calsses
     */
    public function __construct(WebService $obj)
    { 
        
        $user = new User();        
        if ($user->authenticateUser($obj->parameters['username'], $obj->parameters['password'])) {
            $obj->execute();
            $this->_returnData = $obj->getReturn();
        } else {
            $obj->getUnAuthorizedData();
            $this->_returnData = $obj->getReturn();

        }
        
    }

    public function returnData() {
       return $this->_returnData; 
    }
}
