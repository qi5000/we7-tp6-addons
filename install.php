<?php

// 安装模块执行 创建模块的数据表

$sql = "

CREATE TABLE IF NOT EXISTS `ims_applet_config` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
    `uniacid` int(11) DEFAULT NULL COMMENT '平台ID',
    `type` varchar(60) DEFAULT NULL COMMENT '配置分组',
    `key` varchar(255) NOT NULL DEFAULT '' COMMENT '配置键',
    `value` text COMMENT '配置值',
    `note` varchar(255) DEFAULT NULL COMMENT '功能说明',
    `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
    `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
    `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE KEY `unique_key` (`uniacid`,`key`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统配置表';

CREATE TABLE IF NOT EXISTS `ims_applet_message_push` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
    `uniacid` int(11) DEFAULT NULL COMMENT '微擎平台uniacid',
    `openid` varchar(50) DEFAULT NULL COMMENT '接收者用户openid',
    `content` text COMMENT '回复内容 (场景类型 type 1 客服二维码)',
    `status` tinyint(1) DEFAULT '0' COMMENT '状态 0 待发送 1 已发送 默认为 0',
    `create_time` datetime DEFAULT NULL,
    `update_time` datetime DEFAULT NULL,
    `delete_time` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服会话待发送纪录';

CREATE TABLE IF NOT EXISTS `ims_applet_platform` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
    `uniacid` int(11) DEFAULT NULL COMMENT '微擎平台uniacid',
    `name` varchar(255) DEFAULT NULL COMMENT '平台名称',
    `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态 0 未绑定 1 已绑定',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='平台信息表(限制多开)';

CREATE TABLE IF NOT EXISTS `ims_applet_problem` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
    `uniacid` int(11) NOT NULL DEFAULT '0' COMMENT '微擎平台uniacid',
    `classify_id` int(11) DEFAULT NULL COMMENT '问题分类id',
    `title` varchar(255) DEFAULT NULL COMMENT '问题',
    `answer` varchar(255) DEFAULT NULL COMMENT '回答',
    `sort` int(11) DEFAULT NULL COMMENT '排序值，越大越靠前',
    `status` tinyint(1) DEFAULT '1' COMMENT '状态 0 隐藏 1 显示 默认为 1',
    `create_time` int(11) DEFAULT NULL COMMENT '添加时间',
    `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
    `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='常见问题表';

CREATE TABLE IF NOT EXISTS `ims_applet_problem_classify` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '问题分类id',
    `uniacid` int(11) NOT NULL DEFAULT '0' COMMENT '微擎平台uniacid',
    `name` varchar(60) DEFAULT NULL COMMENT '分类名称',
    `sort` int(11) DEFAULT NULL COMMENT '排序值，越大越靠前',
    `status` tinyint(1) DEFAULT NULL COMMENT '状态 0 隐藏 1 显示 默认为 1',
    `create_time` int(11) DEFAULT NULL COMMENT '添加时间',
    `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
    `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='常见问题分类表';

CREATE TABLE IF NOT EXISTS `ims_applet_storage` (
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

CREATE TABLE IF NOT EXISTS `ims_applet_user` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
    `uniacid` int(11) NOT NULL DEFAULT '0' COMMENT '平台id',
    `unionid` varchar(30) DEFAULT '' COMMENT '开发平台唯一标识',
    `openid` varchar(50) NOT NULL DEFAULT '' COMMENT '用户openid',
    `nickName` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '微信昵称',
    `gender` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别 0 未知 1 男 2 女',
    `avatarUrl` varchar(255) NOT NULL DEFAULT '' COMMENT '微信头像',
    `create_time` int(11) NOT NULL COMMENT '添加时间',
    `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
    `delete_time` int(11) DEFAULT NULL COMMENT '软删除',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

";

pdo_run($sql);
