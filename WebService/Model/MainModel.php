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

namespace Model;

use \Doctrine\DBAL\Configuration as Configuration;
use \Doctrine\DBAL\DriverManager as DriverManager;

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

abstract class MainModel
{
    protected $parameters;

    /**
     * $connection object
     *
     * @var Object
     */
    public $connection;

    /**
     * [Database Abstraction Layer Connection]
     *
     * @return [Object]
     *
     * @todo get the database config data from database.php
     */
    public function __construct()
    {
        $config = new Configuration();
        $connectionParams = array(
            'dbname' => 'fgmtest1',
            'user' => 'root',
            'password' => '',
            'host' => 'localhost',
            'driver' => 'pdo_mysql'
        );
        $this->connection = DriverManager::getConnection($connectionParams, $config);        
    }

}
