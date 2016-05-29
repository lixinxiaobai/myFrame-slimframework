<?php
require_once '../lib/main.php';
if (!isAdminLogin()) {
    header("location: login.html");
}
?>
<!doctype html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>系统管理</title>
        <meta name="keywords" content="index">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="renderer" content="webkit">
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <link rel="stylesheet" href="../assets/css/amazeui.min.css"/>
        <link rel="stylesheet" href="../assets/css/admin.css">
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/amazeui.min.js"></script>
        <script src="../assets/js/baiduTemplate.js"></script>
        <script src="../assets/js/app.js"></script>
        <style>
            .qr{
                height: 200px;
                text-align: center;
            }
            .table-title{
                width:40%;
            }
        </style>
    </head>
    <body>
        <!--[if lte IE 9]>
        <p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，不支持浏览。 请 升级浏览器
          以获得更好的体验！</p>
        <![endif]-->
        <header class="am-topbar admin-header">
            <div class="am-topbar-brand">
                <strong>系统后台管理</strong>
            </div>
            <div class="am-collapse am-topbar-collapse" id="topbar-collapse">
                <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
                    <li>
                        <a href="javascript:;">
                            <span class="am-icon-users"></span> <?php echo $_SESSION['admin']['ad_name']; ?>
                        </a>
                    </li>
                    <li><a href="javascript:;" id="logout"><span class="am-icon-power-off"></span> 退出</a></li>
                </ul>
            </div>
        </header>

        <div class="am-cf admin-main">
            <?php require_once 'menu.html'; ?> 
            <div class="admin-content ">
                <div class="am-cf am-padding-top am-padding-left">
                    <div class="am-fl am-cf">
                        <strong class="am-text-primary am-text-lg">选项列表</strong>
                    </div><br/>
                    <hr/>
                </div>
                <div class="am-g">
                    <div class="am-u-sm-12">
                        <button type="button" class="am-btn am-btn-primary back">返回</button>
                        <button type="button" class="am-btn am-btn-primary add">新增</button>
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                                <tr>
                                    <th>题号</th>
                                    <th>借贷</th>
                                    <th>会计科目</th>
                                    <th>金额</th>
                                    <th class="table-set">操作</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                
                            </tbody>   
                        </table>
                        <hr id="pos"/>
                    </div>

                </div>
            </div>
        </div>
        
        <script id="list"  type="text/html">
            <%for(var i=0;i<list.length;i++){ %>
            <tr class="am-form">
                <td><input type="text" name="number" value="<%=list[i].number%>" /></td>
                <td><select name="answer1"> 
                        <option value="借" <%if(list[i].answer1=='借'){%> selected="selected" <%}%> >借</option>
                        <option value="贷" <%if(list[i].answer1=='贷'){%> selected="selected" <%}%> >贷</option>
                    </select></td>
                <td><select name="answer2"><% var k=0;var op = new Array(); for(var j=0;j< list[i].opts.length;j++){ 
                        var opt = list[i].opts[j];
                        if(opt.parentId=='0'){
                             if(k==0){
                             op[opt.id] = ['<optgroup label="'+opt.title+'">'];
                             }else{
                             op[opt.id] = ['</optgroup><optgroup label="'+opt.title+'">'];
                             }
                        }else{
                            if(opt.title==list[i].answer2){
                            op[opt.parentId].push('<option value="'+opt.title+'" selected="selected">'+opt.title+'</option>');
                            }else{
                            op[opt.parentId].push('<option value="'+opt.title+'">'+opt.title+'</option>');
                            }
                        }
                        k++;
                        } 
                        var htm = "";
                        for(var n=1;n<=5;n++){
                            htm += op[n].join("");
                        }
                        %><%:=htm%></select></td>
                <td><input type="text" name="right" value="<%=list[i].right%>" /></td>
                <td>
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group">
                            <%if(!!list[i].id){%>
                            <button class="am-btn am-btn-default am-text-secondary" onclick="edit(<%=list[i].id%>,this)"><span class="am-icon-pencil-square-o"></span> 确定修改</button>
                            <button class="am-btn am-btn-default am-text-danger am-hide-sm-only" onclick="del(<%=list[i].id%>)"><span class="am-icon-trash-o"></span> 删除</button>
                            <%}else{%>
                            <button class="am-btn am-btn-default am-text-secondary" onclick="add(this)"><span class="am-icon-plus-square-o"></span> 确定增加</button>
                            <%}%>
                        </div>
                    </div>
                </td>
            </tr>
            <%}%>
        </script>
        <script>
        var suit = '<?php echo @$_GET['suit']?>';
        var subject = '<?php echo @$_GET['subject']?>';
        var num = '<?php echo @$_GET['num']?>';
        var opts = [];
        if(suit==''||subject==''||num==''){
            messageAlert("参数错误");
        }else{
            $(".back").on("click",function(){
                location.href = "exam.php?suit="+suit+"&subject="+subject;
            });
            $(".add").on("click",function(){
                var list = [{"number":"","answer1":"","answer2":"","right":"","opts":opts}];
                var bt=baidu.template;
                bt.ESCAPE = false;
                var html=bt('list',{"list":list});
                $(".list").append(html);
                location.href = "#pos";
            });
            request({method:"getExam",qt:0,subject:subject,suit:suit,num:num},function(d){
                if(!!d.error){
                    messageAlert(d.error);
                    opts = d.opts;
                    return;
                }
                opts = d[0].opts;
                var bt=baidu.template;
                var html=bt('list',{"list":d});
                $(".list").html(html);
            },null,null,true);
        }
        
        function add(ele){
            var tr = $(ele).parents("tr");
            var number = tr.find("input[name='number']").val();
            var answer1 = tr.find("select[name='answer1']").val();
            var answer2 = tr.find("select[name='answer2']").val();
            var right = tr.find("input[name='right']").val();
            console.log(answer1,answer2);
            request({method:"examp1",number:number,answer1:answer1,answer2:answer2,right:right,subject:subject,suit:suit,parent:num},function(d){
                messageAlert("操作成功",function(){location.reload(true);});
            });
        }
        
        function edit(id,ele){
            var tr = $(ele).parents("tr");
            var number = tr.find("input[name='number']").val();
            var answer1 = tr.find("input[name='answer1']").val();
            var answer2 = tr.find("input[name='answer2']").val();
            var right = tr.find("input[name='right']").val();
            request({method:"examp1",id:id,number:number,answer1:answer1,answer2:answer2,right:right,subject:subject,suit:suit,parent:num},function(d){
                messageAlert("操作成功",function(){location.reload(true);});
            });
        }
        
        function del(id){
            request({method:"examp1",id:id,subject:subject,suit:suit,parent:num,type:"del"},function(d){
                messageAlert("删除成功",function(){location.reload(true);});
            });
        }
        </script>    
    </body>
</html>
