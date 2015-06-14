<?php

// 学生模块

class IndexAction extends Action {
    
    public function _initialize(){
        cookie('sid',1);

    }

    public function index(){
        if(!$_POST['fid']){
            $sid = $_COOKIE['sid'];
            $dirlist = D('Resdir');
            $classlist = D('Student_course')->where('student_id='.$sid)->field('course_class_id')->select();
            foreach ($classlist as $key => $value) {
                var_dump($value['course_class_id']);
                $fids = D('Course_class')->where('id='.$value['course_class_id'])->field('fid')->select();
                foreach ($fids as $key => $value) {
                    var_dump($value['fid']);
                    $dirinfo = $dirlist->dir_get($value['fid']);
                    var_dump($dirinfo);
                }
            }
        }else{
            $dirinfo = $dirlist->dir_get($_POST['fid']);
            var_dump($dirinfo);
            cookie('fid',$_POST['fid']);
        }
        $this->display();
    }


    public function changefname(){

    }

    public function uploadfile(){
        //通过cookie传数据
        echo ('uploadfile');
        var_dump($_POST);
        $rid  = $res->file_upload($_COOKIE['fid']);
    }

    public function handinfile(){
        //通过cookie传数据
        echo ('uploadfile');
        var_dump($_POST);
        $rid  = $hw->file_upload($_COOKIE['fid'],$_COOKIE['sid']);
    }

    public function downloadfile(){
        //通过POST传数据
        echo ('downloadfile');
        $res = D('Resource');
        $rid  = $res->file_download($_POST['rid']);
    }
	
    

    //新建资源作业文件夹
    public function newdir(){
    	//通过POST传数据
        $res = D('Resource');
        $res->file_change(2,'3.txt');
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
    public function test(){
        $sid = $_POST['id'];
        $sid = $sid+1000;
        $ans = json_encode($sid);
        echo $ans;
    }
}