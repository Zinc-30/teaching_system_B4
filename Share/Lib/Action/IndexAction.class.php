<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
	$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
    }

    public function new_file(){
    	echo ('new_file');
    	$this->display();
    }
	// 文件上传
    public function upload(){
    	echo ('upload');
    	
    	import('ORG.Net.UploadFile');
	    $upload = new UploadFile();// 实例化上传类
	    $upload->maxSize  = 3145728 ;// 设置附件上传大小
	    $upload->allowExts  = array('docx','doc','txt','jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->savePath =  './';// 设置附件上传目录
	    $upload->saveName = '';
	    if(!$upload->upload()) {// 上传错误提示错误信息
	        $this->error($upload->getErrorMsg());
	    }else{// 上传成功
	    	$info = $upload->getUploadFileInfo();
	    	$description = '';
	    	if ($info[0]['type'] == 'text/plain'){// txt文件内容读取
	    		$context = file_get_contents($info[0][savepath].$info[0][savename]);
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
	    		'category' 		=>	1,
	    		'description'	=>	$description,
	    		'context'		=>	$context,
	    		'hits'			=>	0
	    	 );
	    	dump($info);
	    	dump($data);
	    	$resource = D('Resource');
	    	$resource->data($data)->add($data);
	        //$this->success('上传成功！');
	    }
    }

    public function addresdir(){
    	$newdir = D('Resdir');
    	dump($_POST);
    	if ($newdir->create()){
			$result = $newdir->add();
			if($result) {
                $this->success('操作成功！');
            }else{
                $this->error('写入错误！');
            }
        }else{
            $this->error($newdir->getError());
        }
    }

    //赞
    public function like(){
    	$word = new COM("word.application") or die("五法打开 MS Word"); 
				// 显示目前正在使用的Word的版本号 
		echo "Loading Word, v. {$word->Version}<br>"; 
		// 把它的可见性设置为0（假），如果要使它在最前端打开，使用1（真） 
		// to open the application in the forefront, use 1 (true) 
		$word->Visible = 1; 
		//打?一个文档 
		$word->Documents->Open("E:/1.doc") or die("无法打开这个文件"); 
		//读取文档内容 
		$test = $word->ActiveDocument->content->Text; 
		dump($test);  
		// 关闭与COM组件之间的连接 
		$word->Quit(); 
		$word = null;

    }
    //全文搜索
    public function search(){
    	require ( "sphinxapi.php" );
		$cl = new SphinxClient ();
		$cl->SetServer ( '127.0.0.1', 9312);
		$cl->SetConnectTimeout ( 3 );
		$cl->SetArrayResult ( true );
		$cl->SetMatchMode ( SPH_MATCH_ANY);
		$res = $cl->Query ( 'include', "res_index" );
		// print_r($cl);
		var_dump($res);
    }
}