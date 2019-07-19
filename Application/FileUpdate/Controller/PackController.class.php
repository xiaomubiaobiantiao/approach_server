<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace FileUpdate\Controller;

use Think\Controller;
use FileUpdate\Service\Pack\PackService;

class PackController extends Controller  //\Home\Controller\IndexController
{

	private $packService; //压缩包服务类

	public function __construct() {
		//为了加载权限管理
		parent::__construct();
		//初始化压缩包服务类
		$this->PackService = new PackService();
	}

	//主页面 - 视图
	public function index() {
		
		//加载首页面压缩包展示
		$packInfo = $this->PackService->checkData();
		//$packInfo = M( 'file_pack_infor' )->select();
		$this->assign( 'list', $packInfo );
		$this->display();
		//parent::index();
		
		//echo 123;
		//查看当前版本
	}

	//添加
	public function add() {

		$result = $this->PackService->addData();
		$this->tips( $result );

	}

	//刪除
	public function del() {


		$id = I('get.id','input type int please','int');
		$result = $this->PackService->deleteData( $id );

		$this->tips( $result );

	}

	//跳转提示 - 暂时未写
	public function tips( $pTips, $pStr='' ) {
		FALSE == $pTips
			? $this->error( $pStr.'失败' )
			: $this->success( $pStr.'成功' );
	}

	//查看
	public function check() {
		echo '页面未开放';
		//$this->display();
	}



}