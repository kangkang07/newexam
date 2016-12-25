function ChapList(){
	this.list=[];
	this.render=function(){
		var html="";
		for(i in this.list)
		{
			html+=this.list[i].renderpanel();
		}
		$("#newchapter").before(html);
		for(i in this.list)
		{
			this.list[i].bindevent();
		}
	};
	this.load=function(callback)
	{
		$this=this;
		$.ajax({
			url:"/Chapterapi/GetAll",
			dataType:"json",
			success:function(data)
			{
				var cp;
				//$this.list=[];
				for(i in data)
				{
					cp=new Chapter();
					cp.init(data[i]);
					$this.list.push(cp);
				}
				//callback();
				$this.render();

			},
			error:function(xhr,status,error){
				console.log(error);
			}
		});
	};
	this.refresh=function(){
		this.load(this.render);
		//this.render();
	};
	this.savenew=function()
	{
		var chapname=$("#newchapname").val();
		if(chapname=="")
			{
			alert("请输入章节名");
			return false;
			}
		$this=this;
		$.ajax({
			url:"/Chapterapi/Create",
			type:"POST",
			cache:false,
			data:{
				data:{
				"chaptername":chapname
				}
			},
			success:function(data){
				var newc=new Chapter();
				newc.init(data);
				$this.list.push(newc);
				$this.renderone(newc);
				
				$("#newchapter").hide();
				$("#addchapter").show();
			},
			error:function(){
				alert("添加失败");
			}
		});
	};
	this.renderone=function(cpt)
	{
		var html=cpt.renderpanel();
		$("#newchapter").before(html);
		cpt.bindevent();
	};
	this.findbyid=function(id){
		for(i in this.list)
		{
			if(this.list[i].cid==id)
				return this.list[i];
		}
		return null;
	};
}
function Chapter(){
	this.cid;
	this.qstlist=[];
	this.loaded=false;
	this.qstloaded=false;
	this.qstloading=false;
	this.name;

	this.dom;

	this.init=function(data){
		this.cid=data.idchapter;
		this.name=data.chaptername;
		this.loaded=true;
		
	};
	this.bindevent=function(){
		this.dom=$("[data-cpt="+this.cid+"]").first();
		
		$(this.dom).find(".addqst").click(this,function(e){
			cqst=new Question(e.data.cid);
			cqst.renderquestion();
		});
		$(this.dom).find(".refreshqst").click(this,function(e){
			e.data.loadqst();
		});
		$(this.dom).find(".editchap").click(this,function(e){
			e.data.changechapname();
		});
		$(this.dom).find(".preview").click(this,function(e){
			e.data.previewqst();
		});
		$(this.dom).find(".savechap").click(this,function(e){
			e.data.savechange();
		});
		$(this.dom).find(".cancelchap").click(this,function(e){
			$(e.data.dom).find(".cpt-title").show();
			$(e.data.dom).find(".chapter-edit").hide();
		});
		$(this.dom).find(".chapter-edit").click(function(e){
			e.stopPropagation();
		});
		$(this.dom).find(".chapter-item").click(this,function(e){
			if(!e.data.qstloaded&&!e.data.qstloading)
			{
				e.data.loadqst();
			}

		});
	};
	this.load=function(id){
		$this=this;
		$.ajax({
			url:"/Chapterapi/GetByID/"+id,
			success:function(data){
				$this.init(data);
			}
		});
	};
	this.initqstlist=function(data){

		var q;
		this.qstlist=[];
		for(i in data)
		{
			q=new Question();
			q.simpleinit(data[i]);
			this.qstlist.push(q);
		}
	};
	this.renderqstlist=function()
	{
		var html="";
		for(i in this.qstlist)
		{
			html+=this.qstlist[i].renderlistitem();
		}
		$("[data-cpt="+this.cid+"]").find(".qst-item").remove();
		$("#qstlist-"+this.cid).append(html);
		for(i in this.qstlist)
		{
			this.qstlist[i].bindevent();
		}
	};
	this.loadqst=function(){
		if(!this.loaded)
			return false;
		$(this.dom).find(".list-loading").show();
		$(this.dom).find(".qst-item").hide();
		$this=this;
		this.qstloading=true;
		$.ajax({
			url:"/Questionapi/GetBy",
			type:"POST",
			cache:false,
			data:{param:{"chapter":$this.cid},orderby:"type,cast(refid as signed)"},
			success:function(data){
				$this.initqstlist(data);
				$this.renderqstlist();
				$($this.dom).find(".list-loading").hide();
				$($this.dom).find(".qst-item").show();
				$this.qstloading=false;
				$this.qstloaded=true;

			}
		});
	};
	// this.loadstatistics=function(){
	// 	if(this.qstloaded)
	// 	{
	// 		$this=this;
	// 		var data=function(){
	// 			var qstidlist=[];
	// 			for(i in $this.qstlist)
	// 			{
	// 				qstidlist.push($this.qstlist[i].qid);
	// 			}
	// 			return qstidlist;
	// 		};
	// 		$.ajax({
	// 			url:"/Questionapi/GetStatistics",
	// 			type:"POST",
	// 			cache:false,
	// 			data:data(),
	// 			success:function(data){
	// 				for(i in data){
	// 					var qss=data[i];
	//
	// 				}
	// 			}
    //
	// 		})
	// 	}
	// }
	
	this.renderpanel=function(){
		var newc=$("#tpl-newchapter").clone();
		$(newc).find(".cpt-title").html(this.name);
		var html=$(newc).html();
		html=html.replace(/{cid}/g, this.cid);
		return html;
	};

	this.changechapname=function(){
		$(this.dom).find(".editor-cptname").val(this.name);
		$(this.dom).find(".cpt-title").hide();
		$(this.dom).find(".chapter-edit").show();
	};
	this.savechange=function(){
		var chapname=$.trim($(this.dom).find(".editor-cptname").val());
		if(chapname=="")
		{
			alert("请输入章节名");
			return false;
		}
		$this=this;
		$.ajax({
			url:"/Chapterapi/UpdateByID",
			type:"POST",
			cache:false,
			data:{
				id:$this.cid,
				data:{
					"chaptername":chapname
				}
			},
			success:function(data){
				
				$this.init(data);
				$($this.dom).find(".cpt-title").html($this.name);
				$($this.dom).find(".cpt-title").show();
				$($this.dom).find(".chapter-edit").hide();
			},
			error:function(){
				alert("修改失败");
			}
		});
	};
	this.previewqst=function()
	{
		window.open("Questionapi/previewchapter/"+this.cid)
	}
	this.addqst=function(qst)
	{
		this.qstlist.push(qst);
		this.renderqstlist();
	};
	this.updateqst=function(qst)
	{
		for(i in this.qstlist)
		{
			if(this.qstlist[i].qid==qst.qid)
			{
				this.qstlist[i]=qst;
				break;
			}
		}
		this.renderqstlist();
	};
	this.deleteqst=function(qst)
	{
		var index;
		for(i in this.qstlist)
		{
			if(this.qstlist[i].qid==qst.qid)
			{
				index=i;
				break;
			}
		}
		if(index!=undefined)
			this.qstlist.splice(i,1);//delete this one
		this.renderqstlist();
	};
}
function Question(cpt){
	this.qid;
	this.title="";

	this.chapter=cpt;
	this.type=1;
	this.maintext="";
	this.o1="";
	this.o2="";
	this.o3="";
	this.o4="";
	this.answer="";
	this.star=0;
	this.group="";
	this.refid="";
	this.usercount=0;
	this.rightcount=0;
	this.rightrate="";

	this.dom;

	this.load=function(id){
		if(id==undefined)
			id=this.qid;
		$this=this;
		$.ajax({

			url:"/Questionapi/GetByID/"+id+"?random="+Math.random(),
			success:function(data){
				$this.init(data);
				cqst=$this;
				$this.renderquestion();
			}
		});
	};
	this.simpleinit=function(data)
	{
		this.qid=data.idquestion;
		this.star=data.star;
		this.group=data.group;
		this.type=data.type;
		this.chapter=data.chapter;
		this.title=data.title;
		this.refid=data.refid;
		this.usercount=data.usercount;
		this.rightcount=data.rightcount;
		this.rightrate=0;
		if(this.usercount!=0)
		this.rightrate=(100*this.rightcount/this.usercount).toFixed(2).toString();
		console.log(this.rightcount);

	};
	this.bindevent=function(){
		this.dom=$("#qst-"+this.qid).first();
		
		$(this.dom).click(this,function(e){
			e.data.load();
		});
	};
	this.gettitle=function()
	{
		var typetext=this.type==1?"选择":"判断";
		var stars="";
		for(i=this.star;i>0;i--)
		{
			stars+="★";
		}
		var title="";
		if(this.refid!=null)
			title+=this.refid+". ";
		title+="["+typetext+"]";
		if(stars!="")
			title+="["+stars+"]";
		if(this.group!=""&&this.group!=undefined)
			title+="{"+this.group+"}";
		return title+this.title;
	};
	this.init=function(data)
	{
		this.simpleinit(data);
		this.maintext=data.maintext;
		this.o1=data.o1;
		this.o2=data.o2;
		this.o3=data.o3;
		this.o4=data.o4;
		this.answer=data.answer;
		this.refid=data.refid;

	};
	this.renderlistitem=function(){
		var qst=$("#tpl-qstlistitem").clone();
		var html=this.gettitle();
		html+="<span class='qst-statistic'> 【使用："+this.usercount+"次 &nbsp;&nbsp; 正确率："+this.rightrate+"% 】</span>";
		qst.find("button").html(html);

		html=$(qst).html();
		 html=html.replace(/{qid}/g,this.qid);
		// html=html.replace("{usecount}",this.usecount);
		// html=html.replace("{rightrate}",this.rightrate);

		return html;
	};

	this.renderquestion=function(data){
		if(data==undefined)
			data=this;
		$("#qstwell").show();
		$("#emptymsg").hide();
		uemain.setContent(data.maintext);
		$("#qst-group").val(data.group);
        $("#qst-refid").val(data.refid);
		setselect($("#qst-star"),data.star);
		//$("#qst-star").selectedIndex=data.star-1;
		if(data.qid==undefined||data.qid==0)
			$("#editingmode").html("添加题目");
		else
			$("#editingmode").html("编辑题目");
		var cpt=chaplist.findbyid(data.chapter);
		$("#qst-chaptitle").html(cpt.name);
		if(data.type==1){
			qtype="select";
			ueop1.setContent(data.o1);
			ueop2.setContent(data.o2);
			ueop3.setContent(data.o3);
			ueop4.setContent(data.o4);
			checkradio("qst-select-a","as-"+data.answer);

		}
		else
		{
			qtype='bool';
			checkradio("qst-bool-a","as-"+data.answer);
		}
		this.renderqtype(data.type);
	};
	this.renderqtype=function(type)
	{
		if(type==1)
		{
			$("#qst-select").show();
			$("#qst-bool").hide();
			checkradio("qst-type","qtypeselect");
		}
		else{
			$("#qst-select").hide();
			$("#qst-bool").show();
			checkradio("qst-type","qtypebool");
		}

	};

	this.setselect=function(){
		this.type=1;
		this.renderqtype(this.type);
	};
	this.setbool=function(){
		this.type=2;
		this.renderqtype(this.type);
	};

	this.saveqst=function()
	{
		var group=$("#qst-group").val();
		var star=$("#qst-star").val();
        var refid=$("#qst-refid").val();
		var maintext=uemain.getContent();

		var o1=ueop1.getContent();
		var o2=ueop2.getContent();
		var o3=ueop3.getContent();
		var o4=ueop4.getContent();
		var title=uemain.getContentTxt();
		var type=$(".qst-type.active").find("input").val();
		var answer;
		if(type=="1")
			answer=$(".qst-select-a.active").find("input").val();
		else
			answer=$(".qst-bool-a.active").find("input").val();

		var data={
			group:group,
			star:star,
			type:type,
			maintext:maintext,
			o1:o1,
			o2:o2,
			o3:o3,
			o4:o4,
			answer:answer,
			title:title,
			chapter:cqst.chapter,
            refid:refid
		};

		var url,editmode;
		if(cqst.qid==undefined||cqst.qid==0){
			url="/Questionapi/Create";
			editmode="create";
			data={data:data};
		}
		else
		{	
			url="/Questionapi/UpdateByID";
			editmode="update";
			data={
				id:cqst.qid,
				data:data
			};
		}

		if($.trim(maintext)=="")
		{
			alert("请填写题目！");
			return false;
		}
		if(type==1&&$.trim(o1+o2+o3+o4)=="")
		{
			alert("请填写至少一个选项！");
			return false;
		}
		if(answer==undefined)
		{
			alert("请选择答案！");
			return false;
		}
		
		
		$.ajax({
			url:url,
			type:"POST",
			cache:false,
			data:data,
			success:function(data){
				cqst.init(data);
				var cpt=chaplist.findbyid(cqst.chapter);
				if(editmode=="create")
				{
					
					cpt.addqst(cqst);
				}
				else
				{
					cpt.updateqst(cqst);
				}
				alert("保存成功！");

			}
		});

	};
	this.deleteme=function()
	{
		if(confirm("确定要删除吗？")){
			$this=this;
			$.ajax({
				url:"/Questionapi/DeleteByID/"+$this.qid,
				success:function(data){
					chaplist.findbyid($this.chapter).deleteqst($this);
					$("#qstwell").hide();
					$("#emptymsg").show();
					alert("删除成功");
				}
			});

		}	
	};



}


