<?php
if (!defined('DC_RC_PATH')) { return; }

require_once dirname(__FILE__) . '/delicious.class.php';

$core->tpl->addValue('Delicious',array('deliciousClass','deliciousFct'));

?>
