ThinkPHP 6.0.8
===============

> 运行环境要求PHP7.2+，兼容PHP8.0。

## 安装

~~~
composer create-project topthink/think tp 6.0.*
~~~

#### 3. 修改 manifest.xml 文件, 设置安装模块、升级模块、卸载模块时执行的文件

~~~
<install><![CDATA[install.php]]></install>
<uninstall><![CDATA[uninstall.php]]></uninstall>
<upgrade><![CDATA[upgrade.php]]></upgrade>
~~~