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

global $core;

# Ajouter le plugin dans la liste des plugins du menu de l'administration
# TODO Dans la vesion de franck, je vois Blog plutôt que Plugin, je change … par contre dans la doc, je vois plugin ^^
$_menu['Plugins']->addItem(
#$_menu['Blog']->addItem(
	# nom du lien (en anglais)
	__('Delicious'),
	# URL de base de la page d'administration
	'plugin.php?p=delicious',
	# URL de l'image utilisée comme icône
	'index.php?pf=delicious/icon.png',
	# expression régulière de l'URL de la page d'administration
	preg_match('/plugin.php\?p=delicious(&.*)?$/',
		$_SERVER['REQUEST_URI']),
	# permissions nécessaires pour afficher le lien
	$core->auth->check('usage,contentadmin',$core->blog->id));
?>
