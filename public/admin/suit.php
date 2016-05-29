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
                <strong>试题管理</strong>
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
                        <strong class="am-text-primary am-text-lg">试题列表</strong>
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
        
        
         <div class="am-modal am-modal-prompt" tabindex="-1" id="suit_modal">
        <div class="am-modal-dialog">
            <div class="am-modal-hd">试题操作</div>
            <div class="am-modal-bd" style="border-bottom:none;">
                请输入试题名称
                <input type="hidden" value="" id="suit_id" />
                <input type="text" class="am-modal-prompt-input" id="suit_title"/>
            </div>
            <div class="am-modal-footer">
                <span class="am-modal-btn" data-am-modal-cancel>取消</span>
                <span class="am-modal-btn" data-am-modal-confirm>提交</span>
              </div>
        </div>
    </div>
        
        <script id="list"  type="text/html">
            <%for(var i=0;i<list.length;i++){%>
            <tr>
                <td><%=list[i].id%></td>
                <td><a href="suit_subject.php?suit=<%=list[i].id%>"><%=list[i].title%></a></td>
                <td>
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group am-btn-group-xs">
                            <button class="am-btn am-btn-default am-btn-xs am-text-secondary" onclick="edit(<%=list[i].id%>,'<%=list[i].title%>')"><span class="am-icon-pencil-square-o"></span> 修改</button>
                            <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" onclick="del(<%=list[i].id%>)"><span class="am-icon-trash-o"></span> 删除</button>
                        </div>
                    </div>
                </td>
            </tr>
            <%}%>
        </script>
        <script>
        $(".back").on("click",function(){
            location.href = "index.php?id=2";
        });
        request({method:"getSuit"},function(d){
            var bt=baidu.template;
            var html=bt('list',{"list":d});
            $(".list").html(html);
        });
        
        $(".add").on("click",function(){
            $("#suit_title").val("");
            $('#suit_modal').modal({
                relatedTarget: this,
                onConfirm: function(e) {
                    if(!!e.data&&$.trim(e.data)!=''){
                        request({method:"addSuit","title":e.data},function(d){
                            messageAlert("添加成功",function(){location.reload(true);});
                        });
                    }else{
                        messageAlert("请输入名称");
                    }
                }
            });
        });
        
        function edit(id,title){
            $("#suit_title").val(title);
            $('#suit_modal').modal({
                relatedTarget: this,
                onConfirm: function(e) {
                    if(!!e.data&&$.trim(e.data)!=''){
                        request({method:"editSuit",id:id,"title":e.data},function(d){
                            messageAlert("更新成功",function(){location.reload(true);});
                        });
                    }else{
                        messageAlert("请输入名称");
                    }
                }
            });
        }
        
        function del(id){
            request({method:"delSuit",id:id},function(d){
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
