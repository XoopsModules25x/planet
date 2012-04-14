<?php
// $Id$
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
//                                                                          //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
//                                                                          //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
//                                                                          //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
// Author: phppp (D.J., infomax@gmail.com)                                  //
// URL: http://xoopsforge.com, http://xoops.org.cn                          //
// Project: Article Project                                                 //
// ------------------------------------------------------------------------ //

if (!defined('XOOPS_ROOT_PATH')){ exit(); }

$current_path = __FILE__;
if ( DIRECTORY_SEPARATOR != '/' ) $current_path = str_replace( strpos( $current_path, '\\\\', 2 ) ? '\\\\' : DIRECTORY_SEPARATOR, '/', $current_path);
$url_arr = explode('/',strstr($current_path,'/modules/'));
$GLOBALS["moddirname"] = $url_arr[2];

if(!defined("planet_FUNCTIONS")): 
define("planet_FUNCTIONS",1);

require XOOPS_ROOT_PATH."/modules/".$GLOBALS["moddirname"]."/include/vars.php";
include_once(XOOPS_ROOT_PATH."/class/xoopslists.php");
include_once (XOOPS_ROOT_PATH."/Frameworks/art/functions.php");

/**
 * Function to display messages
 * 
 * @var mixed 	$messages
 */
function planet_message( $message )
{
	return mod_message( $message );
}

/**
 * Function to parse arguments for a page according to $_SERVER['REQUEST_URI']
 * 
 * @var array $args_numeric	array of numeric variable values
 * @var array $args			array of indexed variables: name and value
 * @var array $args_string	array of string variable values
 *
 * @return bool	true on args parsed
 */

/* known issues:
 * - "/" in a string 
 * - "&" in a string 
*/
function planet_parse_args(&$args_numeric, &$args, &$args_string)
{
	$args_abb=array("a"=>"article", "b"=>"blog", "c"=>"category", "l"=>"list", "o"=>"sort", "s"=>"start", "u"=>"uid");
	$args = array();
	$args_numeric = array();
	$args_string = array();
	if(preg_match("/[^\?]*\.php[\/|\?]([^\?]*)/i", $_SERVER['REQUEST_URI'], $matches)){
		$vars = preg_split("/[\/|&]/", $matches[1]);
		$vars = array_map("trim", $vars);
		if(count($vars)>0) {
			foreach($vars as $var){
				if(is_numeric($var)){
					$args_numeric[] = $var;
				}elseif(false === strpos($var, "=")){
					if(is_numeric(substr($var, 1))){
						$args[$args_abb[strtolower($var{0})]] = intval(substr($var, 1));
					}else{
						$args_string[] = urldecode($var);
					}
				}else{
					parse_str($var, $args);
				}
			}
		}
	}
	return (count($args)+count($args_numeric)+count($args_string) == 0)?null:true;
}

/**
 * Function to parse class prefix
 * 
 * @var string 	$class_string	string to be parsed
 * @var mixed 	$pattern
 * @var mixed 	$replacement
 *
 * @return bool	true on success
 */
function planet_parse_class($class_string, $pattern="", $replacement="")
{
	if(empty($class_string)) return;
	$patterns = array("/\[CLASS_PREFIX\]/");
	$replacements = array(ucfirst(strtolower($GLOBALS["moddirname"])));
	if(!empty($pattern) && !is_array($pattern) && !is_array($replacement)){
		$pattern = array($pattern);
		$replacement = array($replacement);
	}
	if(is_array($pattern) && count($pattern)>0){
		$ii = 0;
		foreach($pattern as $pat){
			if(!in_array($pat, $patterns)){
				$patterns[] = $pat;
				$replacements[] = isset($replacement[$ii])?$replacement[$ii]:"";
			}
			$ii++;
		}
	}
	$class_string = preg_replace($patterns, $replacements, $class_string);
	eval($class_string);
	return true;
}

/**
 * Function to parse function prefix
 * 
 * @var string 	$function_string	string to be parsed
 * @var mixed 	$pattern
 * @var mixed 	$replacement
 *
 * @return bool	true on success
 */
function planet_parse_function($function_string, $pattern="", $replacement="")
{
	if(empty($function_string)) return;
	$patterns = array("/\[DIRNAME\]/", "/\[VAR_PREFIX\]/");
	$replacements = array($GLOBALS["moddirname"], $GLOBALS["VAR_PREFIX"]);
	if(!empty($pattern) && !is_array($pattern) && !is_array($replacement)){
		$pattern = array($pattern);
		$replacement = array($replacement);
	}
	if(is_array($pattern) && count($pattern)>0){
		$ii = 0;
		foreach($pattern as $pat){
			if(!in_array($pat, $patterns)){
				$patterns[] = $pat;
				$replacements[] = isset($replacement[$ii])?$replacement[$ii]:"";
			}
			$ii++;
		}
	}
	$function_string = preg_replace($patterns, $replacements, $function_string);
	eval($function_string);
	return true;
}

