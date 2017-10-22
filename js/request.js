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
                data: {"email": email },
                // processData: false,
                success: function( data, textStatus, jQxhr ){
                    console.log(data);
                    // $('').html( JSON.stringify( data ) );

                    alert(JSON.stringify( data ));

                    $("#action-form > div").slideUp("slow", function () {});
                    $(".thanks").removeClass('hidden').show(500);
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( textStatus, errorThrown );
                }
            });


            // $.post( "subscribe.php", { email: email })
            // .complete(function(msg) {

                // if(msg == 'success'){
                //
                // }
                // alert("Завершение выполнения");
            // })
            // .success(function(msg) { alert("Успешное выполнение" + msg); })
            // .error(function(msg) { alert("Ошибка выполнения" + msg); })
        //
        }

    });


    $("#send_request").on('click',function (e) {
        e.preventDefault();
        var name = $('#form-name').val();
        var phone = $('#form-phone').val();

        if(name.length > 0 && phone.length >0){
            $.post( "request.php", { name: name, phone: phone }).done(function ( data ) {
                if(data == 'success'){
                    $( "#subscription-form > div").slideUp("slow", function () {});//.hide(500);//fadeOut('slow');//
                    $(".dog").removeClass('hidden').fadeIn(500);

                }
                //alert("Data Loaded: " + data );
            });
        }
    });
});