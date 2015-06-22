<?php

// 学生模块

class TeacherAction extends Action {
    
    public function _initialize(){
        cookie('tid',1);
    }

    public function indexinfo(){
        $data = array();
        if($_POST['fid']==0){
            $teacher_id = $_COOKIE['tid'];
            //var_dump($teacher_id);
            $classlist = D('Course_class')->where('teacher_id='.$teacher_id)->select();
            //var_dump($classlist);
            $data = array();
            foreach ($classlist as $key => $value) {
                $fid = D('Resdir')->where('cid='.$value['id'])->select();
                if ($fid) {
                    $data[$key]['id'] = $fid[0]['id'];
                    $data[$key]['name'] = $fid[0]['name'];
                    $data[$key]['is_folder'] = true;
                    $data[$key]['author_name'] = "admin";
                    $data[$key]['duetime'] = $fid[0]['addtime'];    
                }
            }
            //var_dump($data);
        }else{
            $data = D('Resdir')->dir_get($_POST['fid']);          
        }
        $ans = json_encode($data);
        echo $ans;
        //$this->display();
    }

    public function homeworkinfo(){
        $data = array();
        if($_POST['fid']==0){
            $teacher_id = $_COOKIE['tid'];
            //var_dump($teacher_id);
            $classlist = D('Course_class')->where('teacher_id='.$teacher_id)->select();
            //var_dump($classlist);
            $data = array();
            foreach ($classlist as $key => $value) {
                $fid = D('Resdir')->where('cid='.$value['id'])->select();
                if ($fid) {
                    $data[$key]['id'] = $fid[0]['id'];
                    $data[$key]['name'] = $fid[0]['name'];
                    $data[$key]['is_folder'] = true;    
                }
            }
            //var_dump($data);
        }else{
            $info = D('Resdir')->where("id=".$_POST['fid'])->select();
            foreach ($info as $key => $value) {
                    if ($value['homework']==1){
                        $data[$key]['id'] = $info[0]['id'];
                        $data[$key]['name'] = $info[0]['name'];
                        $data[$key]['is_folder'] = false;       
                    }            # code...
                }            
        }
        $ans = json_encode($data);
        echo $ans;
        //$this->display();
    }

    public function delhomework(){
        $res = D('Homework')->file_del($_POST['hid']);
        echo $res;
    }
    public function newhomework(){
        //通过POST传数据
        $fid = (int)$_POST['fid'];
        $name = $_POST['name'];
        $descrip = $_POST['descrip'];
        $ddl = $_POST['ddl'];
        $id = D('Resdir')->homework_add($fid,$name,$descrip,$ddl);
        echo "1";
    }

    // //下面调用admin模块
    // public function delres(){
    //     $res = D('Resdir');
    // }
    
    // public function deldir(){
    //     $res = D('Resdir');
    // }

    // //下面调用index模块
    // //全文搜索 (index定期更新，json)
    // public function search(){
    //     $query = "include";
    //     require("sphinxapi.php");
    //     $cl = new SphinxClient ();
    //     $cl->SetServer ( '127.0.0.1', 9312);
    //     $cl->SetConnectTimeout ( 3 );
    //     $cl->SetArrayResult ( true );
    //     $cl->SetMatchMode ( SPH_MATCH_ANY);
    //     $res = $cl->Query ( $query, "res_index" );
    //     // print_r($cl);
    //     var_dump($res);
    // }
    // //新建资源作业文件夹
    // public function newdir(){
    //     //通过POST传数据
    //     $res = D('Resource');
    //     $res->file_change(2,'3.txt');
    // }

    // public function uploadfile(){
    //     //通过cookie传数据fid
    //     echo ('uploadfile');
    //     var_dump($_POST);
    //     $this->hello("hi");
    //     $rid  = $res->file_upload($_COOKIE['fid']);
    // }

    // public function downloadfile(){
    //     //通过POST传数据
    //     echo ('downloadfile');
    //     $res = D('Resource');
    //     $rid  = $res->file_download($_POST['rid']);
    // }
}