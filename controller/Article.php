<?php
namespace app\index\controller;
use app\index\controller\Base;

class Article extends  Base
{
    public function index()
    {
    	$arid=input('arid');
    	$articles=db('article')->find($arid);
    	db('article')->where('id','=',$arid)->setInc('click');
    	$cates=db('cate')->find($articles['cateid']);
    	$recres=db('article')->where(array('cateid'=>$cates['id'],'state'=>1))->limit(8)->select();
    	$this->assign(array(
          'articles'=>$articles,
          'cates'=>$cates,
          'recres'=>$recres,
    	));
        return $this->fetch('article');

    }  
}
