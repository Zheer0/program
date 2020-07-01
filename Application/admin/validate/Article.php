<?php
namespace app\admin\validate;
use think\Validate;
use think\Db;

class Article extends  Validate
{
  protected $rule =[
'title'=>'require|max:25',
'cateid'=>'require',
  ];
  // 验证信息提示
  	protected $message = [
'title.require' =>'文章标题必须填写',
  'title.max' =>'文章标题不得大于25位',
'cateid.require' =>'请选择所属栏目',
  	];
  	// 验证场景
  protected $scene = [
'add' =>['title'=>'require','cateid'],
'edit' =>['title'=>'require','cateid'],


  ];

}