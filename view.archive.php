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
include "header.php";

if(planet_parse_args($args_num, $args, $args_str)){
	$args["year"] = @$args_num[0];
	$args["month"] = @$args_num[1];
	$args["day"] = @$args_num[2];
}

$day = intval( empty($_GET["day"])?@$args["day"]:$_GET["day"] );
$year = intval( empty($_GET["year"])?@$args["year"]:$_GET["year"] );
$month = intval( empty($_GET["month"])?@$args["month"]:$_GET["month"] );
$blog_id = intval( empty($_GET["blog"])?@$args["blog"]:$_GET["blog"] );
$start = intval( empty($_GET["start"])?@$args["start"]:$_GET["start"] );

$page["title"] = planet_constant("MD_ACHIVE");

$article_handler =& xoops_getmodulehandler("article", $GLOBALS["moddirname"]);
$blog_handler =& xoops_getmodulehandler("blog", $GLOBALS["moddirname"]);

$xoopsOption["xoops_pagetitle"] = $xoopsModule->getVar("name"). " - " .planet_constant("MD_ACHIVE");
$xoopsOption["template_main"] = planet_getTemplate("archive");
include_once( XOOPS_ROOT_PATH . "/header.php" );
include XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/vars.php";

$year = empty($year)?date("Y"):$year;
if($month<1){
	$month = $day = 0;
	$page["time"] = sprintf(planet_constant("MD_TIME_Y"), $year);
}elseif($day<1){
	$day = 0;
	$page["time"] = sprintf(planet_constant("MD_TIME_YM"), $year, $month);
}else{
	$page["time"] = sprintf(planet_constant("MD_TIME_YMD"), $year, $month, $day);
}
$time = array("year"=>$year, "month"=>$month, "day"=>$day);
if ($xoopsUser) {
    $timeoffset = ($xoopsUser->getVar("timezone_offset")- $xoopsConfig['server_TZ'])*3600;
} else {
    $timeoffset = ($xoopsConfig['default_TZ']- $xoopsConfig['server_TZ'])*3600;
}

$criteria = new CriteriaCompo();
if($blog_id){
	$criteria->add(new Criteria("blog_id", $blog_id));
}
$criteria->add(new Criteria("YEAR(FROM_UNIXTIME(art_time_publish - $timeoffset))", $year));
if($month){
	$criteria->add(new Criteria("MONTH(FROM_UNIXTIME(art_time_publish - $timeoffset))", $month));
	if($day){
		$criteria->add(new Criteria("DAY(FROM_UNIXTIME(art_time_publish - $timeoffset))", $day));
	}
}
$criteria->setStart($start);
$criteria->setLimit($xoopsModuleConfig["articles_perpage"]);

$articles_obj =& $article_handler->getAll(
	$criteria,
	array("uid", "art_title", "art_time", "blog_id", "art_content")
);
$articles_count = $article_handler->getCount($criteria);	

$articles = array();
$blogs_id = array();
foreach($articles_obj as $id=>$article){
	$articles[] = array(
		"id"=>$id,
		"blog"=>array("id"=>$article->getVar("blog_id"),"title"=>""),
		"title"=>$article->getVar("art_title"),
		"time"=>$article->getTime(),
		"content"=>$article->getVar("art_content")
	);
	$articles[] = $_article;
	$blogs_id[$article->getVar("blog_id")] = 1;
	unset($_article);
}
$criteria_blog = new Criteria("blog_id", "(".implode(",", array_keys($blog_array)).")", "IN");
$blogs = $blog_handler->getList($criteria_blog);
foreach(array_keys($articles) as $key){
	$articles[$key]["blog"]["title"] = $blogs[$articles[$key]["blog"]["id"]];
}
if($blog_id>0){
	$page["blog"] = $blogs[$blog_id];;
}

if ( $articles_count > $xoopsModuleConfig["articles_perpage"]) {
	include(XOOPS_ROOT_PATH."/class/pagenav.php");
	$nav = new XoopsPageNav($articles_count, $xoopsModuleConfig["articles_perpage"], $start, "start", "month=".$month."&amp;day=".$day."&amp;year=".$year."&amp;blog=".intval($blog_id));
	$pagenav = $nav->renderNav(4);
} else {
	$pagenav = "";
}

