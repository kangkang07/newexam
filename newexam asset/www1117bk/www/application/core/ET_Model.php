<?php
/**
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 * @property CI_Calendar $calendar
 * @property Email $email
 * @property CI_Encrypt $encrypt
 * @property CI_Ftp $ftp
 * @property CI_Hooks $hooks
 * @property CI_Image_lib $image_lib
 * @property CI_Language $language
 * @property CI_Log $log
 * @property CI_Output $output
 * @property CI_Pagination $pagination
 * @property CI_Parser $parser
 * @property CI_Session $session
 * @property CI_Sha1 $sha1
 * @property CI_Table $table
 * @property CI_Trackback $trackback
 * @property CI_Unit_test $unit
 * @property CI_Upload $upload
 * @property CI_URI $uri
 * @property CI_User_agent $agent
 * @property CI_Validation $validation
 * @property CI_Xmlrpc $xmlrpc
 * @property CI_Zip $zip
 * @property Tag $tag;
 */


/**
 *对象映射基类，继承自该类的每个子类对应于一个数据库表
 * @author Qikang
 *
 */
class ET_Model extends CI_Model {
	public function __construct() {
		parent::__construct ();
		$this->load->database();
		$this->load->model("Tag/TagLogic","taglogic");
	}
	/**
	 * 对应的写数据表
	 * @var string
	 */
	protected $dbwritetable;
	/**
	 * 主键
	 * @var string
	 */
	protected $dbkey;
	/**
	 * 对应的读数据表，可以和写数据表相同。有些表可能会有相应的view来读取更完整的数据。
	 * @var string
	 */
	protected $dbreadtable;
	public  $fields;
	protected $tagsourceid;
	//查询
	private function GetQuery(array $param=null,$and=TRUE)
	{
		if($param!=null)
		foreach ($param as $k=>$v)
		{
			if($and)
				$this->db->where($k,$v);
			else 
				$this->db->or_where($k,$v);
		}
		return $this->db->get($this->dbreadtable);
	}
	/**
	 * 根据查询条件返回一条记录
	 * @param array $param 查询的条件集数组
	 * @return object ci data object
	 */
	public function GetOne($param=null,$and=TRUE)
	{
		$query=$this->GetQuery($param);
		return $query->row();
	}
	/**
	 * 根据主键值返回结果
	 * @param string $id 主键值
	 * @return object ci data object
	 */
	public function GetByID($id)
	{
		return $this->GetOne(array($this->dbkey=>$id));
	}
	/**
	 * 根据查询条件返回ci结果集
	 * @param array $param
	 * @return array ci query
	 */
	public function GetList($param=null)
	{
		$query=$this->GetQuery($param);
		return $query->result();
	}
	/**
	 * 根据查询条件返回结果数目
	 * @param array $param 查询条件集数组
	 * @return int 结果数
	 */
	public function Count($param=null)
	{
		$query=$this->GetQuery($param);
		return $query->num_rows();
	}
	//写入
	/**
	 * 插入数据
	 * @param array $data 新数据数组，对应一行数据
	 * @return int 新插入数据的主键值
	 */
	public function Create($data)
	{
		$this->db->insert($this->dbwritetable,$data);
		return $this->db->insert_id();
	}
	/**
	 * 根据主键更新数据
	 * @param array $data 更新的数据数组，包含主键
	 * @return int 影响的行数
	 */
	public function UpdateByID($id,$data)
	{
		$this->db->where($this->dbkey,$id);
		$this->db->update($data);
		return  $this->db->affected_rows();
	}
	public function UpdateBy($byfields,$updatevalue)
	{
		foreach ($byfields as $k=>$v)
		{
			$this->db->where($k,$v);
		}
		$this->db->update($this->dbwritetable,$updatevalue);
		return $this->db->affected_rows();
	}

	public function DeleteByID($id)
	{
		$this->Delete(array($this->dbkey=>$id));
	}

	public function Delete(array $param)
	{
		foreach ($param as $k=>$v)
		{
			$this->db->where($k,$v);
		}
		$this->db->delete($this->dbwritetable);
	}
	public function AddTag($entityid,$catid,$tag)
	{
		$this->taglogic->TAddTag($catid,$tag,$this->tagsourceid,$entityid);
	}
	public function DeleteTag($entityid,$tagid)
	{
		$this->taglogic->Delete(array("entityid"=>$entityid,"tagid"=>$tagid,"entitysource"=>$this->tagsourceid));
	}
	public function GetAllTags($entityid)
	{
		return $this->taglogic->TGetAllTags($entityid,$this->tagsourceid);
	}
	public function GetTagByCat($cat,$id)
	{
		return	$this->taglogic->TGetTagByCat($cat,$id,$this->tagsourceid);
	}
	public function GetTagsByCats($cats,$id)
	{
		return $this->taglogic->TGetTagsByCats($cats,$id,$this->tagsourceid);
	}
	
}

class TR_Model extends ET_Model {
	public function __construct() {
		parent::__construct ();
		$this->load->database();
	}
	protected $dbfatherRef;
	public function GetTree($id)
	{
		$entity=$this->GetByID($id);
		$entity=$this->GetChildrenRecur($entity);
		$entity=$this->GetFatherRecur($entity);
		return $entity;
	}
	
	public function GetFatherRecur($entity)
	{
		if($entity->{$this->dbfatherRef}!=0){
			$father=$this->GetByID($entity->{$this->dbfatherRef});
			$father=$this->GetFatherRecur($father);
			$entity->father=$father;
		}
		return $entity;
	}
	public function GetChildrenRecur($entity)
	{
		$children=$this->GetList(array($this->dbfatherRef=>$entity->{$this->dbkey}));
		foreach($children as $cet)
		{
			$cet=$this->GetChildrenRecur($cet);
		}
		$entity->children=$children;
		return $entity;
	}
	
}
?>
