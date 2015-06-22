<?php

// 管理员模块

class AdminAction extends Action {
    
    public function indexinfo(){
    	$data = array();
        if($_POST['fid']==0){
            $data = D('Resdir')->dir_get($_POST['fid']);
            //var_dump($data);
        }else{
            $data = D('Resdir')->dir_get($_POST['fid']);
            //var_dump($data);
        }
        $ans = json_encode($data);
        echo $ans;
        //$this->display();
    }

    public function homeworkinfo(){
        $data = array();
        if($_POST['fid']==0){
            $data = D('Resdir')->dir_get($_POST['fid']);
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
            //var_dump($data);
        }
        $ans = json_encode($data);
        echo $ans;
        //$this->display();
    }

    public function deldir(){
        $dir = D('Resdir');
        $ok = $dir->dir_delete($_POST['id']);

    }

    public function delfile(){
        $res = D('Resource');
        //var_dump($_POST);
        $ok = $res->file_del($_POST['id']);
    }

    public function move(){
        $dragid = $_POST['dragid'];
        $targetid = $_POST['targetid'];
    }
  	


    //下面调用index模块
    //全文搜索 (index定期更新，json)
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