/**
 * Function to convert UNIX time to formatted time string
 */
function planet_formatTimestamp($time, $format = "c", $timeoffset = "")
{
	load_functions("locale");
	
	if(strtolower($format) == "reg" || strtolower($format) == "") {
		$format = "c";
	}
	if( (strtolower($format) == "custom" || strtolower($format) == "c") && !empty($GLOBALS["xoopsModuleConfig"]["formatTimestamp_custom"]) ) {
		$format = $GLOBALS["xoopsModuleConfig"]["formatTimestamp_custom"];
	}
	
	return XoopsLocal::formatTimestamp($time, $format, $timeoffset);
}

/**
 * Function to a list of user names associated with their user IDs
 * 
 */
function &planet_getUnameFromId( $userid, $usereal = 0, $linked = false )
{
	if(!is_array($userid))  $userid = array($userid);
	$users = mod_getUnameFromIds($userid, $usereal, $linked);

    return $users;
}


/**
 * Function to parse links, links are delimited by link break, URL and title of a link are delimited by space
 * 
 * @var string 	$text raw content
 *
 * @return array	associative array of link url and title
 */
function &planet_parseLinks($text)
{
	$myts =& MyTextSanitizer::getInstance();
	$link_array = preg_split("/(\r\n|\r|\n)( *)/", $text);
    $links = array();
    if(count($link_array)>0) foreach($link_array as $link){
	    @list($url, $title) = array_map("trim",preg_split("/ /", $link, 2));
	    if(empty($url)) continue;
	    //if(empty($title)) $title = $url;
	    $links[] = array("url"=>$url, "title"=>$myts->htmlSpecialChars($title));
    }
    return $links;
}

function planet_getTemplate($pagename)
{
	return $GLOBALS["VAR_PREFIX"]."_".$pagename.".html";
}

function planet_adminmenu ($currentoption = -1)
{
	loadModuleAdminMenu($currentoption, "");
	return;
}

/**
 * Function to send a trackback
 *
 * @return bool
 */
function planet_com_trackback(&$article, &$comment)
{
	$blog_handler =& xoops_getmodulehandler("blog", $GLOBALS["moddirname"]);
	$blog_obj =& $blog_handler->get($article->getVar("blog_id"));
	if(!$pattern = $blog_obj->getVar("blog_trackback")) return false;
	@list($pat, $rep) = array_map("trim",preg_split("#[\s]+#", $pattern));
	$trackback_url = preg_replace("#".$pat."#", $rep, $article_obj->getVar("art_link"));
	return planet_trackback($trackback_url, $article);
}

