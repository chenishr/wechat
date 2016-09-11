<?php
#########################################################################
# File Name:	Seaslog.class.php
# Author:		chenishr
# mail:			chenishr@gmail.com
# Created Time:	2016年09月10日 星期六 14时55分27秒
#########################################################################

namespace Think\Log\Driver;

class Seaslog{
	public function __construct(){
		\SeasLog::setBasePath(C('LOG_PATH'));
		\SeasLog::setLogger(CONTROLLER_NAME);
	}

	public function write($log,$level="INFO"){
		$this->log($log,$level);
	}

	public function log($log,$level="INFO"){
		switch(strtoupper($level)){
		case 'EMERG':
			\SeasLog::emergency($log);
			break;
		case 'ALERT':
			\SeasLog::alert($log);
			break;
		case 'CRIT':
			\SeasLog::critical($log);
			break;
		case 'ERR':
			\SeasLog::error($log);
			break;
		case 'WARN':
			\SeasLog::warning($log);
			break;
		case 'INFO':
			\SeasLog::info($log);
			break;
		case 'DEBUG':
			\SeasLog::debug($log);
			break;
		default:
			\SeasLog::info($log);
			break;
		}
	}
}
