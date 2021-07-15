<?php

// 卸载模块 删除模块的数据表

$sql = <<<EOT

DROP TABLE IF EXISTS `ims_applet_config`;
DROP TABLE IF EXISTS `ims_applet_storage`;
DROP TABLE IF EXISTS `ims_applet_user`;

EOT;

pdo_run($sql);
