<?php
/****************************************************
 *         Author: Xin Hao - xinhao20082009@163.com
 *  Last modified: 2015-06-6 18:38
 *       Filename: HomeworkModel.class.php
 *    Description: 作业上传
 *****************************************************/

class HomeworkModel extends Model {
	
	
	/**
	 * 添加资源库
	 * 
	 * @param $name 资源库名
	 * @param $description 资源库简介
	 * @return int 资源库ID
	 */

	public function file_change($id,$name) {
		$ans = D('Homework')->where('id='.$id)->field('fid,name')->select();
		$fid = (int)$ans[0]['fid'];

		$dir = D('Resdir')->where('id='.$fid)->field('url')->select();
		$path = $dir[0][url].'/'; //code transe$dir[0].;
		$oldname = iconv("UTF-8", "GB2312", $path.$ans[0]['name']);
		$newname = iconv("UTF-8", "GB2312", $path.$name);
		if(!file_exists($oldname)){ //检查文件是否存在
			return '404';
		}
		$ok = rename($oldname,$newname);
		$data = array ();
		if ($name) $data['name'] = $name;
		return $this->where('id='.$id)->save($data);
	}

	public function file_upload($fid,$sid){
		$dir = D('Resdir')->where('id='.$fid)->field('url')->select();
		$path = iconv("UTF-8", "GB2312", $dir[0][url].'/'); //code transe$dir[0].;
		var_dump($path);
    	import('ORG.Net.UploadFile');
	    $upload = new UploadFile();// 实例化上传类
	    $upload->maxSize  = 3145728 ;// 设置附件上传大小
	    $upload->allowExts  = array('docx','doc','txt','jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->savePath = $dir[0][url].'/';//$path;// 设置附件上传目录
	    $upload->saveRule = '';
	    if(!$upload->upload()) {// 上传错误提示错误信息
	        //$this->error($upload->getErrorMsg());
	    }else{// 上传成功
	    	//提取数据
	    	$info = $upload->getUploadFileInfo();
	    	$data = array(
	    		'name' 			=>	$info[0][savename] ,
	    		'fid' 		=>	$fid,
	    		'student_id'	=>	$sid,
	    	 );
	    	var_dump($data);
	    	$hw = D('Homework');
	    	$rid = $hw->data($data)->add($data);
	    	var_dump($rid);
	        //$this->success('上传成功！');
	        return $rid;
	    }
    }
    //文件下载 (多个文件压缩，文件夹)
    public function file_download($id){
    	$hw = D('Homework');
    	$info = $hw->where('id='.$id)->field('fid,name')->select();
		$dir = D('Resdir')->where('id='.$info[0]['fid'])->field('url')->select();
    	$file_url = $dir[0]['url']."/".$info[0]['name'];

		if(!isset($file_url)||trim($file_url)==''){
			return '500';
		}
		if(!file_exists($file_url)){ //检查文件是否存在
			return '404';
		}
		$file_name=basename($file_url);
		$file_type=explode('.',$file_url);
		$file_type=$file_type[count($file_type)-1];
		$file_name=trim($new_name=='')?$file_name:urlencode($new_name).'.'.$file_type;
		$file_type=fopen($file_url,'r'); //打开文件
		//输入文件标签
		header("Content-type: application/octet-stream");
		header("Accept-Ranges: bytes");
		header("Accept-Length: ".filesize($file_url));
		header("Content-Disposition: attachment; filename=".$file_name);
		//输出文件内容
		echo fread($file_type,filesize($file_url));
		fclose($file_type);
    }
}
