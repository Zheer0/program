<?php
namespace app\admin\controller;
use app\admin\model\Article as ArticleModel;
use app\admin\controller\Base;

use think\Db;
class Article extends  Base
{
	// 列表页输出
  public function lst()
    {     
    	// 输出数组信息
        
          // tp5关联数据表
        // $list=db('article')->alias('a')->join('cate c','c.id=a.cateid')->field('a.id,a.title,a.author,a.pic,a.time,a.keywords,a.cateid,a.state,c.catename')->paginate(5);
          $list = ArticleModel::paginate(5); 
           $this->assign('list',$list);

        return $this->fetch();
    }
    // 管理员添加
   public function add()
    {     
      //获取提交的信息
    	if(request()->isPost()){ 
        // dump($_POST);die;
    		$data=[
    			'title'=>input('title') ,              
    			'author'=>input('author'),
                'desc'=>input('desc'),
                'keywords'=>str_replace('，',',',input('keywords')),
                'cateid'=>input('cateid'),
                'content'=>input('content'),
                'time'=>time(),
                'state'=>input('state'),
                'pic'=>input('pic'),
                'photo'=>input('photo[]'),
    		];
            if(input('state')=='on'){
                $data['state']=1;
            }
            // 图片上传
            if($_FILES['pic']['tmp_name']){
                $file=request()->file('pic');
                $info = $file->move(ROOT_PATH .'public' . DS . 'static/uploads');
                $data['pic']='/static/uploads/'.$info->getSaveName();
            }  
              // 图片上传
           $files = request()->file('photo');  
           $date=date("Y-m-d",time());//已上传日期为子目录名
         $saveName=time().rand(1111,9999);
        foreach($files as $file){
            // 移动到框架应用根目录/public/uploads/ 目录下
         
            $info = $file->move(ROOT_PATH . 'public' . DS . 'static/uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 jpg
                echo $info->getExtension();
                  $data['photo']='/static/uploads/'.$date."/".$saveName;
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getFilename();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
             
        }
             // 验证提交的信息
			$validate = \think\ Loader::validate('Article');
			// 显示错误信息
			if(!$validate->scene('add')->check($data)) {
			$this->error($validate->getError());
			die;
			}
   // 添加到数据库
		if(Db::name('Article')->insert($data)){
    		return $this->success('添加成功','lst');
    	}
    	else{
    		return  $this->error('添加失败');
    	}
    	return;
    }
    $cateres=db('cate')->select();
    $this->assign('cateres',$cateres);
        return $this->fetch('');

    }
     //管理员修改 
    public function edit(){
            $id=input('id');
        $article=db('article')->find($id);
        if(request()->isPost()){
            $data=[
                'id'=>input('id'), 
                'title'=>input('title'),       
                'author'=>input('author'), 
                'desc'=>input('desc'),
                'keywords'=>str_replace('，', ',', input('keywords')),
                'content'=>input('content'),
                'cateid'=>input('cateid'),
            ];
              if(input('state')=='on'){
                $data['state']=1;
            }else{
                $data['state']=0;
            }

            if($_FILES['pic']['tmp_name']){
                $file = request()->file('pic');
                $info = $file->move(ROOT_PATH . 'public' . DS . 'static/uploads');
                $data['pic']='/static/uploads/'.$info->getSaveName();
            }
            $validate = \think\Loader::validate('article');
            if(!$validate->scene('edit')->check($data)){
               $this->error($validate->getError()); die;
            }
            if(db('article')->update($data)){
                $this->success('修改文章成功！','lst');
            }else{
                $this->error('修改文章失败！');
            }
            return;
        }
        $this->assign('article',$article);
        $cateres=db('cate')->select();
        $this->assign('cateres',$cateres);
        return $this->fetch();
    }

       // 删除操作
    public function del(){
    	$id=input('id');
    	if($id){
    		if(db('article')->delete(input('id'))){
    			$this->success('删除文章成功！','lst');
    		}else{
    			$this->error('删除文章失败！');
    		}
    	}
    	
    }
    
    //商品图片上传
    public function product_add_images(){
        

        $upload = new  \org\Upload();// 实例化上传类    
        $upload->maxSize   =     3145728 ;// 设置附件上传大小    
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型    
        $upload->rootPath  =      './static/files/'; // 设置附件上传目录    // 上传文件
        $upload->saveName=time().rand(1111,9999);
        $date=date("Y-m-d",time());//已上传日期为子目录名
        $upload->saveExt="png";//上传的文件后缀
          $info   =   $upload->upload();   
          if(!$info) {// 上传错误提示错误信息  

              $this->error($upload->getError());  

           }else{// 上传成功 
            
            $m=M('goods_files');
            $data['filepath']='/static/files/'.$date."/".$upload->saveName.".".$upload->saveExt;
            $result=$m->add($data);
            $file=['id'=>$result,'imagepath'=>$data['filepath']];
            echo json_encode($file);

           }
    }

    //商品图片删除
    public function product_del_images(){
        $m=M('goods_files');
        $result=$m->delete($_GET['id']);
        if($result){
            echo 1;
        }else{
            echo 0;
        }
    }
}