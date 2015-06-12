<?php

// 本类由系统自动生成，仅供测试用途

class IndexAction extends Action {
    
    public function index(){
		//$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    	
    	$this->display();
    }

    public function new_file(){
    	echo ('new_file');
    	$this->display();
    }
    
	// 文件上传 （乱码问题）
	
    

    //新建资源作业文件夹
    public function test(){
    	//$did = $this->resdir_add(31,"t1","asa");
        $ls = D('Resdir');
        $res = D('Resource');
        $hw = D('Homework');
        //$hwdir = $ls->dir_delete(35);
        //$hwdir = $ls->homework_add(24,'作业1','test',234);
        $hw->file_change(2,'3.txt');
        //var_dump($hwdir);
    	//$this->dir_get(23);
    }
    
    //全文搜索 (index定期更新，json)
    public function search(){
    	$query = "include";
    	require("sphinxapi.php");
		$cl = new SphinxClient ();
		$cl->SetServer ( '127.0.0.1', 9312);
		$cl->SetConnectTimeout ( 3 );
		$cl->SetArrayResult ( true );
		$cl->SetMatchMode ( SPH_MATCH_ANY);
		$res = $cl->Query ( $query, "res_index" );
		// print_r($cl);
		var_dump($res);
    }

    public function uploadfile(){
    	echo ('uploadfile');
    	var_dump($_POST);
    	$this->hello("hi");
        $ls = D('Resdir');
        $res = D('Resource');
        $hw = D('Homework');
    	$rid  = $res->file_upload(36,3);
    }

    public function downloadfile(){
    	echo ('downloadfile');
    	$this->hello("hi");
        $ls = D('Resdir');
        $res = D('Resource');
        $hw = D('Homework');
    	$rid  = $hw->file_download(1);
    }
}