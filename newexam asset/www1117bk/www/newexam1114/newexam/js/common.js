function checkradio(groupname,checkid)
{
	$("."+groupname).removeClass("active");
	$("#"+checkid).addClass("active");
}
function setselect(seldom,value)
{
	$(seldom).find("option").removeAttr("selected");
	$(seldom).find("option").each(function(){
			if($(this).val()==value)
				$(this).attr("selected","selected");
		});
}