<?php

// 学生模块

class IndexAction extends Action {
    
    public function _initialize(){

    }

    public function index(){
        if(!$_POST['fid']){
            $teacher_id = 1;
            $dirlist = D('Resdir');
            $fids = D('Course_class')->where('teacher_id='.$teacher_id)->->field('fid')->select();
            foreach ($fids as $key => $value) {
                $dirinfo = $dirlist->dir_get($value['fid']);
                var_dump($dirinfo);
            }
        }else{
            $dirinfo = $dirlist->dir_get($_POST['fid']);
            var_dump($dirinfo);
            cookie('fid',$_POST['fid']);
        }
        $this->display();
    }

    public function delhomework(){
        $res = D('Resdir');
    }
    public function newhomework(){
        //通过POST传数据
        $res = D('Resdir');
    }

    //下面调用admin模块
    public function delres(){
        $res = D('Resdir');
    }
    public function deldir(){
        $res = D('Resdir');
    }

    //下面调用index模块
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
    //新建资源作业文件夹
    public function newdir(){
        //通过POST传数据
        $res = D('Resource');
        $res->file_change(2,'3.txt');
    }

    public function uploadfile(){
        //通过cookie传数据fid
        echo ('uploadfile');
        var_dump($_POST);
        $this->hello("hi");
        $rid  = $res->file_upload($_COOKIE['fid']);
    }

    public function downloadfile(){
        //通过POST传数据
        echo ('downloadfile');
        $res = D('Resource');
        $rid  = $res->file_download($_POST['rid']);
    }
}