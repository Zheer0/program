<?php
namespace Admin\Controller;
//后台首页
class IndexController extends CommonController{

	//后台首页，显示服务器基本信息
	public function index(){
		$serverInfo = array(
			 
			'server_version' => $_SERVER['SERVER_SOFTWARE'],
			 
			'mysql_version' => $this->getMySQLVer(),
			 
			'server_time' => date('Y-m-d H:i:s', time()),
			 
			'max_upload' => ini_get('file_uploads') ? ini_get('upload_max_filesize') : '已禁用', 
			 
            'max_ex_time' => ini_get('max_execution_time').'秒', 
		);
		 
		$data['priv'] = session('userinfo.priv');
		$this->assign($data);
		$this->assign('serverInfo',$serverInfo);
		$this->display();
	}
	
	 
	private function getMySQLVer(){
		$rst = M()->query('select version() as ver');
		return isset($rst[0]['ver']) ? $rst[0]['ver'] : '未知';
	}
}
