import $ from 'jquery';
import 'jquery-scrollstop';
import * as imagesLoaded from 'imagesloaded';

export default () => {
    const path = location.pathname;

    if(path === '/' || path === '/#') {
        const windowHeight = window.parent.screen.height;
        const windowHeight_pc = document.documentElement.clientHeight;
        const headerHeight = $('.header').outerHeight();
        $('.top-letter-wrap').css('height',(windowHeight_pc - headerHeight + (windowHeight_pc / 10) + 1) + 'px');
        $('.top-letter__slider-img').css('height',(windowHeight_pc - headerHeight + (windowHeight_pc / 10) + 1) + 'px');
        const off = $('.top-section2').offset().top - (windowHeight_pc / 10);
        const curr = window.pageYOffset;
        let scrollActiveFlag = false;
        let ua = navigator.userAgent;
        var safari = window.navigator.userAgent.toLowerCase();
        let mobileFlag;

        let markbookActive;
        let cookieFlag = false;

        if (ua.indexOf('iPhone') > 0 || ua.indexOf('Android') > 0 && ua.indexOf('Mobile') > 0) {
            mobileFlag = true;
        } else if (ua.indexOf('iPad') > 0 || ua.indexOf('Android') > 0) {
            mobileFlag = true
        } else {
            mobileFlag = false
        }

        // var mousewheelevent = 'onwheel' in document ? 'wheel' : 'onmousewheel' in document ? 'mousewheel' : 'DOMMouseScroll';
        if(ua.indexOf('Msie') != -1 || ua.indexOf('Trident') != -1) {
            // mousewheelevent = 'onwheel' in document ? 'onwheel' : 'onmousewheel' in document ? 'onmousewheel' : 'DOMMouseScroll';
        }

        ///////////////帯が出たあとのペイジャーの処理
        const wheel = () => {
            $('body').on('wheel',function(event){
                if(scrollActiveFlag === true){
                    if(event.originalEvent.deltaY > 1 ) {
                        $('body').off('wheel');
                        $('body,html').animate({
                            scrollTop: off,
                        },1000);
                        setTimeout(() => {
                            $('body').removeClass('top-wrap');
                            scroll();
                        },1400);
                    }
                } else {
                    $(window).off('wheel');
                    $('body').addClass('top-wrap');
                    scrollTop();
                }
            });
        };


        ///////////////スクロールしている時にペイジャーになるかどうかと２つ目のペイジャーがfadeInとfadeOutするかどうか
        const scroll = () => {
            $(window).on('scroll',function() {
                const scrollY = $(window).scrollTop();
                if(scrollY + 5 < off) {
                    $(window).off('scroll');
                    $('body').addClass('top-wrap');
                    if(mobileFlag) {
                        document.addEventListener('touchmove', moveNone, {passive: false});
                    }
                    $('body,html').animate({
                        scrollTop: off,
                    },0);
                    $('body,html').animate({
                        scrollTop: 0,
                    },1000);
                    setTimeout(() => {
                        $('body').addClass('top-wrap');
                        if(!mobileFlag) {
                            wheel();
                        } else {
                            touchMove();
                        }
                    },1000);
                } else if (scrollY > off + off * 0.7) {
                    $('.top-belief').removeClass('animated fadeIn');
                    $('.top-belief').addClass('animated fadeOut');
                } else if ($('.top-belief').hasClass('fadeOut animated')) {
                    $('.top-belief').removeClass('animated fadeOut');
                    $('.top-belief').addClass('animated fadeIn');
                }
            })
        }
        ///////////////ファーストビューの帯が出る処理
        const scrollTop = () => {
            $(window).on('wheel',function(event){
                if(event.originalEvent.deltaY > 0) {
                    clearTimeout(markbookActive);
                    if(scrollActiveFlag === false){
                        $('.bookmark').addClass('active');
                        markbookActive = setTimeout(() => {
                            $(window).off('wheel');
                            if(scrollActiveFlag === false) {
                                scrollActiveFlag = true;
                            }
                            wheel();
                        },50);
                        if( event.originalEvent.deltaY === 1 || event.originalEvent.deltaY === 13) {
                        }
                    }
                }
            });
        };

        ///////////////スマホになったときのペイジャーと帯の処理
        const touchMove = () => {
            var touch_x  = 0;      //最初にタップしたXの位置
            var touch_y  = 0;      //最初にタップしたYの位置
            var slide_x  = 0;      //移動したXの位置
            var slide_y  = 0;      //移動したYの位置
            var minus_x  = false;  //マイナス移動 X
            var minus_y  = false;  //マイナス移動 Y

            /*
            * タップ、スワイプ、指を離した時のイベントハンドラ
            */
            $("body").bind("touchstart", TouchStart);
            $("body").bind("touchmove" , TouchMove);
            $("body").bind("touchend"  , TouchLeave);
            
            /*
            * タップ
            */
            function TouchStart( event ) {
                var pos = Position(event);
                touch_x = pos.x;
                touch_y = pos.y;
            }
                
            /*
            * スワイプ
            */
            function TouchMove( event ) {
                
                var pos = Position(event); //X,Yを得る
                
                //移動した位置から最初の位置を引く
                var cal_x = pos.x - touch_x;
                var cal_y = pos.y - touch_y;
                
                //最初にタップした位置からマイナかプラスを判定
                if(cal_x < 0)
                minus_x = true;
                else
                minus_x = false;
                
                if(cal_y < 0)
                minus_y = true;
                else
                minus_y = false;
                
            
                //マイナスの値をプラスに変更
                slide_x = Math.sqrt(Math.pow(cal_x,2));
                slide_y = Math.sqrt(Math.pow(cal_y,2));
            }
                
            /*
            * 指を離す
            */
            function TouchLeave( event ) {
                var message;
                
                //指のズレ50を考慮し、それ以上ならそちらに移動していると判断する
                if(slide_x > 50){
                if(minus_x === true)
                    message = '←';
                else
                    message = '→';
                }
                if(slide_y > 50){
                    message = '↑';
                    if(minus_y === true){
                        if(scrollActiveFlag === false){
                            $('.bookmark').addClass('active');
                            setTimeout(() => {
                                scrollActiveFlag = true;
                            },1000);
                        } else {
                            $("body").off("touchstart", TouchStart);
                            $("body").off("touchmove" , TouchMove);
                            $("body").off("touchend"  , TouchLeave);
                            $('body,html').animate({
                                scrollTop: off,
                            },1000);
                            setTimeout(() => {
                                $('body').removeClass('top-wrap');
                                document.removeEventListener('touchmove', moveNone, {passive: false});
                                scroll();
                            },1400);
                        }
                    }
                else{
                    message = '↓';
                }
                }
            }
            
            /*
            * 現在位置を得る
            */
                function Position(e){
                    var x   = e.originalEvent.touches[0].pageX;
                    var y   = e.originalEvent.touches[0].pageY;
                    x = Math.floor(x);
                    y = Math.floor(y);
                    var pos = {'x':x , 'y':y};
                    return pos;
                }
        }


        //safariとedgeとieが一番上に戻るための処理
        if(ua.indexOf('Safari') !== -1 && ua.indexOf('Chrome') === -1 && ua.indexOf('Edge') === -1 || ua.indexOf('Edge') != -1 || ua.indexOf('Msie') != -1 ||
        ua.indexOf('Trident') != -1) {
            $('body,html').animate({
                scrollTop: 0,
            },500);
        }
        
        
        //localStorageを使いページ内リンクでスクロールにしている処理
        const pageID = localStorage.getItem("pageLink");
        if(pageID) {
            cookieFlag =true;
            setTimeout(() => {
                $('body,html').animate({
                    scrollTop: $(pageID).offset().top,
                },0);
            },100);
            localStorage.removeItem("pageLink");
        }

        const moveNone = (e) => {
            e.preventDefault();
        }
        
        if(ua.indexOf('Edge') != -1 || ua.indexOf('Msie') != -1 || ua.indexOf('Trident') != -1) {
            // $('#container').imagesLoaded( { background: true }, function() {
            //     $('.bookmark').addClass('active');
            // });
            imagesLoaded( '#container', { background: true }, function() {
                setTimeout(() => {
                    $('.bookmark').addClass('active');
                },500)
            });
        }else {
            ///////////////pcかspで処理を分けている
            if(!mobileFlag) {
                if(curr === 0 && curr < off && !cookieFlag) {
                    $('body').addClass('top-wrap');
                    scrollTop();
                } else {
                    scroll();
                }
            } else {
                if(ua.indexOf('Safari') !== -1 && ua.indexOf('Chrome') === -1 && ua.indexOf('Edge') === -1) {
                    $('body,html').animate({
                        scrollTop: 0,
                    },500);
                }
                if(curr === 0 && curr < off && !cookieFlag) {
                    document.addEventListener('touchmove', moveNone, {passive: false});
                    $('body').addClass('top-wrap');
                    touchMove();
                } else {
                    scroll();
                }
            }
        }
    }
}