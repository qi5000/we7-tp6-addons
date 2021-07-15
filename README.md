ThinkPHP 6.0.8
===============

[微擎开发手册](https://www.kancloud.cn/monday/w7cc/content)

> 运行环境要求PHP7.2+，兼容PHP8.0。

## 将仓库拉取到本地

~~~dos
git clone https://gitee.com/holyking/wetp6_0.git
~~~

## 进入框架根目录, 安装composer依赖

~~~dos
cd wetp6_0

composer install
~~~

## 将框架文件放入微擎小程序模块根目录

#### 1. 修改 site.php 文件

~~~php
public function doWebAdmin()
{
    //这个操作被定义用来呈现 管理中心导航菜单
    require __DIR__ . '/public/admin.php';
}
~~~

#### 2. 修改 wxapp.php 文件

~~~php

// +--------------------------------------------------------
// | 小程序前端
// +--------------------------------------------------------

/**
 * 小程序接口入口方法
 */
public function doPageApi()
{
    require __DIR__ . '/public/api.php';
}

// +--------------------------------------------------------
// | 后台管理系统
// +--------------------------------------------------------

/**
 * 后台前后端分离开发环境使用
 * 
 * 正式环境必须将该方法注释或删除
 */
public function doPageAdmin()
{
    require __DIR__ . '/public/admin.php';
}

// +--------------------------------------------------------
// | 方法不存在魔术方法
// +--------------------------------------------------------

public function __call($name, $arguments)
{
    die(json_encode(['code' => 201, 'msg' => '小程序接口方法不存在'], JSON_UNESCAPED_UNICODE));
}
~~~

#### 3. 修改 manifest.xml 文件, 设置安装模块、升级模块、卸载模块时执行的文件

~~~
<install><![CDATA[install.php]]></install>
<uninstall><![CDATA[uninstall.php]]></uninstall>
<upgrade><![CDATA[upgrade.php]]></upgrade>
~~~

## 接口调用示例

#### 小程序前端接口

~~~
http://me.cy/app/index.php?c=entry&a=wxapp&i=3&m=lingchi_lottery_draw&do=api&s=/index/index
~~~

#### 后台管理系统开发环境

~~~
http://me.cy/app/index.php?c=entry&a=wxapp&i=3&m=lingchi_lottery_draw&do=admin&s=/test/index
~~~

#### 后台管理系统正式环境

~~~
http://me.cy/web/index.php?c=site&a=entry&eid=39&version_id=1&s=/test/index
~~~


## 消息队列

#### 引入扩展

~~~
composer require topthink/think-queue
~~~

#### 监听任务并执行

~~~
php think queue:listen --queue name --tries 5
~~~