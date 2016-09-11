<?php
#########################################################################
# File Name:	TPWechat.php
# Author:		chenishr
# mail:			chenishr@gmail.com
# Created Time:	2016年09月10日 星期六 12时32分08秒
#########################################################################
/**
 *	微信公众平台PHP-SDK, ThinkPHP实例
 *  @author dodgepudding@gmail.com
 *  @link https://github.com/dodgepudding/wechat-php-sdk
 *  @version 1.2
 *  usage:
 *   $options = array(
 *			'token'=>'tokenaccesskey', //填写你设定的key
 *			'encodingaeskey'=>'encodingaeskey', //填写加密用的EncodingAESKey
 *			'appid'=>'wxdk1234567890', //填写高级调用功能的app id
 *			'appsecret'=>'xxxxxxxxxxxxxxxxxxx' //填写高级调用功能的密钥
 *		);
 *	 $weObj = new TPWechat($options);
 *   $weObj->valid();
 *   ...
 *
 */
vendor('Wechat.Wechat');
class TPWechat extends \Wechat
{
	/**
	 * log overwrite
	 * @see Wechat::log()
	 */
	protected function log($log){
		if ($this->debug) {
			if (function_exists($this->logcallback)) {
				if (is_array($log)) $log = print_r($log,true);
				return call_user_func($this->logcallback,$log);
			}elseif (class_exists('\Think\Log')) {
				\Think\Log::write('wechat：'.$log, \Think\Log::DEBUG);
				return true;
			}
		}
		return false;
	}
	/**
	 * 重载设置缓存
	 * @param string $cachename
	 * @param mixed $value
	 * @param int $expired
	 * @return boolean
	 */
	protected function setCache($cachename,$value,$expired){
		$this->log('setCache::name='.$cachename.':value='.$value.':expired='.$expired);
		return S($cachename,$value,$expired);
	}
	/**
	 * 重载获取缓存
	 * @param string $cachename
	 * @return mixed
	 */
	protected function getCache($cachename){
		$this->log('getCache::name='.$cachename.':value='.S($cachename));
		return S($cachename);
	}
	/**
	 * 重载清除缓存
	 * @param string $cachename
	 * @return boolean
	 */
	protected function removeCache($cachename){
		$this->log('removeCache::name='.$cachename);
		return S($cachename,null);
	}
}
