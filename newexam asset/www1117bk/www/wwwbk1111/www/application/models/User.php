<?php 

/**
 * @category entity class 实体类
 * @author Qikang
 *
 */
class User extends ET_Model{
	public function __construct(){
		parent::__construct ();
		$this->dbreadtable="user";
		$this->dbwritetable="user";
		$this->dbkey="iduser";
		$this->tagsourceid=1;
	}
	
	/**
	 * 注册
	 * @param array $data 用户信息
	 */
	public function Register(array $data,$pwd)
	{
		$uid=$this->Create($data);
		$pwd=md5($pwd);
		$this->db->insert("userpwd",array("userid"=>$uid,"pwd"=>$pwd));
		return $this->GetByID($uid);
	}
	
	
	/**
	 * 登陆
	 * @param array $data	该数组应当包含：登陆账号，包括email,phone,name等等；pwd，密码
	 * @return boolean
	 */
	public function Login(array $data)
	{
		$data["pwd"]=md5($data["pwd"]);
		$this->db->where($data);
		$qry=$this->db->get("vwuserpwd");
		if($qry->num_rows()>0)
		{
			$user=$qry->row();
			$this->UpdateBy(array('iduser'=>$user->iduser), array('lastlogon'=>date("Y-m-d H:i:s")));
			return $this->GetByID($user->iduser);
		}
		else 
			return 0;
	}
	
	
	
	/**
	 * 更改密码
	 * @param string $uid	用户id
	 * @param string $oldpwd	旧密码
	 * @param string $newpwd	新密码
	 */
	public function ChangePWD($uid,$oldpwd,$newpwd)
	{
		$qry=$this->db->where(array("iduser"=>$uid,"pwd"=>md5($oldpwd)));
		$qry=$this->get("vwuserpwd");
		if($qry->num_rows()>0)
		//if($this->Count(array('iduser'=>$uid,'pwd'=>md5($oldpwd)))>0)
		{
			$this->db->update("userpwd",array("iduser"=>$uid,"pwd"=>md5($newpwd)));
			return 1;
		}
		else 
			return 0;
		
	}
	
	
}
?>