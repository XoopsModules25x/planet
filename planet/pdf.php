<?php
/**
 * FPDF creator framework for XOOPS
 *
 * Supporting multi-byte languages as well as utf-8 charset
 *
 * @copyright	The XOOPS project http://www.xoops.org/
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <php_pp@hotmail.com>
 * @since		1.00
 * @version		$Id$
 * @package		frameworks
 */
 
//ob_start();

/**
 * If no pdf_data is set, build it from the module
 *
 * <ul>The data fields to be built:
 *		<li>title</li>
 *		<li>subtitle (optional)</li>
 *		<li>subsubtitle (optional)</li>
 *		<li>date</li>
 *		<li>author</li>
 *		<li>content</li>
 *		<li>filename</li>
 * </ul>
 */
global $pdf_data;
if(!empty($_POST["pdf_data"])){
	$pdf_data = unserialize(base64_decode($_POST["pdf_data"]));
}elseif(!empty($pdf_data)){
	
}else{
	error_reporting(0);
	include "header.php";
	error_reporting(0);

	if(planet_parse_args($args_num, $args, $args_str)){
		$args["article"] = @$args_num[0];
	}
	
	$article_id = intval( empty($_GET["article"])?@$args["article"]:$_GET["article"] );
	
	$article_handler =& xoops_getmodulehandler("article", $GLOBALS["moddirname"]);
	$article_obj =& $article_handler->get($article_id);
	
	$article_data = array();
	
	// title
	$article_data["title"] = $article_obj->getVar("art_title");
	
	$article_data["author"] = $article_obj->getVar("art_author");
	
	// source
	$article_data["source"] = $article_obj->getVar("art_link");
	
	// publish time
	$article_data["time"] = $article_obj->getTime();

	// summary
	$article_data["summary"] = $article_obj->getSummary();
	
	// text of page
	$article_data["text"] = $article_obj->getVar("art_content");
	
	// Build the pdf_data array
	$pdf_data["title"] 		= $article_data["title"];
	$pdf_data["author"] 	= $article_data["author"];
	$pdf_data["date"] 		= $article_data["time"];
	$pdf_data["content"] 	= "";
	if($article_data["summary"]){
		$pdf_data["content"] .= planet_constant("MD_SUMMARY").": ".$article_data["summary"]."<br /><br />";
	}
	$pdf_data["content"] 	.= $article_data["text"]."<br />";
	$pdf_data["url"] = XOOPS_URL."/modules/".$GLOBALS["artdirname"]."/view.article.php".URL_DELIMITER.$article_obj->getVar("art_id");
}
$pdf_data['filename'] = preg_replace("/[^0-9a-z\-_\.]/i", '', $pdf_data["title"]);

include XOOPS_ROOT_PATH."/Frameworks/fpdf/init.php";
error_reporting(0);
ob_end_clean();

$pdf =& new xoopsPDF($xoopsConfig["language"]);
$pdf->initialize();
$pdf->output($pdf_data, _CHARSET);
?>