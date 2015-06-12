<?php
/****************************************************
 *         Author: Xin Hao - xinhao20082009@163.com
 *  Last modified: 2015-05-24 18:38
 *       Filename: ResdirModel.class.php
 *    Description: 文件资源共享文件夹
 *****************************************************/

class ResdirModel extends Model {
		
	// 定义自动验证
    protected $_validate    =   array(
        array('name','require','标题必须'),
        );
    // 定义自动完成
    protected $_auto    =   array(
        array('addtime','time',1,'function'),
        );

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
	//为课程增加根目录，输入课程名，输出目录id
    public function coursedir_add($cname){
    	$dir = "./Upload/".$cname;
    	$ok = $this->dir_add($dir);
    	if ($ok) {
    		$d = D('Resdir');
    		$data = array(
	    		'name' 			=>	$cname ,
	    		'fid' 			=>	0,
	    		'url'			=>	$dir
	    	 );
    		$id = $d->data($data)->add($data);
    		return $id;
    	}
    	else {
    		echo "已存在";
    	}
    }
    //第二组
    //为班级增加根目录，输入课程，教师名称，课程id，输出目录id
    public function classdir_add($fid,$tname,$cid){
		$d0 = D('Resdir');
		$fdir = $d0->where("id=".$fid)->select();	
    	$fid = $fdir[0]['id'];
    	$fpath = $fdir[0]['url'];
    	$newdir = $fpath.'/'.$tname;
    	var_dump($newdir);
    	$ok = $this->dir_add($newdir);
    	if ($ok) {
    		$d = D('Resdir');
    		$data = array(
	    		'name' 			=>	$tname,
	    		'fid' 			=>	$fid,
	    		'cid'			=>	$cid,
	    		'url'			=>	$newdir
	    	 );
    		var_dump($data);
    		$id = $d->data($data)->add($data);
    		return $id;
    	}
    	else {
    		echo "已存在";
    	}
    }
    //在一个目录中增加目录，输入当前目录id，新的目录名[,描述]，输出目录id
    public function resdir_add($fid,$dname,$descrip,$uploader){
		$d = D('Resdir');
		$fdir = $d->where("id=".$fid)->select();
    	$fpath = $fdir[0]['url'];
    	$cid = $fdir[0]['cid'];
    	$newdir = $fpath.'/'.$dname;
    	$ok = $this->dir_add($newdir);
    	if ($ok) {
    		$data = array(
	    		'name' 			=>	$dname,
	    		'fid' 			=>	$fid,
	    		'cid'			=>	$cid,
	    		'url'			=>	$newdir,
	    		'descrip'		=>	$descrip
	    	 );
            if ($uploader) $data['uploader'] = $uploader;
            var_dump($data);
    		$id = $d->data($data)->add($data);
    		return $id;
    	}
    	else {
    		echo "已存在";
    	}
    }
    
    public function homework_add($fid,$dname,$descrip,$ddl){
        $ok = $this->resdir_add($fid,$dname,$descrip);
        var_dump($ok);
        if ($ok){
            $data = array(
                'ddl'       =>  $ddl,
                'homework'  =>  true
             );
            $d = D('Resdir')->where('id='.$ok)->save($data);
            return $ok;
        }
    }


    //删除目录，输入id，输出是否成功
    public function dir_delete($fid){
    	$d0 = D('Resdir');
    	$fdir = $d0->where("id=".$fid)->select();
    	var_dump($fdir);
    	$dir = $fdir[0]['url'];
	  	$deldir = iconv("UTF-8", "GB2312", $dir); //code transe
        var_dump($deldir);
    	$ok = $this->dir_del($deldir);
    	if ($ok){
    		$dellist = array();
    		$dellist[] = $fid;
    		$r = 1;
    		$l = 0;
    		while ($l<$r){
    			$value = $dellist[$l];
    			var_dump($value);
    			$fdir = $d0->where("fid=".$value)->field('id')->select();
    			foreach ($fdir as $key => $val) {
    				$dellist[] = (int)$val['id'];
    				$r = $r+1;
    			}
    			$l = $l+1;
    			$d0->where("id=".$value)->delete();
    			var_dump($dellist);
    		}
    	}
    }
    //显示目录，输入id，输出相关信息
    public function dir_get($fid){
    	$data = $this->where("fid=".$fid)->field('id,name,uploader,addtime')->select();
    	var_dump($data);
    	return $data;
    }
}
