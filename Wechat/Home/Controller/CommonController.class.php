<?php
#########################################################################
# File Name:	./CommonController.class.php
# Author:		chenishr
# mail:			chenishr@gmail.com
# Created Time:	2016年09月10日 星期六 12时58分01秒
#########################################################################
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function __construct(){
		parent::__construct();

		//  测试号
		$options = array(
				'appid'=>'******************', //填写高级调用功能的app id, 
				'appsecret'=>'********************************', //填写高级调用功能的密钥
				'token'=>'*******************', //填写你设定的key
				'encodingaeskey'=>'*******************************************',
				);

		vendor('Wechat.TPWechat');
		$this->weObj = new \TPWechat($options);
	}
}
