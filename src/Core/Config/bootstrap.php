<?php

namespace Atheo\Indoframe\Core\Config;

$paths = new Paths();

/*
 * ---------------------------------------------------------------
 * SETUP OUR PATH CONSTANTS
 * ---------------------------------------------------------------
 *
 * The path constants provide convenient access to the folders
 * throughout the application. We have to setup them up here
 * so they are available in the config files that are loaded.
 */

//This path to the application directory
if (!defined('APPPATH')) {
    /**
     * @var Paths $paths
     */
    define('APPPATH', realpath(rtrim($paths->appDirectory, '\\/')) . DIRECTORY_SEPARATOR);
}

// The path to the project root directory. Just above APPPATH.
if (!defined('ROOTPATH')) {
    define('ROOTPATH', realpath(APPPATH . '../') . DIRECTORY_SEPARATOR);
}

// The path to the system directory.
if (!defined('SYSTEMPATH')) {
    /**
     * @var Paths $paths
     */
    define('SYSTEMPATH', realpath(rtrim($paths->systemDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
}

// The path to the tests directory
if (!defined('TESTPATH')) {
    /**
     * @var Paths $paths
     */
    define('TESTPATH', realpath(rtrim($paths->testsDirectory, '\\/ ')) . DIRECTORY_SEPARATOR);
}

// The path to the views directory
if (!defined('VIEWPATH')) {
    define('VIEWPATH',  realpath(rtrim($paths->viewDirectory, '\\/')) . DIRECTORY_SEPARATOR);
}

// The path to the Controller directory
if (!defined('CONTROLLERPATH')) {
    define('CONTROLLERPATH',  realpath(rtrim($paths->controllerDirectory, '\\/')) . DIRECTORY_SEPARATOR);
}

// The path to the Model directory
if (!defined('MODELPATH')) {
    define('MODELPATH',  realpath(rtrim($paths->modelDirectory, '\\/')) . DIRECTORY_SEPARATOR);
}

/**
 * ============================================================
 * GRAB CONSTANTS
 * ============================================================
 */

if (!defined('APP_NAMESPACE')) {
    require_once APPPATH . 'Config/Constants.php';
}

// Require system/Common.php
require_once APPPATH . 'Common.php';

// Now load Composer's if it's available
if (is_file(COMPOSER_PATH)) {
    /*
     * The path to the vendor directory.
     *
     * We do not want to enforce this, so set the constant if Composer was used.
     */
    if (!defined('VENDORPATH')) {
        define('VENDORPATH', dirname(COMPOSER_PATH) . DIRECTORY_SEPARATOR);
    }

    require_once COMPOSER_PATH;
}