var uemain,ueop1,ueop2,ueop3,ueop4,qtype;
var cqst;
var chaplist;
var cchap;
var ueoption={
	elementPathEnabled:false,
	wordCount:false,
	enableAutoSave:false,
	autoFloatEnabled:false,
	toolbars: [
    [
        'anchor', //锚点
        'undo', //撤销
        'redo', //重做
        'bold', //加粗
        'indent', //首行缩进
        'snapscreen', //截图
        'italic', //斜体
        'underline', //下划线
        'strikethrough', //删除线
        'subscript', //下标
        'fontborder', //字符边框
        'superscript', //上标
        'formatmatch', //格式刷
        'source', //源代码
        'blockquote', //引用
        'pasteplain', //纯文本粘贴模式
        'selectall', //全选
        'print', //打印
        'preview', //预览
        'horizontal', //分隔线
        'removeformat', //清除格式
        'time', //时间
        'date', //日期
        'unlink', //取消链接
        'insertrow', //前插入行
        'insertcol', //前插入列
        'mergeright', //右合并单元格
        'mergedown', //下合并单元格
        'deleterow', //删除行
        'deletecol', //删除列
        'splittorows', //拆分成行
        'splittocols', //拆分成列
        'splittocells', //完全拆分单元格
        'deletecaption', //删除表格标题
        'inserttitle', //插入标题
        'mergecells', //合并多个单元格
        'deletetable', //删除表格
        'cleardoc', //清空文档
        'insertparagraphbeforetable', //"表格前插入行"
        'fontfamily', //字体
        'fontsize', //字号
        'paragraph', //段落格式
        'simpleupload', //单图上传
        'edittable', //表格属性
        'edittd', //单元格属性
        'link', //超链接
        'spechars', //特殊字符
        'searchreplace', //查询替换
        'justifyleft', //居左对齐
        'justifyright', //居右对齐
        'justifycenter', //居中对齐
        'justifyjustify', //两端对齐
        'forecolor', //字体颜色
        'backcolor', //背景色
        'insertorderedlist', //有序列表
        'insertunorderedlist', //无序列表
        'fullscreen', //全屏
        'directionalityltr', //从左向右输入
        'directionalityrtl', //从右向左输入
        'rowspacingtop', //段前距
        'rowspacingbottom', //段后距
        'pagebreak', //分页
        'insertframe', //插入Iframe
        'imageleft', //左浮动
        'imageright', //右浮动
        'attachment', //附件
        'imagecenter', //居中
        'lineheight', //行间距
        'edittip ', //编辑提示
        'customstyle', //自定义标题
        'autotypeset', //自动排版
        'touppercase', //字母大写
        'tolowercase', //字母小写
        'background', //背景
        'template', //模板
        'scrawl', //涂鸦
        'music', //音乐
        'inserttable', //插入表格
        'drafts', // 从草稿箱加载

    ]
]
        // toolbars: [['fullscreen', 'source', '|', 'bold', 'italic', 'underline', '|', 'fontsize','lineheight', '|', 'kityformula', 'preview']]
};
function InitUE(nodeid)
{
	var ue=UE.getEditor(nodeid, ueoption);
	return ue;
}


$(document).ready(function(){
    uemain = InitUE("qst-main");
	ueop1=InitUE("op1");
	ueop2=InitUE("op2");
	ueop3=InitUE("op3");
	ueop4=InitUE("op4");

	$("#qtypebool").click(function(){
		cqst.setbool();
	});
	$("#qtypeselect").click(function(){
		cqst.setselect();
	});
	
	$("#addchapter").click(function(){
		$("#addchapter").hide();
		$("#newchapter").show();
		$("#newchapname").val("");
	});
	
	$("#cancelnewchap").click(function(){
		$("#addchapter").show();
		$("#newchapter").hide();
	});
	$("#btnsave").click(function(){
		cqst.saveqst();
	});
	$("#btndelete").click(function(){
		cqst.deleteme();
	});
	$(".chapter-edit").click(function(event){
		event.stopPropagation();
	});
	chaplist=new ChapList();
	chaplist.refresh();
	$("#savenewchap").click(function(){
		chaplist.savenew();
	});

});
var app = angular.module('question', []);
app.controller('default', function($scope,$http,$sce) {
	$scope.winstyle={
		"max-height":window.innerHeight+"px",
		"overflow-y":"scroll"
	}
}
);