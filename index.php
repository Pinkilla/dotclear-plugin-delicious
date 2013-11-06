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

if (!defined('DC_CONTEXT_ADMIN')) { exit; }

require_once dirname(__FILE__) . '/inc/delicious.class.php';

// Lecture des paramètres de configuration dans le fichier ini
$config_file = dirname(__FILE__) . '/settings.ini';
$errors = deliciousClass::check_file_perms($config_file);
$settings = deliciousClass::get_settings($config_file);
$user = ''; 
$tag = '';
$count = '';
// Définition d'un namespace dans la DB
//$delicious_ns = 'delicious'; 
//$core->blog->settings->addNameSpace($delicious_ns);

// On arrive suite à un post du formulaire
if (isset($_POST['update']) && ($_POST['update'] == '1')) {
	// Récupération de paramètres
	$new_settings =array(
		'delicious_user' => $_POST['delicious_user'],
		'delicious_tag' => $_POST['delicious_tag'],
		'delicious_count' => $_POST['delicious_count']
	);

	// Nécessité d'écrire dans la DB (ça évite les lectures j'imagine)
	try {
		$core->blog->settings->addNameSpace('delicious');
		foreach ($new_settings as $key => $value) {
			$core->blog->settings->delicious->put($key, $value);			
		}
		$core->blog->triggerBlog();
		dcPage::addSuccessNotice(__('Settings have been successfully updated.'));
	} catch (Exception $e) {
		$core->error->add($e->getMessage());
	}


	// Sauvegarde dans le fichier de conf
	if (deliciousClass::write_ini_file($config_file, $new_settings)) {
		// redirect
		http::redirect($p_url.'&updated=1');
		exit;
	} else {
		$errors[] = __('Unable to write settings in the configuration file');
    }

}




?>
<html>
<head>
	<title><?php echo(__('Delicious')); ?></title>
	<?php 
		$default_tab = 'view';
		echo dcPage::jsPageTabs($default_tab); 
	?>
</head>
<body>
	<h2>
		<?php echo html::escapeHTML($core->blog->name).' &rsaquo; '.
		__('Delicious'); ?>
	</h2>

	<?php
	echo dcPage::breadcrumb(
		array(
			html::escapeHTML($core->blog->name) => '',
			__('delicious') => ''
		)
	);

	echo dcPage::notices();

/*
	if (count($errors) > 0) {
		// Il y a eu des erreurs pendant la gestion des paramètres
  		echo '<div class="error"><ul>';
		foreach ($errors as $error) {
			echo '<li>'.$error.'</li>';
		}
		echo '</ul></div>';
	} elseif (!empty($_GET['updated'])) {
		// L'update s'est fait sans soucis
		echo '<p class="message">'.__('Settings has been successfully updated').'</p>';
	} else {
		// Ni erreur ni update, j'arrive pour la première fois
		// mais quoi qu'il arrrive, j'affiche le formulaire ... 
	}
	*/
?>
<!-- Affichage des valeurs dans le tab 'view'-->
<div class="multi-part" id="view" title="Informations">
	<h3><?php echo __('Current configuration') ?></h3>
  	<?php 
		$user = (isset($settings['delicious_user'])) 
			? $settings['delicious_user'] : ''; 
		$tag = (isset($settings['delicious_tag'])) 
			? $settings['delicious_tag'] : ''; 
		$count = (isset($settings['delicious_count'])) 
			? $settings['delicious_count'] : 'default'; 
	?>
	<p>
		Current user: <?php echo $user ?> <br/>
		Current tag: <?php echo $tag ?> <br/>
		Current count: <?php echo $count ?> 
	</p>
</div>


<!-- Affichage du formulaire dans le tab update -->
<div class="multi-part" id="update" title="Update">
	<h3><?php echo __('Update settings') ?></h3>

<?php ?>
	<form action="<?php echo $p_url ?>" method="post">'
		<fieldset><legend>Enter settings in the form below</legend>
			<p><label for="delicious_user">Default user</label>
				<?php echo form::field('delicious_user',30,128,
					$settings['delicious_user']) ?>
			</p>
			<p><label for="delicious_tag">Default tag</label>
				<?php echo form::field('delicious_tag',30,128,
					$settings['delicious_tag']) ?>
			</p>
			<p><label for="delicious_count">Default count</label>
				<?php echo form::field('delicious_count',30,128,
					$settings['delicious_count']) ?>
			</p>
			<p>
				<input type="hidden" name="update" value="1"/>
				<input type="submit" value="<?php echo __('Update') ?>"/>
			</p>
		</fieldset>
		<?php echo $core->formNonce() ?>
	</form>
</div>

</body>
</html>
