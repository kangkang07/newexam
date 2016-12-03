<?php
/**
 *  @property CI_DB_active_record $db
 * @author Qikang
 *
 */

class MY_Model extends CI_Model {
}

class RP_Model extends CI_Model {
	public function __construct() {
		parent::__construct ();
		$this->load->database();
	}
	/**
	 * 对应的写数据表
	 * @var string
	 */
	protected $dbtable;
	/**
	 * 主键
	 * @var string
	 */
	protected $dbkey;
	/**
	 * 对应的读数据表，可以和写数据表相同。有些表可能会有相应的view来读取更完整的数据。
	 * @var string
	 */
	public  $fields;
	//查询
	private function GetQuery(array $param=null)
	{
		if($param!=null)
		foreach ($param as $k=>$v)
		{
			$this->db->where($k,$v);
		}
		return $this->db->get($this->dbtable);
	}
	/**
	 * 根据查询条件返回一条记录
	 * @param array $param 查询的条件集数组
	 * @return object ci data object
	 */
	public function GetOne($param=null)
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
		$this->db->insert($this->dbtable,$data);
		$data[$this->dbkey]= $this->db->insert_id();
		return $data;
	}
	/**
	 * 根据主键更新数据
	 * @param array $data 更新的数据数组，包含主键
	 * @return int 影响的行数
	 */
	public function UpdateByID($id,$data)
	{
		$this->db->where($this->dbkey,$id);
		$this->db->update($this->dbtable,$data);
		return $this->GetByID($id);
	}
	public function UpdateBy($byfields,$updatevalue)
	{
		foreach ($byfields as $k=>$v)
		{
			$this->db->where($k,$v);
		}
		$this->db->update($this->dbtable,$updatevalue);
		return $this->GetList($byfields);
	}
    public function Update($data)
    {
        if(is_array($data))
            return $this->UpdateByID($data[$this->dbkey],$data);
        else
            return $this->UpdateByID($data->{$this->dbkey},$data);
    }
	public function UpsertByID($id,$data)
	{
		$this->db->where($this->dbkey,$id);
		$this->db->from($this->dbtable);
		if($this->db->count_all_results()>0)
			return $this->UpdateByID($id, $data);
		else
			return $this->Create($data);
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
		$this->db->delete($this->dbtable);
	}

}