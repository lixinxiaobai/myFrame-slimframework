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
            .input-inline{
                float: left;
                margin-right: 8px;
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
            <div class="admin-content">
                <div class="am-cf am-padding-top am-padding-left">
                    <div class="am-fl am-cf">
                        <strong class="am-text-primary am-text-lg">问题页面</strong>
                    </div><br/>
                    <hr/>
                    <button type="button" class="am-btn am-btn-primary back">返回</button>
                </div>

                <div class="am-tabs am-margin" id="add_tabs" data-am-tabs="{noSwipe: 1}">
                    <ul class="am-tabs-nav am-nav am-nav-tabs">
                        <li class="am-active"><a href="#tab1">题目</a></li>
                    </ul>

                    <div class="am-tabs-bd">
                        <div class="am-tab-panel am-fade am-active am-in" id="tab1">
                            <form class="am-form"  id="q_form" >
                                
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <script id="from_t" type="text/html">
                <div class="am-g am-margin-top-sm am-form-group">
                    <div class="am-u-md-2 am-text-right">请选择类型</div>
                    <div class="am-u-md-6 am-u-end">
                        <select  name="type" id="q_type" required>
                            <option value="">请选择</option>
                            <option value="0" <%if(type==0){%> selected="selected" <%}%> >单项选择题</option>
                            <option value="1" <%if(type==1){%> selected="selected" <%}%> >多项选择题</option>
                            <option value="2" <%if(type==2){%> selected="selected" <%}%> >判断题</option>
                        </select>
                    </div>
                    
                    
                </div>
                <div class="am-g am-margin-top-sm am-form-group">
                    <div class=" am-u-md-2 am-text-right">
                        题号
                    </div>
                    <div class=" am-u-md-6 am-u-end">
                        <input type="number" class="am-input-sm" id="q_num" name="number" value="<%=number%>" required/>
                    </div>
                </div>
                <div class="am-g am-margin-top-sm am-form-group">
                    <div class="am-u-md-2 am-text-right admin-form-text">
                        题目
                    </div>
                    <div class="am-form am-u-md-6 am-u-end">
                        <textarea rows="8" class="am-input-sm" name="content" id="q_content" required><%=content%></textarea>
                    </div>
                </div>
                <div class="am-g am-margin-top-sm am-form-group">
                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                        选项A
                    </div>
                    <div class="am-u-sm-8 am-u-md-6 am-u-end">
                        <input type="text" class="am-input-sm" id="q_answ1" name="answer1" value="<%=answer1%>" required/>
                    </div>
                </div>
                    <div class="am-g am-margin-top-sm am-form-group">
                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                        选项B
                    </div>
                    <div class="am-u-sm-8 am-u-md-6 am-u-end">
                        <input type="text" class="am-input-sm" id="q_answ2" name="answer2" value="<%=answer2%>" required/>
                    </div>
                </div>
                    <div class="am-g am-margin-top-sm am-form-group">
                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                        选项C
                    </div>
                    <div class="am-u-sm-8 am-u-md-6 am-u-end">
                        <input type="text" class="am-input-sm" id="q_answ3" name="answer3" value="<%=answer3%>" required/>
                    </div>
                </div>
                    <div class="am-g am-margin-top-sm am-form-group">
                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                        选项D
                    </div>
                    <div class="am-u-sm-8 am-u-md-6 am-u-end">
                        <input type="text" class="am-input-sm" id="q_answ4" name="answer4" value="<%=answer4%>" required/>
                    </div>
                </div>
                <div class="am-g am-margin-top-sm am-form-group">
                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                        答案
                    </div>
                    <div class="am-u-sm-8 am-u-md-6 am-u-end">
                        <input type="text" class="am-input-sm" id="q_right" name="right" value="<%=right%>" required/>
                    </div>
                </div>
                <div class="am-g am-margin-top-sm am-form-group">
                    <div class="am-u-sm-4 am-u-md-2 am-text-right">
                        解释
                    </div>
                    <div class="am-u-sm-8 am-u-md-6 am-u-end">
                        <textarea rows="8" id="q_exp" class="am-input-sm" name="explain" required><%=explain%></textarea>
                    </div>
                </div>
                <div class="am-margin">
                    <input type="submit" class="am-btn am-btn-primary" value="提交保存"/>
                </div>
        </script>
        
        <script>
            var course = '<?php echo @$_GET['course']?>';
            var cid = '<?php echo @$_GET['cid']?>';
            var subject = '<?php echo @$_GET['subject']?>';
            var id = '<?php echo @$_GET['id']?>';
            $(".back").on("click",function(){
                location.href = "question.php?subject="+subject+"&course="+course+"&cid="+cid;
            });
            if(cid==''||subject==''){
                messageAlert("参数错误");
            }else{
                if(id!=''){
                    request({method:"getQuestion",subject:subject,cid:cid,id:id},function(d){
                        var bt=baidu.template;
                        var html=bt('from_t',d[0]);
                        $("#q_form").html(html);
                        addValid();
                    });
                }else{
                    var bt=baidu.template;
                    var html=bt('from_t',{"number":"","content":"","type":"-1","answer1":"","answer2":"","answer3":"","answer4":"","right":"","explain":""});
                    $("#q_form").html(html);
                    addValid();
                }
                $(document).on("change","#q_type",function(){
                    if($(this).val()==2){
                        $("#q_answ1,#q_answ2,#q_answ3,#q_answ4").removeAttr("required");
                    }else{
                        $("#q_answ1,#q_answ2,#q_answ3,#q_answ4").attr("required","required");
                    }
                });
            }
function addValid(){
    $('#q_form').validator({
        validateOnSubmit: true,
    onValid: function(validity) {
      $(validity.field).closest('.am-u-end').find('.am-alert').hide();
    },
    onInValid: function(validity) {
      var $field = $(validity.field);
      var $group = $field.closest('.am-u-end');
      var $alert = $group.find('.am-alert');
      var msg = $field.data('validationMessage') || this.getValidationMessage(validity);

      if (!$alert.length) {
        $alert = $('<div class="am-alert am-alert-danger"></div>').hide().
          appendTo($group);
      }
      $alert.html(msg).show();
    },
    submit:function(e){
        if(this.isFormValid()){
            var p = {};
            if(id!=''){
                p = {method:"editQuestion",id:id,subject:subject,cid:cid};
            }else{
                p = {method:"addQuestion",subject:subject,cid:cid};
            }
            $.each($('#q_form').serializeArray(),function(i,v){
                p[v.name] = v.value;
            })
            request(p,function(data){
                messageAlert("保存成功");
                setTimeout(function(){location.reload(true);},500);
            });
        }
        return false;
    }
  });
      }
          </script>  
    </body>
</html>
