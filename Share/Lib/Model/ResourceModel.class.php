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
		$ans = D('Resource')->where('id='.$id)->field('fid,name')->select();
		$fid = $ans[0]['fid'];
		$dir = D('Resdir')->where('id='.$fid)->field('url')->select();
		$path = $dir[0]['url'].'/';
		$oldname = iconv("UTF-8", "GB2312", $path.$ans[0]['name']);
		$ok = unlink($oldname);
		$ans = D('Resource')->where('id='.$id)->delete();
		$res = system('java -Dc=xin -Ddata=args -jar solr/post.jar "<delete><id>'.$id.'</id></delete>"');
		return $ok;
	}

	public function file_upload($fid){
		$dir = D('Resdir')->where('id='.$fid)->field('url')->select();
		$path = $dir[0][url].'/'; //code transe$dir[0].;
    	import('ORG.Net.UploadFile');
	    $upload = new UploadFile();// 实例化上传类
	    $upload->maxSize  = 3145728 ;// 设置附件上传大小
	    $upload->allowExts  = array('pptx','ppt','pdf','docx','doc','txt','jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->savePath = $path;// 设置附件上传目录
	    $upload->saveRule = '';
	    if(!$upload->upload()) {// 上传错误提示错误信息
	    	echo "fail";
	    }else{// 上传成功
	    	//提取数据
	    	$info = $upload->getUploadFileInfo();
	    	var_dump($fid);
	    	var_dump($info[0][savename]);
	    	$fname = iconv("UTF-8", "GB2312", $info[0][savepath].$info[0][savename]);
	    	$in = D('Resource')->where('fid='.$fid." AND ".'name="'.$info[0][savename].'"')->select();
	    	var_dump($in);
	    	if (!$in){
		    	$data = array(
		    		'name' 			=>	$info[0][savename] ,
		    		'fid' 		=>	$fid,
		    		'context'		=>	$context,
		    		'hits'			=>	0
		    	 );
		    	$resource = D('Resource');
		    	$rid = $resource->data($data)->add($data);
	    	}else{
	    		$rid = $in[0]['id'];
	    	}
	    	system("java -Dc=xin -Dparams=literal.id=".$rid." -Dauto -jar solr/post.jar ".$fname);
	    	//echo "ok!";
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
			echo "url empty";
			return '500';
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
