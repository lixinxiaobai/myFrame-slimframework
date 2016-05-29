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
                        <strong class="am-text-primary am-text-lg">科目列表</strong>
                    </div><br/>
                    <hr/>
                </div>
                <div class="am-g">
                    <div class="am-u-sm-12">
                        <button type="button" class="am-btn am-btn-primary back">返回</button>
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>名称</th>
                                    <!--<th class="table-set">操作</th>-->
                                </tr>
                            </thead>
                            <tbody class="list">
                                
                            </tbody>   
                        </table>
                        <hr />
                    </div>

                </div>
            </div>
        </div>
        
        <div class="am-modal am-modal-prompt" tabindex="-1" id="subject_modal">
            <div class="am-modal-dialog">
                <div class="am-modal-hd">科目操作</div>
                <div class="am-modal-bd" style="border-bottom:none;">
                    请输入科目名称
                    <input type="hidden" value="" id="subject_id" />
                    <input type="text" class="am-modal-prompt-input" id="subject_name"/>
                </div>
                <div class="am-btn-group am-btn-group-justify">
                    <a class="am-btn am-btn-default subject_cancel" style="background: none;" role="button">取消</a>
                    <a class="am-btn am-btn-default subject_submit" style="background: none;" role="button">提交</a>
                </div>
            </div>
        </div>
        
        
        <script id="list"  type="text/html">
            <%for(var i=0;i<list.length;i++){%>
            <tr>
                <td><%=list[i].id%></td>
                <td><a href="exam.php?suit=<%=suit%>&subject=<%=list[i].id%>"><%=list[i].title%></a></td>
                <td>
                    <!--
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group am-btn-group-xs">
                            <button class="am-btn am-btn-default am-btn-xs am-text-secondary" onclick="edit(<%=list[i].id%>)"><span class="am-icon-pencil-square-o"></span> 修改</button>
                            <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" onclick="del(<%=list[i].id%>)"><span class="am-icon-trash-o"></span> 删除</button>
                        </div>
                    </div>
                    -->
                </td>
            </tr>
            <%}%>
        </script>
        <script>
        var suit = '<?php echo @$_GET['suit']?>';
        var subject = $("#subject_modal");
        $(".back").on("click",function(){
            location.href = "suit.php";
        });
        if(suit==''){
            messageAlert("参数错误");
        }else{
            request({method:"getSubject",course:1},function(d){
                var bt=baidu.template;
                var html=bt('list',{"list":d,"suit":suit});
                $(".list").html(html);
            });
        }
        function edit(id){
            request({method:"getSubject",id:id,course:course},function(data){
                d = data[0];
                if(!!d.error){
                    alert(d.error);
                }else{
                    $("#subject_name").val(d.title);
                    $("#subject_id").val(d.id);
                    subject.modal();
                }
            },null,null,true);
        }
        
        function del(id){
            request({method:"delSubject",id:id,course:course},function(d){
                if(!!d.error){
                    messageAlert(d.error);
                }else{
                    alert("删除成功");
                    location.reload(true);
                }
            });
        }
        $(".subject_cancel").on('click', function() {
            subject.modal("close");
        });
        $(".subject_submit").on('click', function() {
            var id = $("#subject_id").val();
            var title = $("#subject_name").val();
            if(title==''){
                alert("请输入名称");
            }else{
                var m = {method: "addSubject", title: title,course:course};
                if(!!id){
                    m = {method: "editSubject", title: title,id:id,course:course};
                }
                request(m , function(data) {
                    if (!!data.error) {
                        alert(data.error);
                    } else {
                        if(!!id){
                            alert("修改成功");
                        }else{
                            alert("新增成功");
                        }
                        location.reload(true);
                    }
                },null,null,true);
            }
        });
        </script>    
    </body>
</html>
