<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$dbref["user"]=array("key"=>"iduser","fields"=>array(
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
));

$dbref["grade"]=array("key"=>"idgrade","fields"=>array(
	"grade",
	"idgrade"
));