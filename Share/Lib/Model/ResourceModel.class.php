<?php
/****************************************************
 *         Author: Xin Hao - xinhao20082009@163.com
 *  Last modified: 2015-05-24 18:38
 *       Filename: ResourceModel.class.php
 *    Description: 文件资源共享
 *****************************************************/

class ResourceModel extends Model {
	
	public function getReturnAmount() {
		return $this->returnAmount;
	}
	
	/**
	 * 添加资源库
	 * 
	 * @param $name 资源库名
	 * @param $description 资源库简介
	 * @return int 资源库ID
	 */
	public function addResource($name, $description, $category = 0) {
		
		$data = array (
		'NAME' => $name,
		'CATEGORY' => $category,
		'DESCRIPTION' => $description);
		
		$this->id = $this->add($data);
		
		$this->getResource();
		
		return $this->id;
	}
	
	/**
	 * 获得资源库信息
	 * 
	 * @return array 信息，0失败
	 */
	public function getResource($id = null) {
		if ($id) {
			$this->setResource($id);
		}
		
		$condition = Array();
		$condition['where'] = "ID={$this->id}";
		
		$data = $this->find($condition);
		
		foreach ($data as $key => $item) {
			$key = strtolower($key);
			$this->{$key} = $item;
		}
		
		return $data;
	}

	/**
	  * 获取所有资源库
	  */
	public function getAllResource($limit) {
		$name = '';
		return $this->searchResource($name, $limit);
	}

	/**
	 * 查询资源库
	 * 
	 * @param $option 查询条件
	 * @param $limit 结果数
	 * @return array 结果集
	 */
	public function searchResource($name = '', $limit) {
		$condition = Array();

		if (is_array($limit)) {
			$condition['limit'] = $limit['START'].','.$limit['LIMIT'];
		}
		if ($name) {
			$condition['where'] = "NAME LIKE %{$name}%";
		}
		$condition['order'] = "ID DESC";

		//返回所有满足条件的个数，无视limit
		$this->returnAmount = $this->where($condition['where'])->count();
		
		return $this->select($condition);
	}
	
	/**
	 * 设置当前资源库
	 * 
	 * @param $id 资源库ID
	 * @return null
	 */
	public function setResource($id) {
		$this->id = $id;
	}
	
	/**
	 * 更新资源库信息
	 * 
	 * @param $name 资源库名
	 * @return int 1成功，0失败
	 */
	public function updateResource($name, $description) {
		if (!$this->id) {
			return 0;
		}
		
		$this->getResource();
		
		if (!$name) $name = $this->name;
		if (!$description) $description = $this->description;
		
		$data = array (
		'NAME' => $name,
		'DESCRIPTION' => $description);
		
		$condition = Array();
		$condition['where'] = "ID={$this->id}";
		
		return $this->save($data, $condition);
	}

	public function file_upload($fid){
		$dir = D('Resdir')->where('id='.$fid)->field('url')->select();
		$path = $dir[0][url].'/'; //code transe$dir[0].;
    	import('ORG.Net.UploadFile');
	    $upload = new UploadFile();// 实例化上传类
	    $upload->maxSize  = 3145728 ;// 设置附件上传大小
	    $upload->allowExts  = array('docx','doc','txt','jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->savePath =  $path;// 设置附件上传目录
	    $upload->saveRule = '';
	    if(!$upload->upload()) {// 上传错误提示错误信息
	        //$this->error($upload->getErrorMsg());
	    }else{// 上传成功
	    	//提取数据
	    	$info = $upload->getUploadFileInfo();
	    	if ($info[0]['type'] == 'text/plain'){// txt文件内容读取
	    		$fname = iconv("UTF-8", "GB2312", $info[0][savepath].$info[0][savename]);
	    		$context = file_get_contents($fname);
	    		$context = iconv("GB2312", "UTF-8", $context); 
	    	}
	    	if ($info[0]['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'){// txt文件内容读取
	    		// 建立一个指向新COM组件的索引 
				$word = new COM("word.application") or die("五法打开 MS Word"); 
				// 显示目前正在使用的Word的版本号 
				echo "Loading Word, v. {$word->Version}<br>"; 
				// 把它的可见性设置为0（假），如果要使它在最前端打开，使用1（真） 
				// to open the application in the forefront, use 1 (true) 
				$word->Visible = 0; 
				//打?一个文档 
				$word->Documents->Open("E:/1.docx") or die("无法打开这个文件"); 
				//读取文档内容 
				$test = $word->ActiveDocument->content->Text; 
				dump($test);  
				// 关闭与COM组件之间的连接 
				$word->Quit(); 
				$word = null;
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
    	$info = D('Resource')->where('id='.$rid)->field('fid,name')->select();
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
