<?php
#########################################################################
# File Name:	./ApiController.class.php
# Author:		chenishr
# mail:			chenishr@gmail.com
# Created Time:	2016年09月10日 星期六 13时05分09秒
#########################################################################
namespace Home\Controller;
use Think\Controller;
use Think\Log;

// import TPWechat
\vendor('Wechat.TPWechat');
class ApiController extends CommonController {
    public function index(){
		Log::write('index');
		echo '123';
    }

	public function events(){
		$this->weObj->valid();
		$data	= $this->weObj->getRev()->getRevData();

		$type	= $data['MsgType'];

		switch($type) {
		case \TPWechat::MSGTYPE_TEXT:
			//回复文本消息
			$this->text($data);
			break;

		case \TPWechat::MSGTYPE_EVENT:
			$this->event($data);
			break;
		case \TPWechat::MSGTYPE_IMAGE:
			$this->image($data);
			break;
		default:
			$this->default_reply($data);
		}
	}

	protected function image($data){
		$this->default_reply($data);
	}

	protected function event($data){
		$event	= $data['Event'];

		switch($event){
			// 回复关注事件
		case \TPWechat::EVENT_SUBSCRIBE:
			$this->event_subscribe($data);
			break;

		default:
			$this->default_reply($data);
		}
	}

	protected function event_subscribe($data){
		$news	=  array(
			"0"=>array(
				'Title'=>'成为会员通知',
				'Description'=>date('m')." 月 ".date('d')." 日\n恭喜您成为我们尊贵的会员。",
				'PicUrl'=>'',
				'Url'=>'http://'.$_SERVER['SERVER_NAME'].U('Index/index'),
			),
		);

		$this->weObj->news($news)->reply();
	}

	protected function text($data){
		$this->weObj->text("你说：".$data['Content'])->reply();
	}

	protected function default_reply($data){
		$this->weObj->text("unhandle action\n".var_export($data,true))->reply();
	}
}

