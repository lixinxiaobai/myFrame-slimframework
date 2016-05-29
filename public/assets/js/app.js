function request(params, success, url, type, err) {
    if (!!!url) {
        url = "request.php";
    }
    if (!!!type) {
        type = "post";
    }
    $.ajax({
        url: url,
        type: type,
        data: params,
        dataType: 'json',
        success: function (data) {
            if (!!err) {
                success(data);
            } else {
                responseJson(data, success);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            messageAlert("请检查您的网络");
            if(typeof err == 'function'){
                err();
            }
        }
    });
}

function responseJson(data, func) {
    if (!!data.error) {
        if(data.error=='-1'){
            messageAlert("您已掉线，请重新登录",function(){location.href = 'login.html';});
        }else if(data.error=='-2'){
            messageAlert("您的信息已提交，请等待管理员审核");
        }else{
            messageAlert(data.error);
        }
    } else {
        func(data);
    }
}

var alertModal = '<div class="am-modal am-modal-alert" tabindex="-1" id="alert_modal"><div class="am-modal-dialog">\
<div class="am-modal-hd">信息提示</div><div class="am-modal-bd" id="alert_content">\
</div><div class="am-modal-footer"><span class="am-modal-btn sys-alert">确定</span></div></div></div>';
var $modal = $(alertModal);
var $modalIn = false;

function messageAlert(msg, fn) {
    if (!$modalIn) {
        $("body").append($modal);
        $modalIn = true;
    }
    if (!!fn) {
        $modal.modal({closeViaDimmer: 0});
        $(".sys-alert").on("click", fn);
    } else {
        $modal.modal({closeViaDimmer: 1});
        $(".sys-alert").off("click");
        $(".sys-alert").on("click", function () {
            $modal.modal('close');
        });
    }
    $("#alert_content").html(msg);
    $modal.modal('open');
}

$(".logout").on("click", function () {
    request({method: "logout"}, function (d) {
        location.href = "login.html";
    });
});