function planet_trackback($trackback_url, &$article)
{
	global $myts, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;

	$title = $article->getVar("art_title");
	$excerpt = $article->getVar("art_content");
	$blog_name = $xoopsConfig["sitename"]."-".$xoopsModule->getVar("name");
	$title = xoops_utf8_encode($title);
	$excerpt = xoops_utf8_encode($excerpt);
	$blog_name = xoops_utf8_encode($blog_name);
	$charset="utf-8";
	$title1 = urlencode($title);
	$excerpt1 = urlencode($excerpt);
	$name1 = urlencode($blog_name);
	$url = urlencode(XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.article.php".URL_DELIMITER."".$article->getVar("art_id"));
	$query_string = "title=$title1&url=$url&blog_name=$name1&excerpt=$excerpt1&charset=$charset";
	$trackback_url = parse_url($trackback_url);
	
	$http_request  = 'POST ' . $trackback_url['path'] . ($trackback_url['query'] ? '?'.$trackback_url['query'] : '') . " HTTP/1.0\r\n";
	$http_request .= "Host: ".$trackback_url["host"]."\r\n";
	$http_request .= "Content-Type: application/x-www-form-urlencoded; charset=".$charset."\r\n";
	$http_request .= "Content-Length: ".strlen($query_string)."\r\n";
	$http_request .= "User-Agent: XOOPS Blogs/" . XOOPS_VERSION;
	$http_request .= "\r\n\r\n";
	$http_request .= $query_string;
	if ( '' == $trackback_url['port'] ){
		$trackback_url['port'] = 80;
	}
	$fs = @fsockopen($trackback_url['host'], $trackback_url['port'], $errno, $errstr, 4);
	@fputs($fs, $http_request);
	if($xoopsModuleConfig["do_debug"]) {
		$debug_file = XOOPS_CACHE_PATH."/".$GLOBALS["moddirname"]."_trackback.log";
		$fr = "\n*****\nRequest:\n\n$http_request\n\nResponse:\n\n";
		$fr .= "CHARSET:$charset\n";
		$fr .= "NAME:$blog_name\n";
		$fr .= "TITLE:".$title."\n";
		$fr .= "EXCERPT:$excerpt\n\n";
		while(!@feof($fs)) {
			$fr .= @fgets($fs, 4096);
		}
		$fr .= "\n\n";

		if($fp = fopen($debug_file, "a")){
			fwrite($fp, $fr);
			fclose($fp);
		}else{
		}
	}
	@fclose($fs);
	return true;
}

/**
 * Function to ping servers
 */
function planet_ping($server, $id) {
	if(is_array($server)){
		foreach($server as $serv){
			planet_ping($serv, $id);
		}
	}
	include_once (XOOPS_ROOT_PATH."/modules/".$GLOBALS["moddirname"]."/class-IXR.php");

	// using a timeout of 3 seconds should be enough to cover slow servers
	$client = new IXR_Client($server, false);
	$client->timeout = 3;
	$client->useragent .= ' -- XOOPS Article/'.XOOPS_VERSION;

	// when set to true, this outputs debug messages by itself
	$client->debug = false;
	
	$blogname = xoops_utf8_encode($GLOBALS['xoopsModule']->getVar("name"));
	$home = XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/";
	$rss2_url = XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/xml.php".URL_DELIMITER."rss2.0/".$id;
	
	if ( !$client->query('weblogUpdates.extendedPing', $blogname, $home, $rss2_url ) ) // then try a normal ping
		$client->query('weblogUpdates.ping', $blogname, $home);
}

/**
 * Function to respond to a trackback
 */
function planet_trackback_response($error = 0, $error_message = '') {
	$charset = "utf-8";
	$error_message = xoops_utf8_encode($error_message);
	header('Content-Type: text/xml; charset="'.$charset.'"');
	if ($error) {
		echo '<?xml version="1.0" encoding="'.$charset.'"?'.">\n";
		echo "<response>\n";
		echo "<error>1</error>\n";
		echo "<message>$error_message</message>\n";
		echo "</response>";
		die();
	} else {
		echo '<?xml version="1.0" encoding="'.$charset.'"?'.">\n";
		echo "<response>\n";
		echo "<error>0</error>\n";
		echo "</response>";
	}
}

/**
 * Function to set a cookie with module-specified name
 *
 * using customized serialization method
 */
function planet_setcookie($name, $string = '', $expire = 0)
{
	if(is_array($string)) {
		$value = array();
		foreach ($string as $key => $val){
			$value[]=$key."|".$val;
		}
		$string = implode(",", $value);
	}
	setcookie($GLOBALS["VAR_PREFIX"].$name, $string, intval($expire), '/');
}

function planet_getcookie($name, $isArray = false)
{
	$value = isset($_COOKIE[$GLOBALS["VAR_PREFIX"].$name]) ? $_COOKIE[$GLOBALS["VAR_PREFIX"].$name] : null;
	if($isArray) {
		$_value = ($value)?explode(",", $value):array();
		$value = array();
		if(count($_value)>0) foreach($_value as $string){
			$key = substr($string, 0, strpos($string,"|"));
			$val = substr($string, (strpos($string,"|")+1));
			$value[$key] = $val;
		}
		unset($_value);
	}
	return $value;
}

/**
 * Function to filter text
 *
 * @return string	filtered text
 */
function &planet_html2text(&$document)
{
	$document = strip_tags($document);
	return $document;
}

// Adapted from PMA_getIp() [phpmyadmin project]
function planet_getIP($asString = false)
{
	return mod_getIP($asString);
}

function planet_remote_content($url)
{
    if($data = planet_fetch_snoopy($url)) return $data;
    if($data = planet_fetch_CURL($url)) return $data;
    if($data = planet_fetch_fopen($url)) return $data;
   	return false;
}

function planet_fetch_snoopy($url)
{
	require_once(XOOPS_ROOT_PATH."/class/snoopy.php");
	$snoopy = new Snoopy;
	$data = "";
	if (@$snoopy->fetch($url)){
    	$data = (is_array($snoopy->results))?implode("\n",$snoopy->results):$snoopy->results;
	}
	return $data;
}

function planet_fetch_CURL($url)
{
    if (!function_exists('curl_init') ) return false;
    $ch = curl_init();    // initialize curl handle
    curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); // return into a variable
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // times out after 31s
    $data = curl_exec($ch); // run the whole process
    curl_close($ch);
    return $data;
}

function planet_fetch_fopen($url)
{
	if(!$fp = @fopen ($url, 'r')) return false;
    $data = "";
    while (!feof($fp)) {
        $data .= fgets ($fp, 1024);
    }
    fclose($fp);
	return $data;
}

function planet_strrpos($haystack, $needle, $offset = 0 )
{
	if( substr(phpversion(),0,1) == 5 ){
		return strrpos($haystack, $needle, $offset);
	}
	$index = strpos(strrev($haystack), strrev($needle));
	if($index === false) {
		return false;
	}
	$index = strlen($haystack) - strlen($needle) - $index;
	return $index;	
}
endif;
?>