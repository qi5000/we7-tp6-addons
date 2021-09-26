ThinkPHP 6.0.9
===============

[开发手册](https://www.kancloud.cn/monday/w7cc/content)

> 运行环境要求PHP7.2.5+，兼容PHP8.0。

## 环境要求

+ linux
+ mysql5.7
+ php7.2.5+
+ redis

## 将仓库拉取到本地

~~~dos
git clone https://gitee.com/holyking/wechat-applet.git
~~~

## 进入框架根目录, 安装composer依赖

~~~dos
cd wechat-applet && composer install
~~~

## 将框架文件放入微擎小程序模块根目录

#### 1. 修改 manifest.xml 文件

设置安装模块、升级模块、卸载模块时执行的文件

~~~
<install><![CDATA[install.php]]></install>
<uninstall><![CDATA[uninstall.php]]></uninstall>
<upgrade><![CDATA[upgrade.php]]></upgrade>
~~~

#### 2. 修改 site.php 文件

~~~php
// +--------------------------------------------------------
// | 后台管理系统入口
// +--------------------------------------------------------

public function doWebAdmin()
{
    // 给模块指定PHP版本使用
    if (!isset($_GET['module'])) {
        global $_W;
        header('Location: ' . $_SERVER['REQUEST_URI'] . '&module=' . $_W['current_module']['name']);
        exit;
    }
    // PHP版本检测
    if (version_compare(PHP_VERSION, '7.2.5', '<')) {
        die('检测到您到PHP版本过低, 系统无法正常使用<br><br>系统运行环境要求PHP版本不能低于 7.2.5, 当前PHP版本:' . PHP_VERSION);
    }
    //这个操作被定义用来呈现 管理中心导航菜单
    require __DIR__ . '/public/admin.php';
}
~~~

#### 2. 修改 wxapp.php 文件

~~~php

// +--------------------------------------------------------
// | 小程序
// +--------------------------------------------------------

/**
 * 小程序接口入口
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

## 接口调用

>[success] 小程序前端接口

+ 小程序接口全部放在 api 应用下, 通过改变URL地址中的 s 参数值来访问不同的控制器方法

~~~
http://liang8080.natapp1.cc/app/index.php?c=entry&a=wxapp&i=2&m=liang_tp_applet&do=api&s=/example/queue
~~~

>[success] 后台管理系统开发环境

+ 无需登录,可以直接访问接口
+ 为了开发时方便前端人员调用后台接口提供了以下方式

~~~
http://liang8080.natapp1.cc/app/index.php?c=entry&a=wxapp&i=2&m=liang_tp_applet&do=admin&s=/test/index
~~~

>[success] 后台管理系统正式环境

+ 动态参数: eid、version_id (通过TP模板赋值获取)

~~~
http://liang8080.natapp1.cc/web/index.php?c=site&a=entry&eid=39&version_id=1&s=/test/index
~~~

## 消息队列

#### 监听任务并执行

~~~
php think queue:listen --queue liang_tp_applet --tries 5
~~~