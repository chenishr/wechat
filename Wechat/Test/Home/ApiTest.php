<?php
#########################################################################
# File Name:	ApiTest.php
# Author:		chenishr
# mail:			chenishr@gmail.com
# Created Time:	2016年09月10日 星期六 23时16分35秒
#########################################################################
class ApiTest extends PHPUnit_Framework_TestCase{
    //构造函数
    function __construct(){
        //定义TP的版本
        define('TPUNIT_VERSION','3.2.3');
        //定义目录路径，最好为绝对路径
        define('TP_BASEPATH', '/var/www/tomei/');
        //定义应用目录
        define('APP_NAME', 'Wechat');
        //导入base库
        include_once TP_BASEPATH.APP_NAME.'/Test/TPUNIT/base.php';
        ////导入要测试的控制器
        include_once TP_BASEPATH.APP_NAME.'/Home/Controller/ApiController.class.php';
    }

    //测试index动作
    public function testIndex(){
        //新建控制器
        $index=new \Home\Controller\ApiController();
        //调用控制器的方法
        $index->index();
        //断言
        $this->expectOutputString('123');
    }

}
