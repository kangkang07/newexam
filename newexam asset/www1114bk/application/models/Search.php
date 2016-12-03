<?php

/**
 * @property Item $item
 * @author Qikang
 *
 */

class Search extends CI_Model {
	public function __construct() {
		parent::__construct ();
		$this->load->library("session");
		if($this->session->user==null)
		{
			
		}
	}
	public function MatchItem($cats,$tags)
	{
		
	}
	/**
	 * 
	 * @param unknown $param
	 * @param string $withimage
	 * @param string $withtags
	 */
	public function SearchItems($param,$withimage=false,$withtags=false)
	{
		if($withimage==null)
			$withimage=false;
		$withtags=$withtags==null?false:$withtags;
		$this->load->model("Item","item");
		$this->load->model("Tag/Tag","tag");
		foreach ($param as $k=>$v)
		{
			if(in_array($k, $this->item->fields))
				$this->db->where($k,$v);
			else 
				$this->db->where(array("categoryname"=>$k,"tagname"=>$v));
		}
		$qry=$this->get("vwitemsearch");
		
		$itemlist=array();
		$this->load->helper("array");
		foreach ($qry->result_array() as $itarray)
		{
			
			if(!array_key_exists($itarray["iditem"], $itemlist))
			{
				$it=(object)elements($this->item->fields,$itarray);
				if($withimage)
					$it->images=$this->item->GetImages($it->iditem);
				if($withtags){
					$it->tags=array();
				}
				array_push($itemlist,$it);
			}
			else
				$it=$itemlist[$itarray["iditem"]];
			if($withtags)
				if($itarray["idtag"]!=null)
				{
					$it->tags[$itarray["categoryname"]]=$itarray["tagname"];
				}
		}
		return $itemlist;
	}
}

?>