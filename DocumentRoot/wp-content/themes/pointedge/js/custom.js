$(function(){
    if($('#work_list').length){
        workListAjax();
    }
    if($('#blog_list').length){
        blogListAjax();
    }
});

function workListAjax(){
    var loading = false;
    var page = 2;

    $('.tag__child--item').on('change',function(){
        page = 1;
        loading = false;
        $('#work_list').find('.list-contents__item').remove();
        if($('#work_list').height() < $(window).height()){
            $('#work_list').height($(window).height());
        }
        loadPost();
    });

    $('#all').on('change',function(){
        page = 1;
        loading = false;
        $('#work_list').find('.list-contents__item').remove();
        if($('#work_list').height() < $(window).height()){
            $('#work_list').height($(window).height());
        }
        loadPost();
    })

    $(window).on('scroll',function(e){
        if(!loading){
            var footerOffset = $('footer').offset();
            var footerTop = footerOffset.top;
            var windowHeight = window.innerHeight ? window.innerHeight: $(window).height();
            var checkValue = $(window).scrollTop() + windowHeight;
            if(footerTop + 100 < checkValue){
                loadPost();
            }
        }
    });
    function loadPost(){
        loading = true;
        var $tags = $('.tag__child--item');
        var search = [];
        $tags.each(function(index){
            var $tag = $(this);
            if($tag.prop('checked')){
                search.push($tag.val());
            }
        });
        $.ajax({
            url:"/wp-admin/admin-ajax.php?action=get_work",
            type:"GET",
            data:{'cats':search,'page':page,'tag': window.tag ? window.tag : ''},
            dataType:"json",
		}).done(function(res,textStatus,jqXHR) {

            var posts = res.posts;

            for(var i = 0; i < posts.length; i++){
                appendHtml(posts[i]);
            }

            page++;
            if(page > res.page_max){
                
            }else{
                loading = false;
            }
            $('#work_list').height('auto');
		});
    }

    function appendHtml(data){
        var html = '';
        html += '<div class="list-contents__item">';
        html += '<div class="card"><a class="card__link" href="' + data.permalink + '">';
        html += '<div class="card__img">' + data.thumbnail + '</div>';
        html += '<h3 class="card__ttl">' + data.title + '</h3></a>';
        html += '<ul class="card__list">';

        for(var i = 0; i < data.categories.length; i++){
            var cat = data.categories[i];
            html += '<li class="card__list-item"> <a href="/blog_tag/' + cat.slug + '">#' + cat.title + '</a></li>';
        }

        html += '</ul>';
        html += '</div>';
        html += '</div>';

        $('#work_list').find('.list-contents').append(html);
    }
}

function blogListAjax(){
    var loading = false;
    var page = 2;

    $(window).on('scroll',function(e){
        if(!loading){
            var footerOffset = $('footer').offset();
            var footerTop = footerOffset.top;
            var windowHeight = window.innerHeight ? window.innerHeight: $(window).height();
            var checkValue = $(window).scrollTop() + windowHeight;
            if(footerTop + 100 < checkValue){
                loadPost();
            }
        }
    });
    function loadPost(){
        loading = true;
        var search = [];
        if(window.tag){
            search.push(window.tag);
        }
        $.ajax({
            url:"/wp-admin/admin-ajax.php?action=get_blog",
            type:"GET",
            data:{'cats':search,'page':page},
            dataType:"json",
		}).done(function(res,textStatus,jqXHR) {
            var posts = res.posts;

            for(var i = 0; i < posts.length; i++){
                appendHtml(posts[i]);
            }

            page++;
            if(page > res.page_max){
                
            }else{
                loading = false;
            }
		});
    }

    function appendHtml(data){
        var html = '';
        html += '<div class="list-contents__item">';
        html += '<div class="card"><a class="card__link" href="' + data.permalink + '">';
        html += '<div class="card__img">' + data.thumbnail + '</div>';
        html += '<h3 class="card__ttl">' + data.title + '</h3></a>';
        html += '<ul class="card__list">';

        for(var i = 0; i < data.categories.length; i++){
            var cat = data.categories[i];
            html += '<li class="card__list-item"> <a href="/blog_tag/' + cat.slug + '">#' + cat.title + '</a></li>';
        }

        html += '</ul>';
        html += '</div>';
        html += '</div>';

        $('#blog_list').find('.list-contents').append(html);
    }
}

