<?php
include_once (dirname(__FILE__) . '/auth.php');
include_once (dirname(__FILE__) . '/function_class.php');

/*
 * get_head() checks if there is a header.php file in the same directory
 * if there is use it. if there isnt ignore get_head()
 */


define("FAQMENU", pathinfo($_SERVER['HTTP_HOST'], PATHINFO_BASENAME).'/index.php/Faq');
define("HYPERMENU", pathinfo($_SERVER['HTTP_HOST'], PATHINFO_BASENAME).'/index.php/Domestic');

get_head();

call_page();

/*
 * get_foot() checks if there is a foot.php file in the same directory
 * if there is use it. if there isnt ignore get_foot()
 */

get_foot();

