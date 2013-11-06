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


if (!defined('DC_CONTEXT_ADMIN')) { return; }

$new_version = $core->plugins->moduleInfo('delicious','version');
$old_version = $core->getVersion('delicious');

if (version_compare($old_version,$new_version,'>=')) return;

try
{
	$core->auth->user_prefs->addWorkSpace('delicious');
	$delicious_prefs = &$core->auth->user_prefs->delicious;
	$delicious_prefs->put('user', '','string','User id on delicous');
	$delicious_prefs->put('tag', 'dotclear','string','A tag');
	$delicious_prefs->put('count', 5,'integer','Number of links');	

	$core->setVersion('delicious',$new_version);
    dcPage::addSuccessNotice(__('Plugin delicious install done.'));
	return true;
} catch (Exception $e) {
	$core->error->add($e->getMessage());
}
return false;
