ThinkPHP 6.0.8
===============

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
require __DIR__ . '/public/admin.php';
~~~

#### 2. 修改 wxapp.php 文件

~~~php
public function __call($name, $arguments)
{
    require __DIR__ . '/public/' . substr(strtolower($name), 6) . '.php';
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
http://me.cy/app/index.php?c=entry&a=wxapp&i=6&m=lingchi_bn&do=api&s=/index/index
~~~

