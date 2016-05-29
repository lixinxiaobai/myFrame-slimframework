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
                        <strong class="am-text-primary am-text-lg">章节列表</strong>
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
                                    <th>章节</th>
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
        
        <div class="am-modal am-modal-prompt" tabindex="-1" id="chapter_modal">
            <div class="am-modal-dialog">
                <div class="am-modal-hd am-margin-bottom">科目操作</div>
                <div class="am-modal-bd" style="border-bottom:none;">
                    <input type="hidden"  id="chapter_id" />
                    <form class="am-form  am-form-horizontal">
                    <div class="am-form-group">
                        <label  class="am-u-sm-4 am-form-label">章节</label>
                        <div class="am-u-sm-6 am-u-end"><input type="text" class="am-form-field" id="chapter_cid" /></div>
                    </div>
                    <div class="am-form-group">
                        <label  class="am-u-sm-4 am-form-label">名称</label>
                        <div class="am-u-sm-6 am-u-end"><input type="text" class="am-form-field" id="chapter_name"/></div>
                    </div>
                    </form>
                </div>
                <div class="am-btn-group am-btn-group-justify">
                    <a class="am-btn am-btn-default chapter_cancel" style="background: none;" role="button">取消</a>
                    <a class="am-btn am-btn-default chapter_submit" style="background: none;" role="button">提交</a>
                </div>
            </div>
        </div>
        
        
        <script id="list"  type="text/html">
            <%for(var i=0;i<list.length;i++){%>
            <tr>
                <td><%=list[i].cid%></td>
                <td><a href="question.php?course=<%=course%>&cid=<%=list[i].cid%>&subject=<%=list[i].subject%>"><%=list[i].title%></a></td>
                <td>
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group am-btn-group-xs">
                            <button class="am-btn am-btn-default am-btn-xs am-text-secondary" onclick="edit(<%=list[i].id%>)"><span class="am-icon-pencil-square-o"></span> 修改</button>
                            <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" onclick="del(<%=list[i].id%>)"><span class="am-icon-trash-o"></span> 删除</button>
                        </div>
                    </div>
                </td>
            </tr>
            <%}%>
        </script>
        <script>
        var course = '<?php echo @$_GET['course']?>';
        var subject = '<?php echo @$_GET['subject']?>';
        var chapter = $("#chapter_modal");
        $(".back").on("click",function(){
            location.href = "subject.php?course="+course;
        });
        $(".add").on("click",function(){
            $("#chapter_name").val("");
            $("#chapter_cid").val("");
            $("#chapter_id").val("");
            chapter.modal();
        });
        if(course==''||subject==''){
            messageAlert("参数错误");
        }else{
            request({method:"getChapter",subject:subject},function(d){
                var bt=baidu.template;
                var html=bt('list',{"list":d,"course":course});
                $(".list").html(html);
            });
        }
        function edit(id){
            request({method:"getChapter",id:id,subject:subject},function(data){
                d = data[0];
                if(!!d.error){
                    alert(d.error);
                }else{
                    $("#chapter_name").val(d.title);
                    $("#chapter_cid").val(d.cid);
                    $("#chapter_id").val(id);
                    chapter.modal();
                }
            },null,null,true);
        }
        
        function del(id){
            request({method:"delChapter",id:id,subject:subject},function(d){
                if(!!d.error){
                    messageAlert(d.error);
                }else{
                    alert("删除成功");
                    location.reload(true);
                }
            });
        }
        $(".chapter_cancel").on('click', function() {
            chapter.modal("close");
        });
        $(".chapter_submit").on('click', function() {
            var cid = $("#chapter_cid").val();
            var id = $("#chapter_id").val();
            var title = $("#chapter_name").val();
            if(title==''){
                alert("请输入名称");
            }else if(cid==''){
                alert("请输入章节号");
            }else{
                var m = {method: "addChapter", title: title,cid:cid,subject:subject};
                if(!!id){
                    m = {method: "editChapter", title: title,cid:cid,id:id,subject:subject};
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
