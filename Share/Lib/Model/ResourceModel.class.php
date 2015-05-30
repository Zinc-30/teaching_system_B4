<?php
/****************************************************
 *         Author: Xin Hao - xinhao20082009@163.com
 *  Last modified: 2015-05-24 18:38
 *       Filename: ResourceModel.class.php
 *    Description: 文件资源共享
 *****************************************************/

class ResourceModel extends Model {
	/**
	 * 该资源ID
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
	 * 所属文件目录id
	 *
	 * @var int
	 */
	protected $category;

	/**
	 * 资源简介
	 * @var string
	 */
	protected $description;

	/**
	 * 资源内容
	 * @var string
	 */
	protected $context;

	/**
	 * 点赞次数
	 * @var int 
	 */
	protected $hits;

	/**
	 * 添加时间
	 * @var int 
	 */
	protected $addtime;
	
	/**
	 * 总数目
	 * @var int 
	 */
	protected $returnAmount;

	
	/**
	 * 返回查询结果总数
	 * 
	 * @return int 结果总数
	 */
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
}
