<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace FileUpdate\Service\Pack;

use FileUpdate\Common\Service\CommonService;
use FileUpdate\Common\Utility\UploadUtility as Upload;

class PackService extends CommonService
{

	public function __construct() {
		parent::__construct();
		$this->PackModel = D( 'Pack' );
	}

	//文件上传配置
	public function fileUpload (){
		//检查上传路径,不存在则创建
		if ( FALSE == is_dir( UPLOAD_PATH )) mkdir( UPLOAD_PATH, 0777 );
		//检查文件是否存在重名
		if ( is_file( $_SERVER['DOCUMENT_ROOT'].'/'.ltrim( UPLOAD_PATH, '.' ).$_FILES['photo']['name'] )) {
			$this->error( '文件重名,请更改' );
			return FALSE;
		}
		//配置上传文件信息
		$config = array(
		    'maxSize'    =>    0,
		    'rootPath'   =>    UPLOAD_PATH,
		    'savePath'   =>    '',
		    'saveName'   =>    '',
		    'saveRule'	 =>	   '',
		    'exts'       =>    array('jpg', 'gif', 'png', 'jpeg', 'rar', 'html', 'zip', 'txt'),
		    'autoSub'    =>    false,
		    'subName'    =>    array('date','Ymd'),
		);

		$Upload = new Upload();

		return $Upload->upload( $config );

	}

	//数据库添加信息
	public function addData() {
		//上传文件
		$resultName = $this->fileUpload();
		if ( false == $resultName ) $this->error( '上传失败！' );
		//拼接上传文件全路径
		$uploadPath =  $_SERVER['DOCUMENT_ROOT'].'/'.ltrim( UPLOAD_PATH, '.' ).$resultName;
		//整理需要添加的数据信息
		$data = array(
			'pack_name' => $resultName,
			'path' 	=> $uploadPath,
			'relative_path' => ltrim( UPLOAD_PATH, '.' ).$resultName,
			'download' => '',
			'user' => '目前为空',
			'type' => 1,
			'add_time' => time(),
			'update_time' => time()
		);
		//添加一条更新包记录
		$resultId = $this->PackModel->insertData( $data );
		//判断上传文件与数据库信息是否同步添加成功,如果非同步,则全部删除(删除数据库本次记录和本地上传的本次文件)
		if ( FALSE === $resultName || FALSE === $resultId || FALSE == is_file( $uploadPath )) {
			$this->deleteData( $pId );
			//$this->deleteData( $resultId );
			return false;
		}
		
		return true;

	}
	
	//查看数据
	public function checkData() {
		return $this->PackModel->getDataList();
	}

	//删除数据 - 待完善
	// public function deleteData( $pId ) {
	// 	die( 'aaab' );
	// 	$data = $this->PackModel->getDataOne( $pId );
	// 	if ( is_file( $data['path'] ))
	// 			unlink(  $data['path'] );

	// 	$this->PackModel->deleteAction( array( 'id'=>$pId ));

	// 	return true;

	// }



}