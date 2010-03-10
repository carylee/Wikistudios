<?php
session_start();
ob_start();
require_once('global_definitions.php');
require_once('connect_database.php');
require_once ('/home/ucmnuorg/lib/ZendGdata/library/Zend/Loader.php');
Zend_Loader::loadClass('Zend_Gdata_YouTube');
Zend_Loader::loadClass('Zend_Gdata_AuthSub');
require_once(CLASSES_PATH . 'user.php');
require_once(CLASSES_PATH . 'video.php');
require_once(CLASSES_PATH . 'project.php');
require_once(CLASSES_PATH . 'tag.php');
require_once(CLASSES_PATH . 'item.php');
require_once(CLASSES_PATH . 'image.php');
require_once(CLASSES_PATH . 'comment_builder.php');
require_once(CLASSES_PATH . 'comment.php');
require_once(CLASSES_PATH . 'html_object.php');
require_once('common.php');
require_once("/home/ucmnuorg/php/XML/Serializer.php");
//require_once(INCLUDES_PATH . '')

?>