<?php
/**
 * 文件检测类
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace FileUpdate\Common\Utility;

use FileUpdate\Common\Utility\FileBaseUtility as FileBase;
use FileUpdate\Supply\Log\Logs;

class DetectionUtility extends Logs
{

	public $errorInfo = array(

			1 => 'Search update file',
			2 => 'Search Additional log files',
			3 => 'Search Backup zip',
			4 => 'Search version'
	);

	public $successInfo = array(
			1 => 'Search update file complete!',
			2 => 'Search Additional log files complete!',
			3 => 'Search Backup zip complete!',
			4 => 'Search version complete!'
	);

	//检测文件
	public function scanFile( $pFilePath ) {
		return FileBase::detectionFile( $pFilePath );
	}
	
	//检测目录
	public function scanDir( $pFilePath ) {
		return FileBase::detectionDir( $pFilePath );
	}




}