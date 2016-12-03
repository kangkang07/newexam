<?php 


/**
 * @
 * @author Qikang
 *
 */
class TagLogic extends ET_Model{
	public function __construct(){
		parent::__construct ();
		$this->dbreadtable="entitytag";
		$this->dbwritetable="vwentitytag";
		$this->dbkey="identitytag";

	}
	
	public function TGetAllTags($entityid,$source)
	{
		$rst=$this->GetList(array($this->dbkey=>$entityid));
		$tags=[];
		foreach ($rst as $t)
		{
			$tags[$t->categoryname]=$t->tagname;
		}
		return $tags;
	}
	public function GetTagTree($tagid)
	{
		$rst=$this->GetList(array($this->dbkey));
	}
	public function TAddTag($cat,$tag,$sourceid,$entityid)
	{
		$this->load->model("Tag/Tag","tag");
		$taginfo=$this->tag->GetOne(array("tagname"=>$tag,"idcategory"=>$cat));
		if($taginfo!=null)
		{
			$tagid=$this->tag->Create(array("cat"=>$cat,"name"=>$tag));
		}
		else
			$tagid=$taginfo->idtag;
		$this->Create(array("entityid"=>$entityid,"tagid"=>$tagid,"entitysource"=>$this->sourceid));
		
	}
	public function TGetTagsByCats($cats,$entityid,$entitysource)
	{
		$qry=$this->GetByCatQry($cats, $entityid, $entitysource);
		return $qry->result();
	}
	public function TGetTagByCat($cat,$entityid,$entitysource)
	{
		$qry=$this->GetByCatQry(array($cat), $entityid, $entitysource);
		return $qry->result();
	}
	//help function base
	private function GetByCatQry($cats,$eid,$esource)
	{
		$this->db->where_in('idcategory',$cats);
		$this->db->where("entityid",$eid);
		$this->db->where("entitysource",$esource);
		$qry=$this->db->get($this->dbreadtable);
		return $qry;
	}

}