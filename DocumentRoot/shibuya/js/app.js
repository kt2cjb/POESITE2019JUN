$(function() {

	jQuery.event.add(window,'load',function() {
        $('#loading').delay(500).fadeOut(700);
    });

	//swipter.js
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        slidesPerView: 1,
        paginationClickable: true,
        spaceBetween: 0,
        loop: true
    });

    //scroll
    $('a[href^="#"]').click(function() {
		var speed = 400;
		var href= $(this).attr('href');
		var target = $(href == '#' || href == "" ? 'html' : href);
		var position = target.offset().top -72+'px';
		$('body,html').animate({scrollTop:position}, speed, 'swing');
		return false;
	});

    AOSAnimation();
    squareAnimation();

});


var AOSAnimation = function(){
  AOS.init({
    easing: 'ease-out-back',
    duration: 1500
  });
}

var squareAnimation = function(){
  var random_boolean;
  $(window).on('scroll',  function(event) {
    event.preventDefault();
    $('.box').each(function(index, el) {

      if( isScrolledIntoView($(el))
        && !$(el).hasClass('added')
        && index != 3
        && index != 5
      ){

        $(el).addClass('added');
        $(el).append(squareWrap);
        $(el).children('.squareWrap').addClass('squareWrapAnime');

        for(var i = 0; i< Math.floor( Math.random() * 3 ) + 1; i++){
          random_boolean = Math.random() >= 0.2;
          if(random_boolean){
            var S = $(squareBlack);
            $(el).children('.squareWrap').append(S);
            S.ready(function() {
                var Size = Math.floor( Math.random() * 30 ) + 40;
                S.css({
                  'margin-top': Math.floor( Math.random() * 3 ) * 60 + 'px',
                  'width': Size + 'px',
                  'height':  Size + 'px'
                });
                if( Math.random() >= 0.5){
                  S.children('.square__child').css({
                    'background': '#666'
                  });
                }
                S.delay(Math.floor( Math.random() * 5 )*100).queue(function(){
                   $(this).addClass('squareAnime');
                });
            });
          }
          else{
            var S = $(squareLine);
            $(el).children('.squareWrap').append(S);
            S.ready(function() {
                var Size = Math.floor( Math.random() * 30 ) + 40;
                S.css({
                  'margin-top': Math.floor( Math.random() * 3 ) * 60 + 'px',
                  'width': Size + 'px',
                  'height':  Size + 'px'
                });
                S.delay(Math.floor( Math.random() * 5 )*100).queue(function(){
                   $(this).addClass('squareAnime');
                });
            });
          }
        }

        random_boolean = Math.random() >= 0.5;
        if(index == 2){
          $(el).children('.squareWrap').css({
            top:Math.floor( Math.random() * 3 )+5 + '%',
            right: Math.floor( Math.random() * 10 )-5 + '%',
          });
        }
        else if(index == 6){
          $(el).children('.squareWrap').css({
            top:Math.floor( Math.random() * 3 )+5 + '%',
            right: Math.floor( Math.random() * 10 )-5 + '%',
          });
        }
        else{
          if(random_boolean){
            $(el).children('.squareWrap').css({
              top:Math.floor( Math.random() * 20 ) + 10 + '%',
              left: Math.floor( Math.random() * 10 )-5 + '%',
            });
          }
          else{
            $(el).children('.squareWrap').css({
              top:Math.floor( Math.random() * 20 )+ 10 + '%',
              right: Math.floor( Math.random() * 10 )-5 + '%',
            });
          }
        }

        random_boolean = Math.random() >= 0.5;
        if(random_boolean){
          $(el).children('.squareWrap').addClass('squareWrapRotate');
        }
      }
    });
  });
}

var isScrolledIntoView = function(elem) {
  var docViewTop = $(window).scrollTop();
  var docViewBottom = docViewTop + $(window).height();
  var elemTop = $(elem).offset().top;
  var elemBottom = elemTop;
  return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}

var squareWrap = '<div class="squareWrap"></div>';
var squareBlack = '<div class="square"><span class="square__child"></span><span class="square__child"></span><span class="square__child"></span><span class="square__child"></span></div>';
var squareLine = '<div class="square squareLine"><span class="square__child"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></span><span class="square__child"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></span><span class="square__child"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></span><span class="square__child"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></span></div>';
