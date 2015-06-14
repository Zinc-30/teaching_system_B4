<?php
/****************************************************
 *         Author: Xin Hao - xinhao20082009@163.com
 *  Last modified: 2015-05-24 18:38
 *       Filename: ResourceModel.class.php
 *    Description: 文件资源共享
 *****************************************************/

class ResourceModel extends Model {
	
	/**
	 * 更新资源库信息
	 * 
	 * @param $name 资源库名
	 * @return int 1成功，0失败
	 */
	public function file_change($id,$name) {
		if (!$this->id) {
			return 0;
		}
		$ans = D('Resource')->where('id='.$id)->field('fid,name')->select();
		$fid = $ans[0]['fid'];
		$dir = D('Resdir')->where('id='.$fid)->field('url')->select();
		$path = $dir[0]['url'].'/'; //code transe$dir[0].;
		$oldname = iconv("UTF-8", "GB2312", $path.$ans[0]['name']);
		$newname = iconv("UTF-8", "GB2312", $path.$name);
		$ok = rename($oldname,$newname);
		$data = array ();
		if ($name) $data['name'] = $name;
		
		return $this->where('id='.$id)->save($data);
	}

	public function file_del($id) {
		if (!$this->id) {
			return 0;
		}
		$ans = D('Resource')->where('id='.$id)->field('fid,name')->select();
		$fid = $ans[0]['fid'];
		$dir = D('Resdir')->where('id='.$fid)->field('url')->select();
		$path = $dir[0]['url'].'/'; //code transe$dir[0].;
		$oldname = iconv("UTF-8", "GB2312", $path.$ans[0]['name']);
		$ok = unlink($oldname);
		return $ok;
	}

	public function file_upload($fid){
		$dir = D('Resdir')->where('id='.$fid)->field('url')->select();
		$path = $dir[0][url].'/'; //code transe$dir[0].;
    	var_dump($path);
    	import('ORG.Net.UploadFile');
	    $upload = new UploadFile();// 实例化上传类
	    $upload->maxSize  = 3145728 ;// 设置附件上传大小
	    $upload->allowExts  = array('docx','doc','txt','jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->savePath =  $path;// 设置附件上传目录
	    $upload->saveRule = '';
	    if(!$upload->upload()) {// 上传错误提示错误信息
	        var_dump($upload->getErrorMsg());
	    }else{// 上传成功
	    	//提取数据
	    	$info = $upload->getUploadFileInfo();
	    	if ($info[0]['type'] == 'text/plain'){// txt文件内容读取
	    		$fname = iconv("UTF-8", "GB2312", $info[0][savepath].$info[0][savename]);
	    		$context = file_get_contents($fname);
	    		$context = iconv("GB2312", "UTF-8", $context); 
	    	}
	    	$data = array(
	    		'name' 			=>	$info[0][savename] ,
	    		'category' 		=>	$fid,
	    		'context'		=>	$context,
	    		'hits'			=>	0
	    	 );
	    	dump($info);
	    	dump($data);
	    	$resource = D('Resource');
	    	$rid = $resource->data($data)->add($data);
	        //$this->success('上传成功！');
	        return $rid;
	    }
    }
    //文件下载 (多个文件压缩，文件夹)
    public function file_download($rid){
    	$resource = D('Resource');
    	$info = $resource->where('id='.$rid)->field('fid,name')->select();
		$dir = D('Resdir')->where('id='.$info[0]['fid'])->field('url')->select();
    	$file_url = $dir[0]['url']."/".$info[0]['name'];

		if(!isset($file_url)||trim($file_url)==''){
			return '500';
		}
		if(!file_exists($file_url)){ //检查文件是否存在
			return '404';
		}
		$info = $resource->where('id='.$rid)->setInc('hits');
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
