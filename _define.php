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
 
$this->registerModule(
        /* Name */			"Delicious",
        /* Description*/    "Get delicious links",
        /* Author */        "Pierre Bettens, Pinkilla",
        /* Version */       '0.0.2',
        array(
		/* Permissions */	'permissions' =>	'usage, contentadmin',
		/* Configuration 	'standalone_config'	=> true,*/
		/* Type */			'type' =>			'plugin'
		)        
);
?>
