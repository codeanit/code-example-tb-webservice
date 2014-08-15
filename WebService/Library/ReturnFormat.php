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

namespace WebService;

/**
 * Format the return type
 *
 * @category API
 * @package  Api
 * @author   Anit Shrestha Manandhar <ashrestha@firstglobalmoney.com>
 * @license  http://firstglobalmoney.com/license Usage License
 * @version  v1.0.0
 * @link     (remittanceController, http://firsglobaldata.com)
 */

class ReturnFormat
{

    private $_parameter;
    private $_formattedReturnData;

    public function __construct(array $param, $functionName)
    {
        $formatFunction = "_format" .  $functionName;
        $this->_parameter = $param;
        $this->$formatFunction();
    }

    
}
