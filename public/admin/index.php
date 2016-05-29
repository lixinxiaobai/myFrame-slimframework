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
            <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>
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
                        <strong class="am-text-primary am-text-lg">课程列表</strong>
                    </div><br/>
                    <hr/>
                </div>
                <div class="am-g">
                    <div class="am-u-sm-12">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>名称</th>
                                    <th class="table-set">操作</th>
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
        <script id="list"  type="text/html">
            <%for(var i=0;i<list.length;i++){ %>
            <tr>
                <td><%=list[i].id%></td>
                <td><a href="<%if(list[i].id==1){%>subject.php?course=<%=list[i].id%> <%}else{%>suit.php<%}%>"><%=list[i].title%></a></td>
                <td>
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group am-btn-group-xs">
                            <button class="am-btn am-btn-default am-btn-xs am-text-secondary" onclick="edit(<%=list[i].id%>)"><span class="am-icon-pencil-square-o"></span> 修改</button>
                            <!--<button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" onclick="del(<%=list[i].id%>)"><span class="am-icon-trash-o"></span> 删除</button>-->
                        </div>
                    </div>
                </td>
            </tr>
            <% }%>
        </script>
        <script>
        var id= '<?php echo isset($_GET['id'])?$_GET['id']:"1"; ?>';
        request({method:"getCourse",id:id},function(d){
            var bt=baidu.template;
            var html=bt('list',{"list":d});
            $(".list").html(html);
        });
        
        function edit(id){
            request({method:"getCourse",id:id},function(data){
                d = data[0];
                if(!!d.error){
                    alert(d.error);
                }else{
                    $("#project_id").val(d.id);
                    $("#project_name").val(d.title);
                    $('#add_project_modal').modal("open");
                }
            },null,null,true);
        }
        
        function del(id){
            request({method:"delCourse",id:id},function(d){
                if(!!d.error){
                    messageAlert(d.error);
                }else{
                    alert("删除成功");
                    location.reload(true);
                }
            });
        }
        </script>    
    </body>
</html>