// $(function(){
//     if($('.top-letter').length){
//         topLetter();
//     }
// });

function topLetter(){
    var firstScrollEnd = false;
    var secondScrollEnd = false;
    var moveing = false;

    var ua = navigator.userAgent;
    var mobileFlag;

    if (ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0) {
        mobileFlag = true;
    } else if (ua.indexOf('iPad') > 0 || ua.indexOf('Android') > 0) {
        mobileFlag = true
    } else {
        mobileFlag = false
    }

    function scroll_control(event) {
        var canScroll = false;
        if(event.deltaY > 0){
            if($(window).scrollTop() == 0 && !firstScrollEnd){
                canScroll = false;
                moveing = true;
                firstScrollEnd = true;
                $('.bookmark').addClass('active');
                setTimeout(function(){
                    moveing = false;
                },1500);
            }else if($(window).scrollTop() == 0 && !moveing && !secondScrollEnd){
                canScroll = false;
                moveing = true;
                secondScrollEnd = true;
                var windowHeight_pc = document.documentElement.clientHeight + 50;
                $("html,body").animate({scrollTop:windowHeight_pc},1000,function(){
                    moveing = false;
                });
            }
        }

        if(!canScroll && moveing){
            event.preventDefault();
        }
    }
    function no_scroll(){
        document.addEventListener("mousewheel", scroll_control, {passive: false});
        // $("html,body").on('touchmove', function(e){
        //     alert('aaaa');
        // });
    }
    // function return_scroll(e){
    //     document.removeEventListener("mousewheel", scroll_control, {passive: false});
    //     document.removeEventListener('touchmove', scroll_control, {passive: false});
    // }
    no_scroll();

    var topWorkOffset = $('.top-work-contents').offset();
    var beliefOffset = $('.top-belief').offset();
    var beliefHeight = $('.top-belief').outerHeight();

    var scrolled = false;

    $(window).on('scroll',function(){
        var top =  $(window).scrollTop();
        if(top > topWorkOffset.top - 200){
            if(!mobileFlag){
                $('.bookmark').removeClass('active');
                firstScrollEnd = secondScrollEnd = false;
            }
        }
        var sub = mobileFlag ? 200 : 400;
        // $('#debug').text((Math.floor(top*1)/1)+':'+(beliefOffset.top + sub));
        if(top > beliefOffset.top + sub){
            var diff = top - (beliefOffset.top + sub);
            var op = beliefHeight - sub;
            var par = op - diff;
            
            $('.top-belief').css('opacity',par/op);
        }else{
            $('.top-belief').css('opacity',1);
        }
    });
    if(mobileFlag){
        $("body").bind("touchstart", TouchStart);
        $("body").bind("touchmove" , TouchMove);
        $("body").bind("touchend"  , TouchLeave);

        
        $('body').addClass('top-wrap');
        setTimeout(function(){
            $("html,body").scrollTop(0);
            $('body').css('opacity',1);
        },25);
    }else{
        $('body').css('opacity',1);
    }
    function TouchStart(e){
        if($(window).scrollTop() == 0 && !firstScrollEnd){
            canScroll = false;
            moveing = true;
            firstScrollEnd = true;
            $('.bookmark').addClass('active');
            setTimeout(function(){
                moveing = false;
            },600);
        }else if($(window).scrollTop() == 0 && !moveing && !secondScrollEnd){
            $('body').removeClass('top-wrap');
            canScroll = false;
            moveing = true;
            secondScrollEnd = true;
            var windowHeight_pc = document.documentElement.clientHeight + 50;
            $("html,body").animate({scrollTop:windowHeight_pc},1000,function(){
                moveing = false;
            });
        }
    }
    function TouchMove(e){
        if(moveing){
            e.preventDefault();
        }
        //$(window).scrollTop(0);
    }
    function TouchLeave(e){
        e.preventDefault();
        //$(window).scrollTop(0);
        //$('#debug').text('end');
    }
}