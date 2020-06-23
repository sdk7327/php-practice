<?php
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null : define('SITE_ROOT', DS . 'opt' . DS . 'lampp' . DS . 'htdocs' . DS . 'oop_php' . DS . 'CMS_practice');
defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT.DS.'admin'.DS.'includes');

require_once("functions.php");
require_once("new_config.php");
require_once("database.php");
require_once("db_object.php");
require_once("user.php");
require_once(__DIR__ . DIRECTORY_SEPARATOR . "photo.php");
require_once("session.php");
require_once(__DIR__ . DIRECTORY_SEPARATOR . "comment.php");

?>
