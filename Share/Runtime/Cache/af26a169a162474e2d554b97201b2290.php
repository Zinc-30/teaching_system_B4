<?php if (!defined('THINK_PATH')) exit();?><html>
	<form id="upload" method='post' action="<?php echo U('uploadfile');?>" enctype="multipart/form-data">
	<input name="1" type="file" />
	<input type="submit" value="提交" >
	</form>

	<form id="adddor" method='post' action="<?php echo U('addresdir');?>">
	标题：<INPUT type="text" name="name"><br/>
	内容：<TEXTAREA name="description" rows="5" cols="45"></TEXTAREA><br/>
	<input type="submit" value="提交" >
	</form>
</html>