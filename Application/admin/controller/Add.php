<?php
namespace app\admin\controller;
use app\admin\controller\Base;

use think\Db;

class Add extends  Base
{

    public function index()
    {     
   



      //获取提交的信息
    	if(request()->isPost()){ 
        
    		$data=[
    			'username'=>input('username') ,              
    			'password'=>md5(input('password')),
    		];   
             // 验证提交的信息
            $validate = \think\ Loader::validate('Admin');
            // 显示错误信息
    if(!$validate->scene('add')->check($data)) {
    	$this->error($validate->getError());
    	die;
    }
           // 添加到数据库
		if(Db::name('admin')->insert($data)){
    		return $this->success('添加成功');
    	}
    	else{
    		return  $this->error('添加失败');
    	}
    	return;
    }
        return $this->fetch('add');

    }  
}
