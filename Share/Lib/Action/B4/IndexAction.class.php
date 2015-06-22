<?php

// 学生模块

class IndexAction extends Action {
    
    public function _initialize(){
        cookie('sid',1);

    }

    public function index(){
        $this->display();
    }

    public function userinfo(){
        $data = array(
                'userName' =>"xin" ,
                'userType' =>1
            );
        $ans = json_encode($data);
        echo $ans;
    }

    public function indexinfo(){
        if($_POST['fid']==0){
            $sid = $_COOKIE['sid'];
            //var_dump($sid);
            $classlist = D('Student_course')->where('student_id='.$sid)->select();
            //var_dump($classlist);
            $data = array();
            foreach ($classlist as $key => $value) {
                $fid = D('Resdir')->where('cid='.$value['course_class_id'])->select();
                //var_dump($fid);
                $data[$key]['id'] = $fid[0]['id'];
                $data[$key]['name'] = $fid[0]['name'];
                $data[$key]['is_folder'] = true;
                $data[$key]['author_name'] = "admin";
                $data[$key]['duetime'] = $fid[0]['addtime'];
            }
            //var_dump($data);
        }else{
            $data = D('Resdir')->dir_get($_POST['fid']);
            //var_dump($data);
        }
        $ans = json_encode($data);
        echo $ans;
    }

    public function homeworkinfo(){
        if($_POST['fid']==0){
            $sid = $_COOKIE['sid'];
            //var_dump($sid);
            $classlist = D('Student_course')->where('student_id='.$sid)->select();
            //var_dump($classlist);
            $data = array();
            foreach ($classlist as $key => $value) {
                $fid = D('Resdir')->where('cid='.$value['course_class_id'])->select();
                //var_dump($fid);
                $data[$key]['id'] = $fid[0]['id'];
                $data[$key]['name'] = $fid[0]['name'];
                $data[$key]['is_folder'] = true;
                $data[$key]['author_name'] = "admin";
                $data[$key]['duetime'] = $fid[0]['addtime'];
            }
            //var_dump($data);
        }else{
            $info = D('Resdir')->where("fid=".$_POST['fid'])->select();
            $kk=0;
            foreach ($info as $key => $value) {
                    if ($value['homework']==1){
                        $data[$kk]['id'] = $value['id'];
                        $data[$kk]['name'] = $value['name'];
                        $data[$kk]['is_folder'] = true; 
                        $data[$kk]['duetime'] = $value['ddl'];   
                        $data[$kk]['author_name'] = "xin";
                        $kk=$kk+1;    
                    }            # code...
                }     
            $info = D('Homework')->where("fid=".$_POST['fid'])->select();
            foreach ($info as $key => $value) {
                        $data[$kk]['id'] = $value['id'];
                        $data[$kk]['name'] = $value['name'];
                        $data[$kk]['is_folder'] = false; 
                        $data[$kk]['duetime'] = $value['addtime'];   
                        $data[$kk]['author_name'] = "xin";
                        $kk=$kk+1;     # code...
                }    
            //var_dump($data);
        }
        $ans = json_encode($data);
        echo $ans;
    }

    public function uploadfile(){

        $fid = (int)$_POST['fid'];
        $rid = D('Resource')->file_upload($fid);

        // $data = D('Resdir')->dir_get($fid);
        // $ans = json_encode($data);
        // echo $ans;
        //$this->success();
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
        //var_dump($data);
        $ans = json_encode($data);
        echo $ans;
    }
    
    //全文搜索 (index定期更新，json)
    public function search(){
    	//$query = //$_POST['query'];
        $query =iconv("UTF-8", "GB2312",$_POST['query']);
        //var_dump($_POST['query']);
        $s = $query;
        //var_dump($_POST['query']);
        $q = 'http://localhost:8983/solr/xin/browse?&q='.$_POST['query'].'&wt=php';
        //echo $q;
        $code = file_get_contents($q);
        //var_dump($code);
        eval('$result='.$code.';');
        foreach ($result['response']['docs'] as $key => $value) {
            $rs = D('Resource')->where('id='.$value['id'])->select();
            $data[$key]['id'] = $rs[0]['id'];
            $data[$key]['name'] = $rs[0]['name'];
            $data[$key]['is_folder'] = false;
            $data[$key]['author_name'] = $rs[0]['uploader'];
            $data[$key]['duetime'] = $rs[0]['addtime'];
        }
        $ans = json_encode($data);
        echo $ans;
    }


    //test add info
    public function test(){
       system("java -Dc=xin -Dauto -jar solr/post.jar g:/lab5_3120000271_辛浩.pdf");
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