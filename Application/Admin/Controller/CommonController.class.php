<?php
namespace Admin\Controller;
use Think\Controller;
//后台公共控制器
class CommonController extends Controller{
	
    public function __construct() {
        parent::__construct();  
		$this->checkUser();    		 
		$this->assign('admin_name',session('userinfo.name'));
		$this->assign('admin_priv',session('userinfo.priv'));
    }
	//检查用户是否已经登录
	private function checkUser(){
		if(!session('?userinfo')){
			
			$this->redirect('Login/index');
		}
	}
	public function _empty($name){
		$this->error('无效的操作：'.$name);
    }
}
