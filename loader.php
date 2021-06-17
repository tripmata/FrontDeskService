<?php
/**
 * @method spl_autoload_register
 * @author Amadi Ifeanyi <amadiify.com>
 * 
 * Autoload Classes and interfaces
 */
// constant to fetch for this month only
define('FETCH_FOR_THIS_MONTH_ONLY', '0x231t');

// load config file
require_once 'config.php';

// start here
spl_autoload_register(function(string $classOrInterface){

    // @var array $directories
    $directories = [
        'core/interfaces/', // base interface directory
        'core/Types/', // base directory for types
        'core/validation/', // base directory for validation
        'core/' // base core directory
    ];

    // now we ilterate through the list of directories
    foreach ($directories as $directory) :

        // create file path
        $filePath = $directory . $classOrInterface . '.php';

        // check if file exists
        if (file_exists($filePath)) :

            // require file
            require_once ($filePath);

            // break out of loop
            break;

        endif;

    endforeach;

    // clean up
    $directory = $directories = $filePath = null;
});

// get the url configuration
$urlConfiguration = Configuration::url();