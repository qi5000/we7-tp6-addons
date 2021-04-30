ThinkPHP 6.0.8
===============

> 运行环境要求PHP7.2+，兼容PHP8.0。

## 安装

~~~
composer create-project topthink/think tp 6.0.*
~~~

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

~~~
http://me.cy/app/index.php?c=entry&a=wxapp&i=6&m=lingchi_bn&do=api&s=/index/index
~~~

