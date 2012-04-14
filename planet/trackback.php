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

// trackback is done by a POST
$art_id = explode('/', $_SERVER['REQUEST_URI']);
$article_id = intval($art_id[count($art_id)-1]);
$url = $_POST['url'];
$title = $_POST['title'];
$excerpt = $_POST['excerpt'];
$blog_name = $_POST['blog_name'];
$charset = trim($_POST['charset']);

if (empty($xoopsModuleConfig['trackback_option'])) {
	planet_trackback_response(1, 'Trackback is closed');
}
if( !strlen( $title.$url.$blog_name ) ) {
	planet_trackback_response(1, planet_constant("MD_INVALID"));
}


if ( !empty($article_id) && !empty($url)) {
	
	$trackback_handler =& xoops_getmodulehandler("trackback", $GLOBALS["moddirname"]);
	$criteria = new CriteriaCompo(new Criteria('art_id', $article_id));
	$criteria->add(new Criteria('tb_url', $url));
	if($trackback_handler->getCount($criteria)>0){
		planet_trackback_response(1, 'We already have a ping from that URI for this article.');
	}

	$charset = (empty($charset))?'utf-8':$charset;
	$title = XoopsLocal::convert_encoding($title, _CHARSET, $charset);
	$excerpt = XoopsLocal::convert_encoding($excerpt, _CHARSET, $charset);
	$blog_name = XoopsLocal::convert_encoding($blog_name, _CHARSET, $charset);
	$tb_status = intval($xoopsModuleConfig["trackback_option"]);
	
	$com_pid = 0;
	$com_itemid = $article_id;
	$com_rootid = 0;
	$com_title = $title;
	$com_text = $excerpt;
	$com_text .= "\n\n[TRACKBACK]"._POSTEDBY.": ";
	if(!empty($url)){
		$com_text .= "[url=".$url."]".$blog_name."[/url]";
	}else{
		$com_text .= $blog_name;
	}
	$com_modid = $xoopsModule->getVar("mid");
	
	$comment_handler =& xoops_gethandler('comment');
	$comment = $comment_handler->create();
	$comment->setVar('com_created', time());
	$comment->setVar('com_pid', $com_pid);
	$comment->setVar('com_itemid', $com_itemid);
	$comment->setVar('com_rootid', $com_rootid);
	$comment->setVar('com_ip', xoops_getenv('REMOTE_ADDR'));
	switch ($tb_status) {
	case 2:
		$comment->setVar('com_status', 2);
		$call_approvefunc = true;
		$call_updatefunc = true;
		$notify_event = 'comment';
		break;
	case 1:
	default:
		$comment->setVar('com_status', 1);
		$notify_event = 'comment_submit';
		break;
	}
	$comment->setVar('com_uid', 0);
	$com_title = xoops_trim($com_title);
	$com_title = empty($com_title) ? _NOTITLE : $com_title;
	$comment->setVar('com_title', $com_title);
	$comment->setVar('com_text', $com_text);
	$comment->setVar('dohtml', 0);
	$comment->setVar('dosmiley', 0);
	$comment->setVar('doxcode', 1);
	$comment->setVar('doimage', 0);
	$comment->setVar('dobr', 1);
	$comment->setVar('com_icon', '');
	$comment->setVar('com_modified', time());
	$comment->setVar('com_modid', $com_modid);
	if (false != $comment_handler->insert($comment)) {
		$newcid = $comment->getVar('com_id');

		// set own id as root id
		$com_rootid = $newcid;
		if (!$comment_handler->updateByField($comment, 'com_rootid', $com_rootid)) {
			$comment_handler->delete($comment);
			planet_trackback_response(1, xoops_error());
		}

		// call custom approve function if any
		if (false != $call_approvefunc && isset($comment_config['callback']['approve']) && trim($comment_config['callback']['approve']) != '') {
			$skip = false;
			if (!function_exists($comment_config['callback']['approve'])) {
				if (isset($comment_config['callbackFile'])) {
					$callbackfile = trim($comment_config['callbackFile']);
					if ($callbackfile != '' && file_exists(XOOPS_ROOT_PATH.'/modules/'.$moddir.'/'.$callbackfile)) {
						include_once XOOPS_ROOT_PATH.'/modules/'.$moddir.'/'.$callbackfile;
					}
					if (!function_exists($comment_config['callback']['approve'])) {
						$skip = true;
					}
				} else {
					$skip = true;
				}
			}
			if (!$skip) {
				$comment_config['callback']['approve']($comment);
			}
		}

		// call custom update function if any
		if (false != $call_updatefunc && isset($comment_config['callback']['update']) && trim($comment_config['callback']['update']) != '') {
			$skip = false;
			if (!function_exists($comment_config['callback']['update'])) {
				if (isset($comment_config['callbackFile'])) {
					$callbackfile = trim($comment_config['callbackFile']);
					if ($callbackfile != '' && file_exists(XOOPS_ROOT_PATH.'/modules/'.$moddir.'/'.$callbackfile)) {
						include_once XOOPS_ROOT_PATH.'/modules/'.$moddir.'/'.$callbackfile;
					}
					if (!function_exists($comment_config['callback']['update'])) {
						$skip = true;
					}
				} else {
					$skip = true;
				}
			}
			if (!$skip) {
				$criteria = new CriteriaCompo(new Criteria('com_modid', $com_modid));
				$criteria->add(new Criteria('com_itemid', $com_itemid));
				$criteria->add(new Criteria('com_status', XOOPS_COMMENT_ACTIVE));
				$comment_count = $comment_handler->getCount($criteria);
				$func = $comment_config['callback']['update'];
				call_user_func_array($func, array($com_itemid, $comment_count, $comment->getVar('com_id')));
			}
		}

		// RMV-NOTIFY
		// trigger notification event if necessary
		if ($notify_event) {
			$not_modid = $com_modid;
			include_once XOOPS_ROOT_PATH . '/include/notification_functions.php';
			$not_catinfo =& notificationCommentCategoryInfo($not_modid);
			$not_category = $not_catinfo['name'];
			$not_itemid = $com_itemid;
			$not_event = $notify_event;
			// Build an ABSOLUTE URL to view the comment.  Make sure we
			// point to a viewable page (i.e. not the system administration
			// module).
			$comment_tags = array();
			$not_module =& $xoopsModule;
			if (!isset($comment_url)) {
				$com_config =& $not_module->getInfo('comments');
				$comment_url = $com_config['pageName'] . '?';
				$comment_url .= $com_config['itemName'];
			}
			$comment_tags['X_COMMENT_URL'] = XOOPS_URL . '/modules/' . $not_module->getVar('dirname') . '/' .$comment_url . '=' . $com_itemid.'&amp;com_id='.$newcid.'&amp;com_rootid='.$com_rootid.'&amp;com_mode='.$com_mode.'&amp;com_order='.$com_order.'#comment'.$newcid;
			$notification_handler =& xoops_gethandler('notification');
			$notification_handler->triggerEvent ($not_category, $not_itemid, $not_event, $comment_tags, false, $not_modid);
		}

		planet_trackback_response(0);
	} else {
		planet_trackback_response(1, xoops_error($comment->getHtmlErrors()));
	}
}
?>