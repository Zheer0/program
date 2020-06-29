<?php
namespace Admin\Controller;
use Think\Controller;
//后台用户登录
class LoginController extends Controller {
     
    public function index(){
        if (IS_POST) {
            if (false === $this->checkVerify(I('post.verify'))) {
                $this->error('验证码错误', U('Login/index'));  
            }
             
            $Admin = D('Admin');
            if (! $Admin->create()) {
                $this->error('登录失败：' . $Admin->getError(), U('Login/index'));
            }
          
            $username = $Admin->username; 
           
            $userinfo = $Admin->checkLogin();
            if ($userinfo) {
                 
                session('userinfo', $userinfo);  
                $this->redirect('Index/index');
            }
            $this->error('登录失败：用户名或密码错误。', U('Login/index'));
        }
        
        $this->display();
    }
    
    
	//生成验证码
    public function getVerify() {
        $Verify = new \Think\Verify();
		$Verify->entry();
    }
	//检查验证码
    private function checkVerify($code, $id = '') {
        $Verify = new \Think\Verify();
        return $Verify->check($code, $id);
    }
	//退出系统
	public function logout(){
		session(null);  
		$this->redirect('Login/index');
	}
	public function _empty($name){
		$this->error('无效的操作：'.$name);
    }
}
