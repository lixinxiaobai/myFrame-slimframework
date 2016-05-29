<?php
require_once '../lib/main.php';
if (!isAdminLogin()) {
    header("location: login.html");
}
$s = parse_ini_file('../reg.txt');
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
            .status{
                font-weight:bold;
                color:red;
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
                        <strong class="am-text-primary am-text-lg">用户列表</strong>
                    </div><br/>
                    <hr/>
                </div>
                <div class="am-g">
                    <div class="am-u-sm-12">
                        <div class="am-g">
                            <div class="am-u-sm-1">
                            <button type="button" class="am-btn am-btn-primary add">新增</button>
                            </div>
                            <div class="am-u-sm-8 am-u-end">
                            <form class="am-form-inline" role="form">
                                <div class="am-form-group">
                                    <input type="text" name="key" class="am-form-field" placeholder="关键字">
                                </div>
                                <button class="am-btn am-btn-default search">搜索</button>
                            </form>
                            </div>
                        </div>
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>账号</th>
                                    <th>备注</th>
                                    <th>状态</th>
                                    <th class="table-set">操作</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                               
                            </tbody>   
                        </table>
<form class="am-form-inline" role="form">
  <button class="am-btn am-btn-secondary prev">上一页</button>
  <div class="am-form-group">
    <input type="number" class="am-form-field" placeholder="页码" value="1" name="page"/> <button class="am-btn am-btn-secondary go">跳转</button> 
  </div>
 <button class="am-btn am-btn-secondary next">下一页</button> 
</form>
                        <hr />
                    </div>

                </div>
            </div>
        </div>
        
        <div class="am-modal am-modal-prompt" tabindex="-1" id="user_modal">
            <div class="am-modal-dialog">
                <div class="am-modal-hd">用户操作</div>
                <div class="am-modal-bd" style="border-bottom:none;">
                    <input type="hidden"  id="user_id" />
                    <form class="am-form  am-form-horizontal">
                    <div class="am-form-group">
                        <label  class="am-u-sm-4 am-form-label">账号</label>
                        <div class="am-u-sm-6 am-u-end"><input type="text" class="am-form-field" id="user_account" /></div>
                    </div>
                    <div class="am-form-group">
                        <label  class="am-u-sm-4 am-form-label"><?php echo @$s['field_1'];?></label>
                        <div class="am-u-sm-6 am-u-end"><input type="text"  class="am-form-field" id="user_name" /></div>
                    </div>
                    <div class="am-form-group">
                        <label  class="am-u-sm-4 am-form-label"><?php echo @$s['field_2'];?></label>
                        <div class="am-u-sm-6 am-u-end"><input type="text"  class="am-form-field" id="user_mobile"/></div>
                    </div>
                    </form>
                </div>
                <div class="am-btn-group am-btn-group-justify">
                    <a class="am-btn am-btn-default user_cancel" style="background: none;" role="button">取消</a>
                    <a class="am-btn am-btn-default user_submit" style="background: none;" role="button">提交</a>
                </div>
            </div>
        </div>
        
        
        <div class="am-modal am-modal-prompt" tabindex="-1" id="status_modal">
            <div class="am-modal-dialog">
                <div class="am-modal-hd">更改状态</div>
                <div class="am-modal-bd" style="border-bottom:none;">
                    当前用户账号状态是：<span class="status"></span> ，您确定更改当前状态吗？
                </div>
                <div class="am-btn-group am-btn-group-justify">
                    <a class="am-btn am-btn-default status-cancel" style="background: none;" data-am-modal-cancel>取消</a>
                    <a class="am-btn am-btn-default status-ok" style="background: none;">提交</a>
                </div>
            </div>
        </div>
        
        
        <script id="list"  type="text/html">
            <%for(var i=0;i<list.length;i++){%>
            <tr>
                <td><%=list[i].id%></td>
                <td><%=list[i].name%></td>
                <td><%if(list[i].remark!=null){%>
                    <%=list[i].remark%>
                    <%}%>
                </td>
                <td><%=list[i].statusText%></td>
                <td>
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group am-btn-group-xs">
                            <button class="am-btn am-btn-default am-btn-xs am-text-secondary" onclick="check(<%=list[i].id%>,'<%=list[i].statusText%>')"><i class="am-icon-check-square-o"></i> 审核</button>
                            <button class="am-btn am-btn-default am-btn-xs am-text-secondary" onclick="edit(<%=list[i].id%>)"><span class="am-icon-pencil-square-o"></span> 修改</button>
                            <button class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only" onclick="del(<%=list[i].id%>)"><span class="am-icon-trash-o"></span> 删除</button>
                        </div>
                    </div>
                </td>
            </tr>
            <%}%>
        </script>
        <script>
        var user = $("#user_modal"),page = 1;
        var data = [];
        var key = "";
        getUser();
        $(".add").on("click",function(){
            $("#user_name").val("");
            $("#user_id").val("");
            $("#user_account").val("");
            $("#user_mobile").val("");
            user.modal();
        });
        $(".prev").on("click",function(){
                if(page>1){
                        page--;
                }else{
                        alert("已经是第一页");
                        return false;
                }
                getUser();
                return false;
        });
        $(".next").on("click",function(){
                page++;
                getUser();
                return false;
        });
        $(".go").on("click",function(){
                var page = $("input[name='page']").val();
                if(/^[0-9]+$/.test(page)){
                        getUser(page);
                }else{
                        alert("请输入正确的页码");
                        return false;
                }
                return false;
        });
        function getUser(p){
            if(!!p) page = p;
            request({method:"getUser","page":page,"key":key},function(d){
                    data = d;
                    if(d.length>0){
                            var bt=baidu.template;
                            var html=bt('list',{"list":d});
                            $(".list").html(html);
                    }else{
                        if(page==1){
                            alert("没有数据");
                        }else{
                            alert("已经是最后一页");
                            if(page>1) page--;
                        }
                    }
            });
        }
        function edit(id){
            $.each(data,function(i,v){
               if(v.id==id){
                    if(!!v.remark){
                        var info = v.remark.split(",");
                        $("#user_name").val(info[0]);
                        $("#user_mobile").val(info[1]);
                    }else{
                        $("#user_name").val("");
                        $("#user_mobile").val("");
                    }
                    $("#user_id").val(v.id);
                    $("#user_account").val(v.name);
                    user.modal();
                    return false;
               } 
            });
            
        }
        
        function del(id){
            request({method:"delUser",id:id},function(d){
                alert("删除成功");
                location.reload(true);
            });
        }
        $(".user_cancel").on('click', function() {
            user.modal("close");
        });
        $(".user_submit").on('click', function() {
            var id = $("#user_id").val();
            var name = $("#user_name").val();
            var mobile = $("#user_mobile").val();
            var account = $("#user_account").val();
            if(account==''){
                alert("账号不能为空");
            }else{
                user.modal("close");
                var m = {method: "addUser", name: name,account:account,mobile:mobile};
                if(!!id){
                    m = {method: "editUser", name: name,account:account,mobile:mobile,id:id};
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
        var uid = 0;
        $(".status-ok").on("click",function(){
             $("#status_modal").modal('close');
              request({method:"changeUserStatus",id:uid},function(d){
                alert("更新成功");
                location.reload(true);
            });
        });
        $(".status-cancel").on("click",function(){
            $("#status_modal").modal('close');
        });
        
        function check(id,text){
            $(".status").html(text);
            $("#status_modal").modal('open');
            uid = id;
        }
        $(".search").on("click",function(){
            var k = $("input[name='key']").val();
            key = k;
            getUser();
            return false;
        });
        </script>    
    </body>
</html>
