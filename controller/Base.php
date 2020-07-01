<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Base  extends  Controller
{
    public function _initialize()
    {
    $this->right();
    	$cateres=db('cate')->order('id asc')->select();
    	$this->assign('cateres',$cateres);
        

    }  
    public function right(){
    	$clicks=db('article')->order('click desc')->limit(5)->select();
    	$tjres=db('article')->where('state','=',1)->order('click desc')->limit(5)->select();
    	$this ->assign(array(
           'clicks'=>$clicks,
           'tjres'=>$tjres
    	));	
    	
    }
}
