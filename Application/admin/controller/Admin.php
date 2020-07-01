<?php
namespace app\admin\controller;
use app\admin\model\Admin as AdminModel;
use think\Db;
use app\admin\controller\Base;
class Admin extends  Base
{

	// 列表页输出
  public function lst()
    {     
    	// 输出数组信息
          $list = AdminModel::paginate(5);
     $this->assign('list',$list);

        return $this->fetch();
    }
    // 管理员添加
   public function add()
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
    		return $this->success('添加成功','lst');
    	}
    	else{
    		return  $this->error('添加失败');
    	}
    	return;
    }
        return $this->fetch('');

    }
     //管理员修改 
    public function edit(){
    		$id=input('id');
    	$admins=db('admin')->find($id);
    	if(request()->isPost()){
    		$data=[
           'id'=>input('id'),
           'username'=>input('username'),   	
     
    		];
    		// 判断密码为空
		    if(input('password')){
		 	  $data['password']=md5(input('password'));
		 }
		 else{
		       	  $data['password']=$admins['password'];
		 }
			$validate = \think\ Loader::validate('Admin');
			// 显示错误信息
			if(!$validate->scene('edit')->check($data)) {
			$this->error($validate->getError());
			die;
			}
            $save=db('admin')->update($data);
    		
            if($save!== false){
    			$this->success('修改成功！','lst');
    		}
    		else{
    			$this->error('修改失败！');
    		}
    		return;
    	}
    
    	$this->assign('admins',$admins);  	
        return $this->fetch('');

    }
       // 删除操作
    public function del(){
    	$id=input('id');
    	if($id != 1){
    		if(db('admin')->delete(input('id'))){
    			$this->success('删除管理员成功！','lst');
    		}else{
    			$this->error('删除管理员失败！');
    		}
    	}else{
    		$this->error('初始化管理员不能删除！');
    	}
    	
    }
        public function logout(){
        session(null);
        $this->success('退出成功！','Login/index');
    }
}