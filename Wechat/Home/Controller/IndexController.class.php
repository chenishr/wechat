<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){

		echo "<h1>Hello,world!</h1>";
    }

	public function api(){
		$this->weObj->valid();
		$data	= $this->weObj->getRev()->getRevData();
		logg('Recive Data:'.var_export($data,true));

		$type	= $data['MsgType'];

		switch($type) {
		case \TPWchat::MSGTYPE_TEXT:
			$this->weObj->text("hello, I'm wechat")->reply();
			exit;
			break;
		case \TPWchat::MSGTYPE_EVENT:
			$event	= $data['Event'];

			switch($event){
			case \TPWchat::EVENT_SUBSCRIBE:
				$text	= "";

				$news	=  array(
					"0"=>array(
						'Title'=>'成为会员通知',
						'Description'=>date('m')." 月 ".date('d')." 日\n恭喜您成为 TOMEI 会员\n请您进一步完善信息，成为我们尊贵的会员。",
						'PicUrl'=>'',
						'Url'=>'http://'.$_SERVER['SERVER_NAME'].'/index.php?c=Web&a=verify_phone'
					),
				);

				$this->weObj->news($news)->reply();

				exit;
				break;
			}
			break;
		case \TPWchat::MSGTYPE_IMAGE:
			break;
		default:
			$this->weObj->text("help info")->reply();
		}
	}
}
