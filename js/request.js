$(document).ready(function() {
    $('#form input').blur(function()
    {
        if( $(this).val().length === 0 ) {
            $(this).parents('div').addClass('warning');
        }
        if( $(this).val().length > 0 ) {
            $(this).parents('div').removeClass('warning');
        }
    });

    $("#subscribe").on('click',function (e) {
        e.preventDefault();
        var email = $('#subscribe-form-email').val();

        if(email.length > 0){

            $.ajax({
                url: 'subscribe.php',
                dataType: 'json',
                type: 'post',
                contentType: 'application/json',
                processData: false,
                data: JSON.stringify({"email": email }),

                success: function( data, textStatus, jQxhr ){
                    console.log(data);
                    if(data.status == "success"){

                        $("#subscribe-form-email").val('');

                        alertify.set('notifier','position', 'top-right');
                        alertify.success('Ваша подписка успешно оформлена');
                    }
                    if(data.status == "fail"){
                        alertify.set('notifier','position', 'top-right');
                        alertify.warning(data.msg);
                    }

                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( textStatus, errorThrown );
                }
            });
        }

    });

    function jsUcfirst(string)
    {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    $('#visit-form-phone').mask('(000) 000-0000');


    $("#send_request").on('click',function (e) {
        e.preventDefault();
        var name = $('#visit-form-name').val();
        var phone = $('#visit-form-phone').val();

        if(name.length > 0 && phone.length >0){
            $.ajax({
                url: 'request.php',
                dataType: 'json',
                type: 'post',
                contentType: 'application/json',
                processData: false,
                data: JSON.stringify({ name: name, phone: phone }),

                success: function( data, textStatus, jQxhr ){
                    console.log(data);
                    if(data.status == "success"){

                        $('#visit-form-name').val('');
                        $('#visit-form-phone').val('');

                        alertify.set('notifier','position', 'top-right');
                        alertify.success(jsUcfirst(name) + ', ваша заявка на визит успешно оформлена');
                    }
                    if(data.status == "fail"){
                        alertify.set('notifier','position', 'top-right');
                        alertify.warning(data.msg);
                    }

                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( textStatus, errorThrown );
                }
            });
        }
    });
});