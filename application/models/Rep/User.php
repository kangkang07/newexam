<?php 

/**
 * @category entity class 实体类
 * @author Qikang
 *
 */
class User extends RP_Model{
	public function __construct(){
		parent::__construct ();
		$this->dbtable="user";
		$this->dbkey="iduser";
		$this->fields=array(
			"iduser",
			"username",
			"role",
			"schoolid",
			"grade",
			"class",
			"major",
			"gender",
			"created",
			"updated",
			"guid"
		);
	}
	

	
	/**
	 * 登陆
	 * @param array $data	该数组应当包含：登陆账号，包括email,phone,name等等；pwd，密码
	 * @return boolean
	 */
	public function Login(array $data)
	{
		//$data["pwd"]=md5($data["pwd"]);
		if($this->Count($data)>0)
		{
			
			$user=$this->GetOne($data);
			//$this->UpdateBy(array('iduser'=>$user->iduser), array('lastlogon'=>date("Y-m-d H:i:s")));
			$this->load->library("session");
			$this->session->set_userdata('user',$this->GetByID($user->iduser));
			return $this->session->user;
		}
		else 
			return 0;
	}
	
	public function LogOut(){
		$this->load->library("session");
		$this->session->unset_userdata("user");
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

    public function GetBySID($sid)
    {
        return $this->GetOne(array("schoolid"=>$sid));
    }
    public function UpdateBySID($user)
    {
    	$this->UpdateBy(array("schoolid"=>$user["schoolid"]), $user);
        return $this->GetBySID($user["schoolid"]);
    }

    public function UpsertBySID($user)
    {
    	if($this->GetBySID($user["schoolid"])==null)
    		return $this->Create($user);
    	else 
    		return $this->UpdateBySID($user);
    }
   
	
	
}
?>