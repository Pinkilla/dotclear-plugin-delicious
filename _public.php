<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
# This file is part of Plugin-Delicious, a plugin for Dotclear 2.
#
# Copyright (c) Pinkilla and contributors
# <pb@namok.be>
#
# Licensed under the GPL version 2.0 license.
# A copy of this license is available in LICENSE file or at
# http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
# -- END LICENSE BLOCK ------------------------------------ 
if (!defined('DC_RC_PATH')) { return; }

global $core;

$core->tpl->addValue('Delicious',array('deliciusClass','deliciousFct'));

class deliciousClass extends dcUrlHandlers {
	const 
		//URL =
		//"http://feeds.delicious.com/html/USER/TAG?count=COUNT&tags=no&rssbutton=no";
	URL = "http://feeds.delicious.com/v2/rss/USER/TAG?plain&count=COUNT";

	/*
   * Return links based on user prefs
	 */
	public static function deliciousFct($attr) {
    // Get user prefs from delicious workspace

		/* todo gérer le faut que l'utilisateur puisse passer des valeurs en paramètres. dans ce cas, elles prévalent sur les préfs */
		
		$user = $core->auth->user_prefs->delicious->user; 
		$tag = $core->auth->user_prefs->delicious->tag; 
		$count = $core->auth->user_prefs->delicious->count; 

    // Replace values in url and return
		$url = str_replace('USER', htmlentities($user), self::URL);
		$url = str_replace('TAG', htmlentities($tag), $url); 
		$url = str_replace('COUNT', htmlentities($count), $url); 
		return HttpClient::quickGet($url);
	}
}

/* 
$core->url->register('delicious','delicious','^delicious$',
	array('deliciousClass','deliciousFct'));
 */
/*require_once dirname(__FILE__) . '/inc/delicious.class.php';*/
?>
