# PHP框架ThinkPHP单元测试库:TPUNIT
## 一、概述：
thinkphp本身并没有提供相应的单元测试支持，所以本库的目的是将thinkphp中的一些功能集合起来打包成一个库，
使大家可以通过只需导入本库，便可对thinkphp进行单元测试，从而保证软件的质量。
特点是：易用，方便，非入侵式(部分方法除外)
支持版本：ThinkPHP3.2.3、5.x
当前TPUNIT版本：0.1

## 二、使用步骤
1. 定义TPUNIT_VERSION常量：5.x或者是3.2.3。
2. 定义TP_BASEPATH常量
3. 导入base.php库
4. 导入欲测试的文件
5. 使用phpunit运行单元测试

## 三、详细使用步骤

在Appcation下创建一个新的文件夹test，并新建一个测试类，命名为IndexTest.php。
其代码为：
<pre><code>
class IndexTest extends PHPUnit_Framework_TestCase{
    //构造函数
    function __construct(){
    	//定义TP的版本
    	define('TPUNIT_VERSION','3.2.3');
        //定义目录路径，最好为绝对路径
    	define('TP_BASEPATH', 'E:/www/novel/');
		//导入base库
		include_once 'E:\www\novel\Application\test\base.php';
		//导入要测试的控制器
		include_once 'E:\www\novel\Application\Home\Controller\IndexController.php';
    }
	//测试index动作
    public function testIndex(){
    	//新建控制器
        $index=new \Home\Controller\IndexController();
		//调用控制器的方法
		$index->test();
		//断言
		$this->expectOutputString('123');
    }

}
</code></pre>

Index控制器为：

<pre><code>
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    function test(){
    	echo 123;
	}
}
</code></pre>

然后运行phpunit进行单元测试：

phpunit E:\\www\\novel\\Application\\test\\IndexTest.php

## 四、使用注意

由于thinkphp代码中，ajaxReturn是使用exit进行处理的，所以导致了使用ajaxReturn的时候，会造成无法进行单元测试。

所以本库对ajaxReturn进行了一些修改。在使用断言的时候，需要通过事件来响应。

比如：

<pre><code>
try{
	//这里写上动作，该动作里面会调用ajaxReturn方法
}catch(AjaxReturnEvent $event){
	//这里写上断言，结果为：$event->getMessage()
	//比如：$this->assertEquals('123',$event->getMessage(),'test');
}
</code></pre>

## 五、对TP5.0进行测试

测试方式同上述一致，不过在需要额外定义常量TPUNIT_VERSION，该常量表明TP的版本而不是TPUNIT的版本。

比如：

<pre><code>
class IndexTest extends PHPUnit_Framework_TestCase{
    //构造函数
    function __construct(){
        //定义tp的版本信息-----------增加的内容
        define('TPUNIT_VERSION','5.x');
        //定义目录路径，最好为绝对路径
        define('TP_BASEPATH', 'E:/www/novel/');
		//导入base库
		include_once 'E:\www\novel\Application\test\base.php';
		//导入要测试的控制器
		include_once 'E:\www\novel\Application\Home\Controller\IndexController.php';
    }
	//测试index动作
    public function testIndex(){
    	//新建控制器
        $index=new \Home\Controller\IndexController();
		//调用控制器的方法
		$result=$index->test();//--------------------变动的内容
		//断言
		$this->assertEquals('123',$result);//---------------变动的内容
    }

}
</code></pre>

Index控制器为：

<pre><code>
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    function test(){
        return '123';
	}
}
</code></pre>

可以看到TP5.0相比较于之前的版本，是比较容易进行单元测试的。

## 六、基本原理

TP5.0是很容易进行单元测试的，但是3.2.x便很难进行。

而本库的原理是模拟5.x版本，首先定义一个base.php文件，该文件在5.0中是会定义一些常量，
并且注册一个自动导入的方法。

在对TP5.0进行测试的时候，实际上就是将TP框架中的thinkphp/base.php导入进行。而在之前的版本中，
则是模拟TP5.X，将一些常量导入进行，并且注册一个自动导入类的方法。

可以看出本库跟TP5.X是有异曲同工之妙：使TP之前的版本模拟TP5.X。

