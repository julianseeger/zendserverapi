<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link           http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright      Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license        http://framework.zend.com/license/new-bsd New BSD License
 * @package        Zend_Service
 */

namespace ZendService\ZendServerAPI;

/**
 * <b>Class for server configuration validation</b>
 *
 * <pre>This is used to validate the config.php settings</pre>
 *
 * @license        http://framework.zend.com/license/new-bsd New BSD License
 * @link           http://github.com/zendframework/zf2 for the canonical source repository
 * @author         Ingo Walz <ingo.walz@googlemail.com>
 * @category       Zend
 * @package        Zend_Service
 * @subpackage     ZendServerAPI
 */
class ConfigValidator implements PluginInterface
{
    /**
     * The config for the connections
     * @var array
     */
    private $config = null;
    /**
     * Path to config
     * @var string
     */
    private $fileName = null;

    /**
     * Constructor for ConfigValidation
     *
     * @param  string            $fileName
     * @throws \RuntimeException if config file is not found
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
        if(!is_file($this->fileName))
            throw new \RuntimeException($this->fileName . " not found");
        $this->config = include $fileName;
    }

    /**
     * Get the config array
     *
     * @param  string $name <p>Name for the current config</p>
     * @return array
     */
    public function getConfig($name)
    {
        $this->validate($name);

        return $this->config['servers'][$name];
    }

    /**
     * Get settings array
     *
     * @return array
     */
    public function getSettings()
    {
        $this->validateSettings($this->config);

        return $this->config['settings'];
    }

    /**
     * Test for existing settings section and valid values
     *
     * @param  array             $config Config array
     * @throws \RuntimeException If settings section is missing
     * @return void
     */
    private function validateSettings(&$config)
    {
        if(!isset($config['settings']))
            throw new \RuntimeException('settings section in config file is missing');

        if (isset($config['settings']['loglevel'])) {
            $validEntries = array(
                    \Zend\Log\Logger::ALERT,
                    \Zend\Log\Logger::CRIT,
                    \Zend\Log\Logger::DEBUG,
                    \Zend\Log\Logger::EMERG,
                    \Zend\Log\Logger::ERR,
                    \Zend\Log\Logger::INFO,
                    \Zend\Log\Logger::NOTICE,
                    \Zend\Log\Logger::WARN);

            if (!in_array($config['settings']['loglevel'], $validEntries, true)) {
                throw new \RuntimeException($config['settings']['loglevel'] . ' is not a valid entry for the loglevel');
            }
        } else {
            $config['settings']['loglevel'] = \Zend\Log\Logger::CRIT;
        }
    }

    /**
     * Validate all required parameters for the Zend Server API connection
     *
     * @param  string                    $name Name for the config section to use
     * @throws \InvalidArgumentException If error in config array
     * @return void
     */
    private function validate($name)
    {
        // Couldn't parse config
        if(!isset($this->config['servers'][$name]))
            throw new \InvalidArgumentException("Configuration part '".$name."' not found in: " . $this->fileName);

        // Check for apikeys in the configfile
        if(
                isset($this->config['servers'][$name]['fullApiKey']) &&
                $this->config['servers'][$name]['fullApiKey'] !== ""
        )
        {
            $state = ApiKey::FULL;
            $key = $this->config['servers'][$name]['fullApiKey'];
        } elseif(
                isset($this->config['servers'][$name]['readApiKey']) &&
                $this->config['servers'][$name]['readApiKey'] !== ""
        )
        {
            $state = ApiKey::READONLY;
            $key = $this->config['servers'][$name]['readApiKey'];
        } else
            throw new \InvalidArgumentException($name . " does not seem to have an apikey included");

        $this->checkForValidAPIKey($key);

         $this->config['servers'][$name]['key'] = $key;
         $this->config['servers'][$name]['state'] = $state;

         if(
                 !isset($this->config['servers'][$name]['apiName']) ||
                 !$this->config['servers'][$name]['apiName']
            )
             throw new \InvalidArgumentException("apiName is not part of the config from " . $name);

         if(
                 !isset($this->config['servers'][$name]['host']) ||
                 !$this->config['servers'][$name]['host']
         )
             throw new \InvalidArgumentException("host not specified in " . $name);

         if(
                 isset($this->config['servers'][$name]['protocol']) &&
                 !(strtolower($this->config['servers'][$name]['protocol']) == "http" ||
                 strtolower($this->config['servers'][$name]['protocol']) == "https")
        )
             throw new \InvalidArgumentException("Protocol must be either http or https");

    }

    /**
     * api key value validation
     *
     * @param  string                    $apiKey The apikey to validate
     * @throws \InvalidArgumentException
     * @return void
     */
    private function checkForValidAPIKey($apiKey)
    {
        // Check invalid characters
        $invalidCharacters = array(
                '(',
                ')',
                '<',
                '>',
                ',',
                ';',
                ':',
                '\\',
                ',',
                '/',
                '[',
                ']',
                '?',
                '=',
                '{',
                '}'
        );

        foreach ($invalidCharacters as $invalidCharacter) {
            if(strpos($apiKey, $invalidCharacter) !== FALSE)
                throw new \InvalidArgumentException("Character '".$invalidCharacter."' detected in API Key");
        }

        // Check size
        if(strlen($apiKey) !== 64)
            throw new \InvalidArgumentException("API Key must contains 64 characters");
    }

}
