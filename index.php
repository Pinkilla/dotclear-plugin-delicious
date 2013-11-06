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

// On arrive suite à un post du formulaire, dans ce cas,
// j'enregistre les valeurs en user_prefs
if (isset($_POST['update']) && ($_POST['update'] == '1')) {
	// Récupération de paramètres
	$user = $_POST['delicious_user'];
	$tag = $_POST['delicious_tag'];
	$count = $_POST['delicious_count'];

	try {
		$core->auth->user_prefs->addWorkSpace('delicious');
		$delicious_prefs = &$core->auth->user_prefs->delicious;
		$delicious_prefs->put('user', '','string','User id on delicous');
		$delicious_prefs->put('tag', 'dotclear','string','A tag');
		$delicious_prefs->put('count', 5,'integer','Number of links');	

		$core->blog->triggerBlog();
		dcPage::addSuccessNotice(__('Settings have been successfully updated.'));
	} catch (Exception $e) {
		$core->error->add($e->getMessage());
	}
	// redirect
	http::redirect($p_url.'&updated=1');
	exit;
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
		__('delicious'); ?>
	</h2>

	<?php
	echo dcPage::breadcrumb(
		array(
			html::escapeHTML($core->blog->name) => '',
			__('delicious') => ''
		)
	);

	echo dcPage::notices();

?>
<!-- Affichage des valeurs dans le tab 'view'-->
<div class="multi-part" id="view" title="Informations">
	<h3><?php echo __('Current configuration') ?></h3>
  	<?php 
  		$core->auth->user_prefs->addWorkSpace('delicious');
		$user = $core->auth->user_prefs->delicious->user;
		$tag = $core->auth->user_prefs->delicious->tag;
		$count = $core->auth->user_prefs->delicious->count;
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
