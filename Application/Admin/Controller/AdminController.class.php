<?php
namespace Admin\Controller;
//前台会员控制器
class AdminController extends CommonController{
	public function index(){
		//取出会员信息
		$data = D('Admin')->getList();
		$data['priv'] = session('userinfo.priv');
		$data['id'] = session('userinfo.id');
		$this->assign($data);
		$this->display();
	}
	//添加管理员
	public function add(){
	    //实例化模型
	    $Category = D('Admin');
	    if(IS_POST){
	         
	        if(!$Category->create(null,1)){
	            $this->error('添加失败：'.$Category->getError());
	        }
	         
	        if(!$Category->add()){
	            $this->error('添加失败：保存到数据库失败。');
	        }
	         
	        if(isset($_POST['return'])) $this->redirect('Admin/index');
	        $this->assign('success',true);
	    }
	    
	    $this->display();
	}
	//修改管理员密码
	public function edit(){
	    
		$id = I('get.id/d',0);  //待修改的ID，“/d”用于转换为整型
		 
		if($id != session('userinfo.id') && session('userinfo.id') != 1){
		    $this->error('非法操作,不能修改别人的密码！');
		}
		
		//实例化模型
		$Admin = D('Admin');
		if(IS_POST){
			
			 
			if(!$Admin->create(null,2)){
				$this->error('修改失败：'.$Admin->getError());
			}
			 
			if(false === $Admin->where(array('id'=>$id))->save()){
				$this->error('修改失败：保存到数据库失败。');
			}
			 
			$this->redirect('Admin/index');
		}
		$data['id'] = $id;
		$this->assign($data);
		$this->display();
	}
	//删除管理员
	public function del(){
	    
	    if(!IS_POST) $this->error('删除失败！');
	     
	    $id = I('post.id/d',0);  //ID
	    
	    $jump = U('Admin/index');
	    
	    $Admin = D('Admin');
	     
	    if(!$Admin->autoCheckToken($_POST)){
	        $this->error('表单已过期，请重新提交',$jump);
	    }
	     
	    $where = array('id'=>$id);
	     
	    $Admin->where($where)->delete();
	     
	    redirect($jump);
	}
}
