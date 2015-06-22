<?php
/****************************************************
 *         Author: Xin Hao - xinhao20082009@163.com
 *  Last modified: 2015-05-24 18:38
 *       Filename: ResdirModel.class.php
 *    Description: 文件资源共享文件夹
 *****************************************************/
// id
// fid
// cid
// Description
// name
// url
// homework
// ddl
// uploader
// addtime

class ResdirModel extends Model {
		

    //本地增加目录，输入目录名，输出是否成功
    protected function dir_add($dir){
    	$newdir = iconv("UTF-8", "GB2312", $dir); //code transe
    	$ok = mkdir($newdir);
    	return $ok;
	}
	//本地删除目录，输入目录名，输出是否成功
	protected function dir_del($dir){
	  	$dh=opendir($dir);
	  	while ($file=readdir($dh)) {
	    	if($file!="." && $file!="..") {
		      	$fullpath=$dir."/".$file;
		      	if(is_dir($fullpath)) {
	                $this->dir_del($fullpath);
	            }else{
	                unlink($fullpath);
		      	}
	    	}
  		}
  		closedir($dh);
  		if(rmdir($dir)) {
			return true;
		} else {
		    return false;
		}
  	}
	
    //第一组
    //为班级增加根目录，输入课程id，输出目录id
    public function classdir_add($cid){
		$dir = "./Upload/".$cid;
        $ok = $this->dir_add($dir);
        if ($ok) {
            $courseid = D('Course_class')->where('id='.$cid)->select();
            $cname = D('Course')->where('id=1'.$courseid[0]['course_id'])->select(); 
            $d = D('Resdir');
            $data = array(
                'name'          =>  $cname[0]['name'] ,
                'fid'           =>  0,
                'url'           =>  $dir,
                'cid'           =>  $cid
             );
            $id = $d->data($data)->add($data);
            return $id;
        }
        else {
            echo "已存在";
        }
    }
    //在一个目录中增加目录，输入当前目录id，新的目录名[,描述]，输出目录id
    public function resdir_add($fid,$dname,$uname="xin"){
		$d = D('Resdir');
		$fdir = $d->where("id=".$fid)->select();
    	$fpath = $fdir[0]['url'];
    	$newdir = $fpath.'/'.$dname;
    	$ok = $this->dir_add($newdir);
    	if ($ok) {
    		$data = array(
	    		'name' 			=>	$dname,
	    		'fid' 			=>	$fid,
	    		'url'			=>	$newdir,
                'uploader'      =>  $uname,
	    	 );
            //var_dump($data);
    		$id = $d->data($data)->add($data);
    		return $id;
    	}
    	else {
    		echo "失败";
    	}
    }
    
    public function homework_add($fid,$dname,$descrip="",$ddl=""){
        $ok = $this->resdir_add($fid,$dname);
        var_dump($ok);
        if ($ok){
            $data = array(
                'ddl'       =>  $ddl,
                'homework'  =>  1,
                'descrip'   =>  $descrip
             );
            $d = D('Resdir')->where('id='.$ok)->save($data);
            return $ok;
        }
    }


    //删除目录，输入id，输出是否成功
    public function dir_delete($fid){
    	$d0 = D('Resdir');
    	$fdir = $d0->where("id=".$fid)->select();
    	//var_dump($fdir);
    	$dir = $fdir[0]['url'];
	  	$deldir = iconv("UTF-8", "GB2312", $dir); //code transe
        //var_dump($deldir);
    	$ok = $this->dir_del($deldir);
    	if ($ok){
    		$dellist = array();
    		$dellist[] = $fid;
    		$r = 1;
    		$l = 0;
    		while ($l<$r){
    			$value = $dellist[$l];
    			//var_dump($value);
    			$fdir = $d0->where("fid=".$value)->field('id')->select();
    			foreach ($fdir as $key => $val) {
    				$dellist[] = (int)$val['id'];
    				$r = $r+1;
    			}
    			$l = $l+1;
    			$d0->where("id=".$value)->delete();
                D('Resource')->where("fid=".$value)->delete();
    			//var_dump($dellist);
    		}
    	}
    }
    //显示目录，输入id，输出相关信息
    public function dir_get($fid){
        $data = array();
        $hw = D('Resdir')->where("id=".$fid)->select();
        if ($hw[0]['homework']==1){
            $data1 = D('Homework')->where("fid=".$fid)->select();
            foreach ($data1 as $key => $value) {
                $data[$key]['id'] = $value['id'];
                $data[$key]['name'] = $value['name'];
                $data[$key]['is_folder'] = false;
                $data[$key]['author_name'] = $value['uploader'];
                $data[$key]['duetime'] = $value['addtime'];
            }
        }else{
            $data1 = D('Resdir')->where("fid=".$fid)->select();
            foreach ($data1 as $key => $value) {
                $data[$key]['id'] = $value['id'];
                $data[$key]['name'] = $value['name'];
                $data[$key]['is_folder'] = true;
                $data[$key]['author_name'] = $value['uploader'];
                $data[$key]['duetime'] = $value['addtime'];
            }
            $k = count($data1);
            //var_dump($k);
            $data2 = D('Resource')->where("fid=".$fid)->select();
            foreach ($data2 as $key => $value) {
                $data[$key+$k]['id'] = $value['id'];
                $data[$key+$k]['name'] = $value['name'];
                $data[$key+$k]['is_folder'] = false;
                $data[$key]['author_name'] = "admin";
                $data[$key]['duetime'] = $value['addtime'];
                $data[$key]['downloads'] = $value['hits'];
            }
            //var_dump($data);
        }
    	return $data;
    }
}
