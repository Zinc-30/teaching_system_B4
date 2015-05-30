<?php
/****************************************************
 *         Author: Xin Hao - xinhao20082009@163.com
 *  Last modified: 2015-05-24 18:38
 *       Filename: ResdirModel.class.php
 *    Description: 文件资源共享文件夹
 *****************************************************/

class Resource_categoryModel extends Model {
	/**
	 * 该资源库ID
	 * 
	 * @var int
	 */
	protected $id;
	
	/**
	 *  资源库名
	 *  
	 * @var string
	 */
	protected $name;

	/**
	 * 资源库简介
	 * @var string
	 */
	protected $description;

	/**
	 * 资源内容
	 * @var string
	 */
	protected $context;

	/**
	 * 添加时间
	 * @var int 
	 */
	protected $addtime;
	
	/**
	 * 更新时间
	 * @var int 
	 */
	protected $updatetime;
	
	// 定义自动验证
    protected $_validate    =   array(
        array('name','require','标题必须'),
        );
    // 定义自动完成
    protected $_auto    =   array(
        array('addtime','time',1,'function'),
        );
}
