<?php

define("APP_ROOT", dirname(dirname(__FILE__)));

session_start();

require_once("functions/dbconnection.php");
require_once("functions/general_functions.php");
require_once("functions/security/blacklist_functions.php");
require_once("functions/security/throttle_functions.php");
require_once("functions/security/reset_token_functions.php");

require_once("functions/security/csrf_request_type_functions.php");
require_once("functions/security/csrf_token_functions.php");
require_once("functions/security/request_forgery_functions.php");
require_once("functions/security/session_hijacking_functions.php");
require_once("functions/security/sqli_escape_functions.php");
require_once("functions/security/validation_functions.php");
require_once("functions/security/xss_sanitize_functions.php");
?>
