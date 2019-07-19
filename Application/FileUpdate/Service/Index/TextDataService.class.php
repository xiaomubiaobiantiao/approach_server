<?php
/**
 * 文本转换系统
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace FileUpdate\Service\Index;

use FileUpdate\Common\Service\CommonService;

class TextConversionService extends CommonService
{

	//数组转换成字符串
	public function arrConversionStr( $pArr ) {
		foreach ( $pArr as $value ) {
			dump( $this->arrStr( $value ));
		}
	}

	


}