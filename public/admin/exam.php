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
            .am-table-compact{
                font-size: 14px;
            }
    .am-table td{
                table-layout:fixed; 
                word-break: break-all; 
                word-wrap: break-word;
            }    </style>
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
                        <strong class="am-text-primary am-text-lg">问题列表</strong>
                    </div><br/>
                    <hr/>
                </div>
                <div class="am-g">
                    <div class="am-u-sm-12">
                        <button type="button" class="am-btn am-btn-primary back">返回</button>
                        <button type="button" class="am-btn am-btn-primary add">新增</button>
                        <table class="am-table  am-table-compact am-table-bordered am-table-striped am-table-hover am-margin-top-sm">
                            <thead>
                                <tr>
                                    <th style="width:3%">题号</th>
                                    <th style="width:16%">问题</th>
                                    <th style="width:3%">类型</th>
                                    <th style="width:10%">选项A</th>
                                    <th style="width:10%">选项B</th>
                                    <th style="width:10%">选项C</th>
                                    <th style="width:10%">选项D</th>
                                    <th style="width:8%">正确答案</th>
                                    <th style="width:14%">解释</th>
                                    <th style="width:14%">操作</th>
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
            <%for(var i=0;i<list.length;i++){%>
            <tr>
                <td><%=list[i].number%></td>
                <td><%=list[i].content%></td>
                <td><%=list[i].typeTitle%></td>
                <td><%=list[i].answer1%></td>
                <td><%=list[i].answer2%></td>
                <td><%=list[i].answer3%></td>
                <td><%=list[i].answer4%></td>
                <td><%=list[i].right%></td>
                <td><%=list[i].explain%></td>
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
        var suit = '<?php echo @$_GET['suit']?>';
        var subject = '<?php echo @$_GET['subject']?>';
        var chapter = $("#chapter_modal");
        $(".back").on("click",function(){
            location.href = "suit_subject.php?subject="+subject+"&suit="+suit;
        });
        $(".add").on("click",function(){
            location.href = "exam_handle.php?subject="+subject+"&suit="+suit;
        });
        if(suit==''||subject==''){
            messageAlert("参数错误");
        }else{
            request({method:"getExam",subject:subject,suit:suit},function(d){
                var bt=baidu.template;
                bt.ESCAPE = false;
                var html=bt('list',{"list":d});
                $(".list").html(html);
            });
        }
        function edit(id){
            location.href = "exam_handle.php?subject="+subject+"&suit="+suit+"&id="+id;
        }
        
        function del(id){
            request({method:"delExam",id:id,subject:subject,suit:suit},function(d){
                alert("删除成功");
                location.reload(true);
            });
        }
        </script>    
    </body>
</html>
