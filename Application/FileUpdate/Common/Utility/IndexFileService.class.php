<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace FileUpdate\Common\Utility;

use Think\Controller;
use FileUpdate\Common\Utility\PclZipController;
use FileUpdate\Common\Utility\FileBaseUtility as FileBase ;
use FileUpdate\Common\Utility\LogUtility as Log;
use FileUpdate\Common\Utility\DetectionUtility as Detection;

class IndexFileService extends Controller
{

	//更新包文件 与 原有文件 的数组结构
	public $fileOperation = array(
		'update'=>array( 'root_dir'=>array(), 'files'=>array(), 'dirs'=>array()),
		'old'=>array( 'root_dir'=>array(), 'files'=>array(), 'dirs'=>array())
	);

	//更新包根目录与程序根目录的路径 参数为 2 个, 第1个是更新包的路径, 第2个是需要替换的程序的路径
	public $dirArr = array();

	public $lastResult = array( 
		'updateAllFileList'=>array(),		//更新包内的全部文件列表 (结束后会被垃圾回收清除)
		'updateFilePathList'=>array(),		//需要更新的文件路径 (不包括文件名 创建目录的时候用)
		'backUpFileList'=>array(),			//需要备份的文件列表 (最后会被压缩成zip文件备份)
		'backUpFilePathList'=>array(),		//需要备份的文件路径 (不包括文件名 创建目录的时候用)
		'addFileList'=>array()				//需要追加的文件列表 (写到追加日志里面)
	);

	//需要备份的zip压缩包路径
	public $backUpPackFilePath = '';

	public function __construct( $arr ) {
		if ( false == empty( $arr )) {
			$this->dirArr = $arr;
			$this->fileAllPath();
			$this->fileReplace(
				$this->fileOperation['old']['files'], 
				$this->fileOperation['update']['files']
			);
		}
	}

	//将需要追加的文件写入到追加文件日志中,并将压缩包名称初始化到本类
	public function addFileLogBackUp( $pContent, $pFilePath ) {
		FileBase::writeFile( $pContent, $pFilePath )
			? Log::successReceive( 4 )
			: Log::inforReceive( __CLASS__.' '.__FUNCTION__.' '.__LINE__.' '.$pPath, 1 );
		$this->backUpPackFilePath = $pFilePath;
		return $pFilePath;
	}
	
	//检测更新后的文件是否存在
	public function scanUpdateFile( $pFilePath ) {
		Detection::scanFile( $pFilePath )
			? Log::successReceive( 7, $pFilePath )
			: Log::inforReceive( __CLASS__.' '.__FUNCTION__.' '.__LINE__.' ', 10 );
	}

	//检测备份日志是否存在
	public function scanBackUpLog( $pFilePath ) {
		Detection::scanFile( $pFilePath )
			? Log::successReceive( 8, $pFilePath )
			: Log::inforReceive( __CLASS__.' '.__FUNCTION__.' '.__LINE__.' ', 9 );
	}

	//获取 更新包文件 与 原有文件,返回数组结构
	private function fileAllPath() {
		$pathName = array_keys( $this->fileOperation );
		foreach ( $this->dirArr as $key=>$value ) 
			$this->myReaddir( $value, $pathName[$key] );
	}

	/**
	 * 获取目录下所有文件的路径
	 * [myReaddir get path infor on files and dirs]
	 * @param  [string] $dir     [any path]
	 * @param  [array] $arrName [case: 'name'=>array( 'root_dir'=>array(), files'=>array(), 'dirs'=>aray() )]
	 * @return [array] $fileOperation [path infor the files and dirs]
	 */
	private function myReaddir( $dir, $arrName ) {
		
		static $i = 0;

		//将文件根目录提取出来添加到数组里
		if ( $i == 0 ) {
			$dir == './' ? $tmpDir = $dir : $tmpDir = rtrim( $dir, '/' ).'/';
			$this->fileOperation[$arrName]['root_dir'][] = $tmpDir;
		}

		if ( false == is_dir( $dir )) 
			LogUtility::inforReceive( __CLASS__.' '.__FUNCTION__.' '.__LINE__.' '.$dir, 4 );	//错误报告

	    if ( false == ( $handle = opendir( $dir )))
        	LogUtility::inforReceive( __CLASS__.' '.__FUNCTION__.' '.__LINE__.' '.$path, 2 );

        //循环资源文件
	    while ( false !== ( $file = readdir( $handle ))) {
	    	//跳过不需要检测的文件
	        if (( $file == "." || $file == ".." || in_array( $file, $this->strConversionArr( IGNORE_FILES ) )))
	        	continue;
	        
	        //拼接地址
	        $path = rtrim( $dir, '/' ).'/'.$file;
	        //跳过不需要检测的目录
	        if ( $arrName == 'old' && in_array( $dir, $this->strConversionArr( IGNORE_DIRS ) ))
	        	continue;
	        //递归检测目录
	        if ( is_dir( $path )) {
	        	$i++;
	        	$this->myReaddir( $path, $arrName );
	        }
	        //分类文件与文件夹
	        is_dir( $path )
	        	? $this->fileOperation[$arrName]['dirs'][] = str_replace( $this->fileOperation[$arrName]['root_dir'][0], '', $path )
	        	: $this->fileOperation[$arrName]['files'][] = str_replace( $this->fileOperation[$arrName]['root_dir'][0], '', $path );

	    }

		$i = 0;
	    closedir( $handle ); 

	    return $this->fileOperation;	//虽然不用返回,这样写方便读和以后用

	}

	//返回需要替换的文件和目录,追加的文件和目录,还有需要更新的全部文件
	private function fileReplace( $pArr1, $pArr2 ) {
		$this->lastResult['updateAllFileList'] = $pArr2;
		$this->lastResult['updateFilePathList'] = $this->distinctPath( $this->lastResult['updateAllFileList'] );
		$this->lastResult['backUpFileList'] = array_intersect( $pArr1, $pArr2 );
		$this->lastResult['backUpFilePathList'] = $this->distinctPath( $this->lastResult['backUpFileList'] );
		$this->lastResult['addFileList'] = array_diff( $pArr2, $this->lastResult['backUpFileList'] );
	}

	//去掉文件名,去掉重复的路径并返回
	private function distinctPath( $pFilePathArr ) {
		$tmpArr = array();
		foreach ( $pFilePathArr as $value )
			$tmpArr[] = dirname( $value );
		return array_unique( $tmpArr );
	}

	//复制文件
	private function copyFiles( $pUpdateFilePath, $pBackUpFilePath ) {
		return FileBase::copyFile( $pUpdateFilePath, $pBackUpFilePath );
	}

	//字符串转换成数组
	private function strConversionArr( $pStr ) {
		return explode( ',', trim( $pStr ));
	}



}