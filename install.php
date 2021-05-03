<?php

// 安装模块时
// 创建模块的数据表

$sql = "

CREATE TABLE `ims_liang_config` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
    `uniacid` int(11) DEFAULT NULL COMMENT '平台ID',
    `type` varchar(60) DEFAULT NULL COMMENT '配置分组',
    `key` varchar(255) NOT NULL COMMENT '配置键',
    `value` text COMMENT '配置值',
    `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
    `create_time` int(11) NOT NULL COMMENT '创建时间',
    `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
    PRIMARY KEY (`id`) USING BTREE
  ) ENGINE=InnoDB DEFAULT COMMENT='系统配置表';

CREATE TABLE `ims_liang_storage` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键且自增',
    `uniacid` int(11) NOT NULL COMMENT '平台ID',
    `type` tinyint(1) NOT NULL COMMENT '云存储类型 1 七牛云 2 阿里云 3 腾讯云',
    `bucket` varchar(60) NOT NULL DEFAULT '' COMMENT '存储空间, 存储桶名称',
    `region` varchar(255) DEFAULT NULL COMMENT '腾讯云存储桶地域',
    `domain` varchar(120) DEFAULT '' COMMENT '访问域名',
    `accessKey` varchar(120) NOT NULL DEFAULT '' COMMENT '访问密钥 key, 腾讯云 SecretId',
    `secretKey` varchar(120) NOT NULL DEFAULT '' COMMENT '访问秘钥 secret, 腾讯云 SecretKey',
    `endpoint` varchar(120) DEFAULT '' COMMENT '阿里云OSS外网地址',
    `in_use` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否正在使用 0 未使用 1 正在使用',
    `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
    `create_time` int(11) DEFAULT NULL COMMENT '添加时间',
    `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
    PRIMARY KEY (`id`) USING BTREE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='云存储配置';

";

pdo_run($sql);
