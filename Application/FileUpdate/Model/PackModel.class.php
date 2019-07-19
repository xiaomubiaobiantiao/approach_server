<?php
/**
 * Created by Sublime Text
 * @author Michael
 * DateTime: 19-6-27 09:37:00
 */
namespace FileUpdate\Model;

use FileUpdate\Common\Model\CommonModel;

class PackModel extends CommonModel{

	protected $pk = 'id';

	protected $autoinc = true;

	protected $trueTableName = 'file_pack_infor';

	protected $fields = array(
		'id', 'pack_name', 'path', 'relative_path', 'download', 'user', 'type', 'type_name', 'add_time', 'update_time',

		//提供类型, 以供某些验证用, 目前未用到
		'_type'=>array(
			'id'=>'int', 'pack_name'=>'varchar', 'path'=>'varchar',
			'relative_path'=>'varchar', 'download'=>'varchar', 'user'=>'varchar',
			'type'=>'tinyint', 'type_name'=>'varchar', 'add_time'=>'int', 'update_time'=>'int'
		)

	);




}
