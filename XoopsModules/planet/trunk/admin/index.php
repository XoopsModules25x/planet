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
include('header.php');

xoops_cp_header();

planet_adminmenu(0);

echo "
	<style type=\"text/css\">
	label,text {
		display: block;
		float: left;
		margin-bottom: 2px;
	}
	label {
		text-align: right;
		width: 150px;
		padding-right: 20px;
	}
	br {
		clear: left;
	}
	</style>
";

echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . planet_constant("AM_PREFERENCES") . "</legend>";
echo "<div style='padding: 8px;'>";
echo "<label>" . "<strong>PHP Version:</strong>" . ":</label><text>" . phpversion() . "</text><br />";
echo "<label>" . "<strong>MySQL Version:</strong>" . ":</label><text>" . mysql_get_server_info() . "</text><br />";
echo "<label>" . "<strong>XOOPS Version:</strong>" . ":</label><text>" . XOOPS_VERSION . "</text><br />";
echo "<label>" . "<strong>Module Version:</strong>" . ":</label><text>" . $xoopsModule->getInfo('version') . "</text><br />";
echo "</div>";
echo "<div style='padding: 8px;'>";
echo "<label>" . planet_constant("AM_SAFEMODE") . ":</label><text>";
echo ( ini_get( 'safe_mode' ) ) ? planet_constant("AM_ON") : planet_constant("AM_OFF");
echo "</text><br />";
echo "<label>" . planet_constant("AM_REGISTERGLOBALS") . ":</label><text>";
echo ( ini_get( 'register_globals' )) ? planet_constant("AM_ON") : planet_constant("AM_OFF");
echo "</text><br />";
echo "<label>" . planet_constant("AM_MAGICQUOTESGPC") . ":</label><text>";
echo ( ini_get( 'magic_quotes_gpc' )) ? planet_constant("AM_ON") : planet_constant("AM_OFF");
echo "</text><br />";
echo "<label>" . planet_constant("AM_MAXPOSTSIZE") .":</label><text>". ini_get( 'post_max_size' );
echo "</text><br />";
echo "<label>" . planet_constant("AM_MAXINPUTTIME") .":</label><text>". ini_get( 'max_input_time' );
echo "</text><br />";
echo "<label>" . planet_constant("AM_OUTPUTBUFFERING") .":</label><text>". ini_get( 'output_buffering' );
echo "</text><br />";
echo "<label>" . planet_constant("AM_XML_EXTENSION") .":</label><text>";
echo ( extension_loaded( 'xml' )) ? planet_constant("AM_ON") : planet_constant("AM_OFF");
echo "</text><br />";
echo "<label>" . planet_constant("AM_MB_EXTENSION") .":</label><text>";
echo ( extension_loaded( 'mbstring' )) ? planet_constant("AM_ON") : planet_constant("AM_OFF");
echo "</text><br />";
echo "<label>" . planet_constant("AM_CURL") .":</label><text>";
echo ( function_exists('curl_init')) ? planet_constant("AM_ON") : planet_constant("AM_OFF");
echo "</text><br />";
echo "<label>" . planet_constant("AM_FSOCKOPEN") .":</label><text>";
echo ( function_exists('fsockopen')) ? planet_constant("AM_ON") : planet_constant("AM_OFF");
echo "</text><br />";
echo "<label>" . planet_constant("AM_URLFOPEN") .":</label><text>";
echo ( ini_get('allow_url_fopen')) ? planet_constant("AM_ON") : planet_constant("AM_OFF");
echo "</text><br />";
echo "</div>";
echo "</fieldset>";

echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . planet_constant("AM_STATS") . "</legend>";
echo "<div style='padding: 8px;'>";
$category_handler =& xoops_getmodulehandler('category', $GLOBALS["moddirname"]);
$category_count = $category_handler->getCount();
$blog_handler =& xoops_getmodulehandler("blog", $GLOBALS["moddirname"]);
$blog_count = $blog_handler->getCount();
$article_handler =& xoops_getmodulehandler('article', $GLOBALS["moddirname"]);
$article_count = $article_handler->getCount();
$criteria = new Criteria("blog_status", 0);
$blog_count_pending = $blog_handler->getCount($criteria);
echo "<label>" . planet_constant("AM_TOTAL_CATEGORIES") .":</label><text>". $category_count;
echo "</text><br />";
echo "<label>" . planet_constant("AM_TOTAL_BLOGS") .":</label><text>". $blog_count;
if($blog_count_pending>0) echo " (<font color=\"red\">". $blog_count_pending."</font>)";
echo "</text><br />";
echo "<label>" . planet_constant("AM_TOTAL_ARTICLES") .":</label><text>".$article_count;
echo "</text><br />";
echo "</div>";
echo "</fieldset>";

xoops_cp_footer();
?>