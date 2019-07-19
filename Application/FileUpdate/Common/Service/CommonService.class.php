<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */

namespace FileUpdate\Common\Service;

use Think\Controller;

class CommonService extends Controller
{

    //删除数据和文件 - 待完善
    public function deleteData( $pId ) {

        $data = $this->PackModel->getDataOne( array( 'id'=>$pId ) );

        if ( is_file( $data['relative_path'] ))
                unlink( $data['relative_path'] );

        $this->PackModel->deleteAction( array( 'id'=>$pId ));

        return true;

    }

	//字符串转换成数组
	private function strConversionArr( $pStr, $pChar = ',' ) {
		return explode( $pChar, trim( $pStr ));
	}

	//数组转换成字符串
	public function arrStr( $pArr, $pChar = '<|>' ) {
		$data = array_values( $pArr );
		return implode( $pChar, $data );
	}

	



}