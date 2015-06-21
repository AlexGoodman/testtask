/**
 * Created by Alexandr on 23.05.2015.
 */

$(document).ready(function () {


    function checkPhone(phone){
        if(!/\+38\(0\d{2,2}\)\d{7,7}/.test(phone)){
            $('#msg-info').html('<div class="alert alert-warning" role="alert">Wrong number</div>');
            return true;
        }
    }

    function checkVcode(vcode){
        if(!/\d{2,2}\-\d{2,2}\-\d{2,2}\-\d{2,2}/.test(vcode)){
            $('#msg-info').html('<div class="alert alert-warning" role="alert">Wrong verification code</div>');
            return true;
        }
    }


    function formPost(url, data){
        $.post(url, data, function (msg) {
            if (msg['success']) {
                $('#msg-info').html('<div class="alert alert-success">' + msg['success'] + '</div>');
            }
            else {
                $('#msg-info').html('<div class="alert alert-danger">' + msg['error'] + '</div>');
            }
        }, 'json');
    }


    $("#input-phone-number").inputmask("+38(099)9999999");
    $("#input-vcode").inputmask("99-99-99-99");


    // Send verification code by sms
    $('#button-send-vcode').on('click', function(){
        $('.form-msg').html('');
        var phone = $('#input-phone-number').val();
        if(!checkPhone(phone)){
            var url = '/web/index.php/test/sms';
            var data = {'phone': phone};
            formPost(url, data);
        }
    });


    // Verify phone number via verification code
    $('#button-verify-phone').on('click', function(){
        $('.form-msg').html('');
        var phone = $('#input-phone-number').val();
        var vcode= $('#input-vcode').val();
        if(!checkPhone(phone) && !checkVcode(vcode)){
            var url = '/web/index.php/test/vphone';
            var data = {'phone': phone, 'vcode': vcode};
            formPost(url, data);
        }
    });


});