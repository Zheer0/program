<?php
namespace app\admin\controller;
use app\admin\model\Cate as CateModel;
use app\admin\controller\Base;

use think\Db;
class Cate extends Base
{
	// 列表页输出
  public function lst()
    {     
    	// 输出数组信息
          $list = CateModel::paginate(5);
     $this->assign('list',$list);

        return $this->fetch();
    }
    // 管理员添加
   public function add()
    {     
      //获取提交的信息
    	if(request()->isPost()){ 
        
    		$data=[
    			'catename'=>input('catename') ,              
    		
    		];   
             // 验证提交的信息
			$validate = \think\ Loader::validate('Cate');
			// 显示错误信息
			if(!$validate->scene('add')->check($data)) {
			$this->error($validate->getError());
			die;
			}
   // 添加到数据库
		if(Db::name('cate')->insert($data)){
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
    	$cate=db('cate')->find($id);
    	if(request()->isPost()){
    		$data=[
           'id'=>input('id'),
           'catename'=>input('catename'),   	
     
    		];
    		// 判断密码为空
		 //    if(input('password')){
		 // 	  $data['password']=md5(input('password'));
		 // }
		 // else{
		 //       	  $data['password']=$admins['password'];
		 // }
			$validate = \think\ Loader::validate('Cate');
			// 显示错误信息
			if(!$validate->scene('edit')->check($data)) {
			$this->error($validate->getError());
			die;
			}

    		if(db('cate')->update($data)){
    			$this->success('修改成功！','lst');
    		}
    		else{
    			$this->error('修改失败！');
    		}
    		return;
    	}
    
    	$this->assign('cate',$cate);  	
        return $this->fetch('');

    }
       // 删除操作
    public function del(){
    	$id=input('id');
    	if($id ){
    		if(db('cate')->delete(input('id'))){
    			$this->success('删除栏目成功！','lst');
    		}else{
    			$this->error('删除栏目失败！');
    		}
    	}
    	
    }
}