$timenav = null;
$calendar = null;
$months = null;
if(empty($start)){
	if($blog_id){
		$blog_criteria = " AND blog_id=".$blog_id;
	}else{
		$blog_criteria = "";
	}
	// Get monthly list
	if(empty($month)){
    	$sql = "SELECT MONTH(FROM_UNIXTIME(art_time - $timeoffset)) AS mon, COUNT(DISTINCT art_id) AS count 
            FROM ".planet_DB_prefix("article")."
            WHERE YEAR(FROM_UNIXTIME(art_time - $timeoffset)) = $year
            ".$blog_criteria."
            GROUP BY mon
            ";
        $result = $xoopsDB->query($sql);
        $months = array();
        while ($myrow = $xoopsDB->fetchArray($result)) {
            $months[] = array(
            	"title"=>planet_constant("MD_MONTH_".intval($myrow["mon"]))." (".intval($myrow["count"]).")",
				"url"=>XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.archive.php".URL_DELIMITER."".$year."/".$myrow["mon"]."/b".$blog_id,
            	);
        }
		$timenav["prev"] = array(
			"url"=>XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.archive.php".URL_DELIMITER."".($year-1)."/b".$blog_id,
			"title"=>sprintf(planet_constant("MD_TIME_Y"), ($year-1))
			);
		if($year<date("Y")){
			$timenav["next"] = array(
				"url"=>XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.archive.php".URL_DELIMITER."".($year+1)."/b".$blog_id,
				"title"=>sprintf(planet_constant("MD_TIME_Y"), ($year+1))
				);
		}
	}
	// Get daily list
	elseif(empty($day)){
    	$sql = "SELECT DAY(FROM_UNIXTIME(art_time - $timeoffset)) AS day, COUNT(DISTINCT a.art_id) AS count 
            FROM ".planet_DB_prefix("article")."
            WHERE YEAR(FROM_UNIXTIME(art_time - $timeoffset)) = $year
            AND MONTH(FROM_UNIXTIME(art_time - $timeoffset)) = $month
            ".$blog_criteria."
            GROUP BY day
            ";
        $result = $xoopsDB->query($sql);
        $days = array();
        while ($myrow = $xoopsDB->fetchArray($result)) {
            $days[$myrow["day"]]["count"] = $myrow["count"];
        }
        for($i=1;$i<=31;$i++){
	        if(!isset($days[$i])) continue;
	        $days[$i] = array(
            	"title"=>$days[$i]["count"],
				"url"=>XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.archive.php".URL_DELIMITER."".$year."/".$month."/".$i."/b".$blog_id
            	);
        }
        $calendar = planet_getCalendar($year, $month, $days);
        $month_next = $month+1;
        $month_prev = $month-1;
        $_year = $year;
        if($month==12) {
	        $month_next = 1;
	        $_year = $year +1;
        }
        if($month==1) {
	        $month_pre = 12;
	        $_year = $year - 1;
        }
		$timenav["prev"] = array(
			"url"=>XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.archive.php".URL_DELIMITER."".$_year."/".$month_prev."/b".$blog_id,
			"title"=>planet_constant("MD_MONTH_".$month_prev)
			);
		if($year<date("Y") || $month < date("n")){
			$timenav["next"] = array(
				"url"=>XOOPS_URL."/modules/".$GLOBALS["moddirname"]."/view.archive.php".URL_DELIMITER."".$_year."/".$month_next."/b".$blog_id,
				"title"=>planet_constant("MD_MONTH_".$month_next)
				);
		}
	}
}

$xoopsTpl -> assign("dirname", $GLOBALS["moddirname"]);
$xoopsTpl -> assign("modulename", $xoopsModule->getVar("name"));
$xoopsTpl -> assign("xoops_module_header", $xoopsOption["xoops_module_header"]);
$xoopsTpl -> assign("xoops_pagetitle", $xoopsOption["xoops_pagetitle"]);
$xoopsTpl -> assign("articles", $articles);

$xoopsTpl -> assign("blog", $blog_id);
$xoopsTpl -> assign("months", $months);
$xoopsTpl -> assign("calendar", $calendar);
$xoopsTpl -> assign("time", $time);
$xoopsTpl -> assign("page", $page);
$xoopsTpl -> assign("timenav", $timenav);
$xoopsTpl -> assign("pagenav", $pagenav);

include_once "footer.php";

function planet_getCalendar($year = null, $month = null, $days = null)
{
	$year = empty($year)?date("Y"):$year;
	$month = empty($month)?date("n"):$month;
    $unixmonth = mktime(0, 0 , 0, $month, 1, $year);
	
    ob_start();
    echo '<table id="calendar">';
    echo '<caption>';
    printf(planet_constant("MD_TIME_YM"), $year, planet_constant("MD_MONTH_".$month));
    echo '</caption>';
	
    for ($i=1;$i<=7;$i++) {
        echo "\n\t\t<th abbr=\"".planet_constant("MD_WEEK_".$i)."\" scope=\"col\" title=\"".planet_constant("MD_WEEK_".$i)."\">" . planet_constant("MD_WEEK_".$i) . '</th>';
    }

	echo '<tr>';
	
	// See how much we should pad in the beginning
	$week_begins = 1;
    $pad = planet_calendar_week_mod(date('w', $unixmonth)-$week_begins);
    if (0 != $pad) echo "\n\t\t".'<td colspan="'.$pad.'">&nbsp;</td>';

    $daysinmonth = intval(date('t', $unixmonth));
    for ($day = 1; $day <= $daysinmonth; ++$day) {
        if (isset($newrow) && $newrow){
            echo "\n\t</tr>\n\t<tr>\n\t\t";
        }
        $newrow = false;

       	echo '<td>';

        if (!empty($days[$day]["url"])) {
			echo '<a href="' . $days[$day]["url"] . "\"";
			if(!empty($days[$day]["title"])) echo "title=\"".$days[$day]["title"]."\"";
			echo ">$day</a>";
        } elseif(!empty($days[$day]["title"])) {
            echo "<acronym title=\"".$days[$day]["title"]."\">$day</acronym>";
        } else {
            echo $day;
        }
        echo '</td>';

	if (6 == planet_calendar_week_mod(date('w', mktime(0, 0 , 0, $month, $day, $year))-$week_begins))
            $newrow = true;
    }

    $pad = 7 - planet_calendar_week_mod(date('w', mktime(0, 0 , 0, $month, $day, $year))-$week_begins);
    if ($pad != 0 && $pad != 7){
        echo "\n\t\t".'<td class="pad" colspan="'.$pad.'">&nbsp;</td>';
    }

    echo "\n\t</tr>\n\t</tbody>\n\t</table>";
    $calendar = ob_get_contents();
    ob_end_clean();    
    
    return $calendar;
}

// Used in get_calendar
function planet_calendar_week_mod($num) {
	$base = 7;
	return ($num - $base*floor($num/$base));
}

?>