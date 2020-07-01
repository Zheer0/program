<?php
namespace Admin\Controller;
//前台会员控制器
class UserController extends CommonController{
	public function index(){
		//取出会员信息
		$data = D('User')->getList();
		$data['priv'] = session('userinfo.priv');
		$this->assign($data);
		$this->display();
	}
	//会员修改
	public function edit(){
	   
	    $id = I('get.id/d',0);         //待修改ID
	  
	    $User = D('User');
	    
	    if(IS_POST){
	   
			if(!$User->create(null,2)){
				$this->error('修改失败：'.$User->getError());
			}
			
			if(false === $User->where(array('id'=>$id))->save()){
				$this->error('修改失败：保存到数据库失败。');
			}
			
			$this->redirect('User/index');
	    }
	   
	    $where = array('id'=>$id);
	  
	    $data['user'] = $User->getUser($where);
	    if(!$data['user']){
	        $this->error('用户不存在！');
	    }
	    
	    $data['priv'] = session('userinfo.priv');
	    $this->assign($data);
	    $this->display();
	}
	//删除
	public function del(){
	   
	    if(!IS_POST) $this->error('删除失败！');
	    
	    $id = I('post.id/d',0);  //ID
	    
	    $jump = U('User/index');
	    
	    $User = D('User');
	    
	    if(!$User->autoCheckToken($_POST)){
	        $this->error('表单已过期，请重新提交',$jump);
	    }
	    
	    $where = array('id'=>$id);
	   
	    $User->where($where)->delete();
	   
	    redirect($jump);
	}
}
