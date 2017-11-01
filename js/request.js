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

    $('#visit-form-phone').mask('+7(000) 000-0000');


    $("#send_request").on('click',function (e) {
        e.preventDefault();
        var name = $('#visit-form-name').val();
        var phone = $('#visit-form-phone').val();

        var messageObject = { name: name, phone: phone };

        if(window.puppy_identity != false){
            messageObject.puppy = window.puppy_identity;
        }

        if(name.length > 0 && phone.length >0){
            $.ajax({
                url: 'request.php',
                dataType: 'json',
                type: 'post',
                contentType: 'application/json',
                processData: false,
                data: JSON.stringify(messageObject),

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


//        clientId: '1b29953677fe4691a66889bf910ed835'
//        clientId: 'a3f25f257cdc4b77bcce0761d9dfccde'
    var feed = new Instafeed({
        get: 'user',
//        userId: '6262509009',
//        accessToken: '6262509009.1677ed0.b6cf639de6b84f5fb8abb784bdd44e56',
        userId: '6156847034',
        accessToken: '6156847034.1677ed0.69ff330f2a134600bcaae59473f32b90',
        resolution: 'low_resolution',
        template: '<div class="insta-card">' +
        '<span class="insta-top" ><img src="{{model.user.profile_picture}}" />{{model.user.username}} </span>' +
        '<a href="{{link}}"><img src="{{image}}" /></a>' +
        '<span class="insta-bottom" >' +
        ' <i class="icon fa fa-heart"></i> {{model.likes.count}} likes <br>' +
        '<span class="main-text"><b>@{{model.user.username}} :</b> {{caption}}</span></span></div>'

    });
    feed.run();

    setTimeout(function(){

        var $holder = $(".instafeed-view");
        var $list = $holder.find(".instafeed-list");
        var $clonedList = $list.clone();

        var listWidth = $list.find(".insta-card").length * 360;
        var endPos = $holder.width() - listWidth;

        console.info(listWidth);

        $list.add($clonedList).css({
            "width" : listWidth + "px"
        });

        $clonedList.addClass("cloned").appendTo($holder);

        //TimelineMax
        var infinite = new TimelineMax({repeat: -1, paused: false});
        var time = 70;

        infinite.fromTo($list, time, {left:0}, {left: -listWidth, ease: Linear.easeNone}, 0);
        infinite.fromTo($clonedList, time, {left:listWidth}, {left:0, ease: Linear.easeNone}, 0);
        infinite.set($list, {left: listWidth});
        infinite.to($clonedList, time, {left: -listWidth, ease: Linear.easeNone}, time);
        infinite.to($list, time, {left: 0, ease: Linear.easeNone}, time);

        //Pause/Play

        $holder.on("mouseenter", function(){
            infinite.pause();
        }).on("mouseleave", function(){
            infinite.play();
        });
    }, 2000);

});