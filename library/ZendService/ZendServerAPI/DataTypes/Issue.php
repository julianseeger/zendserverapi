<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link           http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright      Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license        http://framework.zend.com/license/new-bsd New BSD License
 * @package        Zend_Service
 */

namespace ZendService\ZendServerAPI\DataTypes;

/**
 * Issue model implementation.
 *
 * @license        http://framework.zend.com/license/new-bsd New BSD License
 * @link           http://github.com/zendframework/zf2 for the canonical source repository
 * @author         Ingo Walz <ingo.walz@googlemail.com>
 * @category       Zend
 * @package        Zend_Service
 * @subpackage     ZendServerAPI
 */
class Issue extends DataType
{
    /**
     * Issue identifier
     * @var int
     */
    protected $id = null;
    /**
     * Issue's rule name
     * @var string
     */
    protected $rule = null;
    /**
     * Number of event occurance
     * @var int
     */
    protected $count = null;
    /**
     * Issue's last time of manifestation
     * @var string
     */
    protected $lastOccurance = null;
    /**
     * Issue's severity( Warning | Error)
     * @var string
     */
    protected $severity = null;
    /**
     * Issue's current status
     * @var string
     */
    protected $status = null;
    /**
     * General details (not an own datatype in the doc)
     * @var \ZendService\ZendServerAPI\DataTypes\GeneralDetails
     */
    protected $generalDetails = null;
    /**
     * Route details for the issue and the request that created it
     * @var array
     */
    protected $routeDetails = array();

    /**
     * Get the issue identifier
     *
     * @return int
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * Get the issue's rule name
     *
     * @return string
     */
    public function getRule ()
    {
        return $this->rule;
    }

    /**
     * Get the number of occurance
     *
     * @return int
     */
    public function getCount ()
    {
        return $this->count;
    }

    /**
     * Get the issue's last time of manifestation
     * (as timestamp)
     *
     * @return string
     */
    public function getLastOccurance ()
    {
        return $this->lastOccurance;
    }

    /**
     * Get the issue's severity( Warning | Error)
     *
     * @return string
     */
    public function getSeverity ()
    {
        return $this->severity;
    }

    /**
     * Get the issue's current status
     *
     * @return string
     */
    public function getStatus ()
    {
        return $this->status;
    }

    /**
     * Get the general details
     * (Not an own datatype within Zend Server - but should)
     *
     * @return \ZendService\ZendServerAPI\DataTypes\GeneralDetails
     */
    public function getGeneralDetails ()
    {
        return $this->generalDetails;
    }

    /**
     * Get the route details for the issue and the request that created
     *
     * @return array
     */
    public function getRouteDetails()
    {
        return $this->routeDetails;
    }

    /**
     * Set the issue identifier
     *
     * @param  int  $id
     * @return void
     */
    public function setId ($id)
    {
        $this->id = (int) $id;
    }

    /**
     * Set the issue's rule name
     *
     * @param  string $rule
     * @return void
     */
    public function setRule ($rule)
    {
        $this->rule = $rule;
    }

    /**
     * Set the number of event occurance
     *
     * @param  int  $count
     * @return void
     */
    public function setCount ($count)
    {
        $this->count = (int) $count;
    }

    /**
     * Set the issue's last time of manifestation
     * (as timestamp)
     *
     * @param  string $lastOccurance
     * @return void
     */
    public function setLastOccurance ($lastOccurance)
    {
        $this->lastOccurance = $lastOccurance;
    }

    /**
     * Set the issue's severity( Warning | Error)
     *
     * @param  string $severity
     * @return void
     */
    public function setSeverity ($severity)
    {
        $this->severity = $severity;
    }

    /**
     * Set the issue's current status
     *
     * @param  string $status
     * @return void
     */
    public function setStatus ($status)
    {
        $this->status = $status;
    }

    /**
     * Set the general details
     * (Not an own datatype within Zend Server)
     *
     * @param  \ZendService\ZendServerAPI\DataTypes\GeneralDetails $generalDetails
     * @return void
     */
    public function setGeneralDetails (\ZendService\ZendServerAPI\DataTypes\GeneralDetails $generalDetails)
    {
        $this->generalDetails = $generalDetails;
    }

    /**
     * Add a route detail
     *
     * @param  \ZendService\ZendServerAPI\DataTypes\RouteDetails $routeDetails
     * @return void
     */
    public function addRouteDetails (\ZendService\ZendServerAPI\DataTypes\RouteDetails $routeDetails)
    {
        $this->routeDetails[] = $routeDetails;
    }
}
