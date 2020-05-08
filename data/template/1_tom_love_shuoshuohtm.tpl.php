<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<script>
;var vzan;
if (!vzan) vzan = {};
(function (v){
    var timeFlag = 0;
    v.bindReplySend = function () {
        $(document).on("click", "#send-reply-button", function () {
            var reSsId = $(this).attr('ssId');
            var reUid = $("#hidUserId").val();
            
            Today = new Date(); 
            var NowHour = Today.getHours(); 
            var NowMinute = Today.getMinutes(); 
            var NowSecond = Today.getSeconds(); 
            var mysec = (NowHour*3600)+(NowMinute*60)+NowSecond; 

            if(mysec-timeFlag>5){
                timeFlag = mysec;
                v.subReplycomment(reSsId, reUid);
            }
        })
    }
    v.bindReplyBtn = function (){
        $(document).on("click", "span[ArticleReplyBtn]", function () {
            var reSsid = $(this).attr('ssid');
            var reUid = $("#hidUserId").val();
            var reNickName = "话题";
            v.articlereply(reSsid,reUid,reNickName);
        })
    }
    v.articlereply = function (reSsid,reUid,reNickName) {
        try{
            if ($('#textbox-replay').length > 0) { $('#textbox-replay').remove(); }
            var reHtml = '<div id="textbox-replay" class="reply-box"> ' 
                        + '<form id="gaibai_form">' +
                        '<div><textarea id="txtContentAdd" name="txtContentAdd" placeholder="回复话题"></textarea></div>' +
                        '<div class="reply-button-box"><input Id="send-reply-button" value="发表" type="button"  class="send-button" style="margin-right:10px;border-radius: 4px;" /><input Id="cancel-reply-button" value="取消" type="button"  class="cancal-button" style="margin-right:10px;border-radius: 4px;" /></div>' +
                        '<input type="hidden" name="act" value="reply">' + 
                        '<input type="hidden" name="reSsid" value="' + reSsid + '">' + 
                        '<input type="hidden" name="reUid" value="' + reUid + '">' + 
                        '<input type="hidden" name="formhash" value="<?php echo $formhash;?>">' + 
                        '</form>' +
                        '</div>';
            $('#shuoshuo-' + reSsid).append(reHtml);
            $(".gotop").hide(); 
            $("#send-reply-button").attr("ssId", reSsid);
            $('#textbox-replay').show();
            $('#navbuttom').hide();
            if (reNickName != "") {
                $("#txtContentAdd").attr("placeholder", "回复" + reNickName + ":");
            }
            $("#txtContentAdd").click().focus();
        }catch (e){
            alert(e.message);
        }
    }

    var submintStatus = 0;
    v.subReplycomment = function (reSsId,reUid) {
        var content = $("#txtContentAdd").val().trim();
        var picture = $("#hidUserPic").val().trim();
        var nickname = $("#hidName").val().trim();
        
        if (content.length  <= 2) {
            tusi("亲，内容太少啦");
            return;
        }
        
        <?php if($jyConfig['open_must_tel_renzheng'] == 1 && $__UserInfo['phone_renzheng'] != 1) { ?>
        $('#must_phone').show();
        return false;
        <?php } ?>
    
        if(submintStatus == 1){
            return;
        }
        submintStatus = 1;
        $.ajax({
            type: "GET",
            url: "<?php echo $shuoshuoUrl;?>",
            data: $('#gaibai_form').serialize(),
            success: function(msg){
                submintStatus = 0;
                tusi("亲,发布成功");
                var comtHtml = '<li class="in rel artcomment">' +
                                '<dl class="clearfix">' +
                                    '<dt>' +
                                        '<img class="shuoshuo_avatar" src=' + picture + ' width="30px" height="30px">' +
                                    '</dt>' +
                                    '<dd>' +
                                        '<label class="f13">' + nickname + ' <span class="fr c858 f12">刚刚</span></label>' +
                                        '<p>' + content + '</p>' +
                                    '</dd>' +
                                '</dl>' +
                            '</li>';

                var commentCount = parseInt($("#replyCount-" + reSsId).text()) + 1;
                $("#replyCount-" + reSsId).text(commentCount);
                $("#replay-temp-" + reSsId).prepend(comtHtml);
                //$("#shuoshuo-" + reSsId).append(comtHtml);
                //location.href = "#shuoshuo-" + reSsId;  
                $('#textbox-replay').hide();
                $('#navbuttom').show();
                $(".gotop").show();
            }
        });
    }
    
})(vzan);

$(document).ready(function () {
    vzan.bindReplyBtn();
    vzan.bindReplySend();
    $(document).on("click", "#cancel-reply-button", function () {
        $("#textbox-replay").remove();
        $('#navbuttom').show();
        $(".gotop").show();
    })
})

function praise(reSsid) {
    var reUid = $("#hidUserId").val();
    $.ajax({
        type: "GET",
        url: "<?php echo $shuoshuoUrl;?>",
        data: { act:"zan",reSsid:reSsid,reUid:reUid,formhash:"<?php echo $formhash;?>"},
        dataType:"JSON",
        success: function (data) {
        }
    });

    $('#btn-zan' + reSsid).removeAttr("onclick");
    $('#btn-zan' + reSsid + ' i').attr("class", "zaned");
    var commentCount = parseInt($("#zanCount-" + reSsid).text()) + 1;
    $("#zanCount-" + reSsid).text(commentCount);

}

function deleteShuoshuo(reSsid) {

    $.ajax({
        type: "GET",
        url: "<?php echo $shuoshuoUrl;?>",
        data: { act:"del_shuoshuo",reSsid:reSsid,formhash:"<?php echo $formhash;?>"},
        dataType:"JSON",
        success: function (data) {
            tusi("亲，删除话题成功！");
            $('#shuoshuo-' + reSsid ).remove();
        }
    });
}

function deleteReply(replyId) {

    $.ajax({
        type: "GET",
        url: "<?php echo $shuoshuoUrl;?>",
        data: { act:"del_reply",replyId:replyId,formhash:"<?php echo $formhash;?>"},
        dataType:"JSON",
        success: function (data) {
            tusi("亲，删除评论成功！");
            $('#reply-' + replyId ).remove();
        }
    });
}
</script>