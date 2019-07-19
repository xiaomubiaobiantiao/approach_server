<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace FileUpdate\Common\Utility;

use Think\Controller;
use FileUpdate\Utility\PclZip;
use FileUpdate\Common\Utility\FileBaseUtility as FileBase;

class PclZipController extends Controller
{

	//zip压缩文件 目前仅支持文件在需要备份目录下的相对路径,也就是需要压缩的文件必须在生成压缩文件的根目录为起始。
	/**
	 * [createZip 创建zip压缩文件]
	 * @param  [string] $pPath        [将要生成的备份文件的路径(包括文件名和后缀)]
	 * @param  [array] $pFilePathArr [需要压缩的文件路径列表(包括文件名和后缀)]
	 * @return [type]               [error or success]
	 */
	public function createZip( $pPath, $pFilePathArr='' ) {
		//如果需要解压的路径不存在 尝试创建路径
		if ( FALSE == is_dir( $pPath ))
			FileBase::createDir( dirname( $pPath ));

		//初始化压缩类生成压缩文件的路径,路径必须是目录,不能是文件
		$zip = new PclZip( $pPath );
		//将需要压缩的文件列表创建到 zip 压缩包中
		$v_list = $zip->create( $pFilePathArr );

		if ( $v_list == 0 )
			return false;	//$zip->errorInfo( true ) 报错信息-备用
		
		return true;
	}

	//zip解压文件
	public function unpackZip( $pPath, $pToPath ) {
		//如果需要解压的路径不存在 尝试创建路径
		if ( FALSE == is_dir( $pToPath ))
			FileBase::createDir( dirname( $pToPath ));

		//要解压缩文件的路径
		$zip = new PclZip( $pPath );
		 
		if ( $zip->extract( $pToPath, './backup/' ) == 0 )
			return false;	//$zip->errorInfo( true ) 报错信息-备用
		    
		return true;

	}




}