<?php

/**
 * Leave it this way.
 * @type string
 */
//CHANGE THE PATH
define('API_ROOT', '/home/nbgsys/proyects/html/coffee/app/');

/**
 * Choose wether to show debug data or not.
 * @type boolean
 */
define('API_DEBUG', true);

/**
 * Available options: 'production', 'test', 'debug'
 * @type string
 */
define('API_ENVIRONMENT', 'debug');

/**
 * Choose wether to log errors or not.
 * @type boolean
 */
define('API_LOG_ENABLED', true);

/**
 * Available options:
 * const EMERGENCY = 1;
 * const ALERT     = 2;
 * const CRITICAL  = 3;
 * const ERROR     = 4;
 * const WARN      = 5;
 * const NOTICE    = 6;
 * const INFO      = 7;
 * const DEBUG     = 8;
 * @type int
 */
define('API_LOG_LEVEL', '402');

/**
 * Set wether to use memcache or not.
 * @type boolean
 */
define('API_USE_CACHE', 0);

/**
 * Set various properties for the memcache connection.
 */
define('API_CACHE_HOST', '127.0.0.1');
define('API_CACHE_PORT', 11211);
define('API_CACHE_CONNECT_TIMEOUT', 10);
define('API_CACHE_DEFAULT_TTL', 600);

/**
 * Set various values for the default cache ttls.
 * If they're unsettled, the default ttl will be used.
 */
define('CACHE_TTL_CATEGORY_TREE', 500);
define('CACHE_TTL_CATEGORY_PRODUCTS', 100);
define('CACHE_TTL_PRODUCT_DETAILS', 300);

/**
 * Configuration for the CSV Files
 */
define('EXCLUDE_FIRST_LINE_CSV', true);
define('DELIMITER_CSV', ';');
define('ORDERS_FILE_COLUMNS', '4');
define('RATES_FILE_COLUMNS', '3');
define('DATE_FORMAT', 'd/m/Y');
define('DATE_FORMAT_RATES', 'Y/m/d');

/**
 * Format Conversions
 */
define('DECIMAL_DIGITS', 2);
define('DECIMAL_SEPARATOR', '.');

/**
 * DATABASE CONNECTION
 */
define('CONNECTION_TO_SERVER', '');
define('CONNECTION_DATABASE_NAME', '');
define('CONNECTION_USER', '');
define('CONNECTION_PASSWORD', '');