<?php
/**
 * @package Configuration 
 * @author Amadi Ifeanyi <amadiify.com>
 * 
 * Simple global configuration class
 */
class Configuration
{
    /**
     * @var string $mode 
     * Can either be development or live
     */
    const MODE = 'development';

    /**
     * @var string $host
     */
    const HOST = 'frontdesk.test';

    /**
     * @method Configuration database
     * @return object
     * 
     * Returns the default database configuration
     */
    public static function database() : object 
    {
        // @var array $config
        $config = [

            // development connection settings
            'development' => [
                'host' => 'localhost',
                'user' => 'root',
                'pass' => '',
                'name' => 'tripmata'
            ],

            // live connection settings
            'live' => [
                'host' => 'localhost',
                'user' => 'tripmata_user',
                'pass' => 'p@$$word@2020',
                'name' => 'tripmata_database',
            ]
        ];

        // return config
        return self::getObject($config);
    }

    /**
     * @method Configuration url
     * @return object
     * 
     * Returns the default url configuration
     */
    public static function url() : object 
    {
        // @var array $config
        $config = [
            
            // development url configuration
            'development' => [
                'host'      => '',
                'storage'   => 'http://frontdesk.test/Storage/',
                'messaging' => 'http://services.tripmata.net/Messaging/',
                'origin'    => 'http://tripmata.net/',
                'domain'    => 'http://frontdesk.test/FrontDeskServices/'
            ],

            // live url configuration
            'live' => [
                'host'      => '',
                'storage'   => 'http://cdn.tripmata.net/frontdesk/',
                'messaging' => 'http://services.tripmata.net/Messaging/',
                'origin'    => 'http://tripmata.net/', // should be tripmata.com
                'domain'    => 'http://services.tripmata.net/FrontDeskServices/', // should be frontdeskservice.tripmata.com 
            ]
        ];

        // return config
        return self::getObject(self::getUrlConfigFromRequestHeader($config));
    }

    /**
     * @method Configuration getObject
     * @param array $config
     * @return object
     * 
     * Returns configuration as an object, conditioned to the default MODE
     */
    private static function getObject(array $config) : object 
    {
        // get mode
        $mode = Configuration::MODE;

        // read http_host
        if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], self::HOST) === false) $mode = 'live';  

        // return configuration as an object
        return (object) (isset($config[$mode]) ? $config[$mode] : $config['development']);
    }

    /**
     * @method Configuration getUrlConfigFromRequestHeader
     * @param array $config
     * @return array
     * 
     * This method would check for configuration settings in the request header, and update the default configuration with it.
     */
    private static function getUrlConfigFromRequestHeader(array $config) : array
    {
        // get url configuration if sent via the request header
        if (function_exists('getallheaders')) :

            // get all headers
            $headers = getallheaders();

            // check for x-url-config
            if (isset($headers['x-url-config'])) :

                // read json data
                $jsonData = json_decode($headers['x-url-config']);

                // continue if it's an object
                if (is_object($jsonData) && isset($config[Configuration::MODE])) :

                    // get current config
                    $currentConfig = $config[Configuration::MODE];

                    // check for host
                    $currentConfig['host'] = isset($jsonData->host) ? $jsonData->host : $currentConfig['host'];

                    // check for storage
                    $currentConfig['storage'] = isset($jsonData->storage) ? $jsonData->storage : $currentConfig['storage'];

                    // check for messaging
                    $currentConfig['messaging'] = isset($jsonData->messaging) ? $jsonData->messaging : $currentConfig['messaging'];

                    // set now
                    $config[Configuration::MODE] = $currentConfig;

                endif;

            endif;

        endif;

        // return array
        return $config;
    }
}