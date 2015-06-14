<?php

// 学生模块

class IndexAction extends Action {
    
    public function _initialize(){
        cookie('sid',1);

    }

    public function index(){
        if($_POST['fid']==0){
            $sid = $_COOKIE['sid'];
            var_dump($sid);
            $classlist = D('Student_course')->where('student_id='.$sid)->select();
            var_dump($classlist);
            $data = array();
            foreach ($classlist as $key => $value) {
                $fid = D('Resdir')->where('cid='.$value['course_class_id'])->select();
                var_dump($fid);
                $data[$key]['id'] = $fid[0]['id'];
                $data[$key]['name'] = $fid[0]['name'];
                $data[$key]['is_folder'] = true;
            }
            var_dump($data);
        }else{
            $data = D('Resdir')->dir_get($_POST['fid']);
            var_dump($data);
        }
        $ans = json_encode($data);
        echo $ans;
    }

    public function uploadfile(){
        $fid = (int)$_POST['fid'];
        var_dump($_POST);
        $rid = D('Resource')->file_upload($fid);
        $data = D('Resdir')->dir_get($fid);
        var_dump($data);
        $ans = json_encode($data);
        echo $ans;
    }

    
    public function downloadfile(){
        //通过POST传数据
        $rid = $_POST['rid'];
        echo ('downloadfile');
        $ok  = D('Resource')->file_download($rid);
    }
	
    public function handinfile(){
        //通过cookie传数据
        $fid = (int)$_POST['fid'];
        $sid = (int)$_POST['sid'];
        var_dump($_POST);
        $rid = D('Homework')->file_upload($fid,$sid);
    }
    

    //新建资源作业文件夹
    public function newdir(){
    	//通过POST传数据
        $fid = (int)$_POST['fid'];
        $name = $_POST['name'];
        $res = D('Resdir');
        $res->resdir_add($fid,$name);
        $data = D('Resdir')->dir_get($fid);
        var_dump($data);
        $ans = json_encode($data);
        echo $ans;
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


    //test add info
    public function test(){
        $sid = $_POST['id'];
        $sid = $sid+1000;
        $ans = json_encode($sid);
        echo $ans;
    }

    public function addclass(){
        $cid = (int)$_POST['cid'];
        var_dump($cid);
        $dir = D('Resdir');
        $ok = $dir->classdir_add($cid);
        echo $ok;
        // $sid = $sid+1000;
        // $ans = json_encode($sid);
        // echo $ans;
    }
}