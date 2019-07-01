jQuery.noConflict()(function($) {
    "use strict";
/*------------------------------------------------------------------

   Button Shortcode

------------------------------------------------------------------*/

    $(document).ready(function() {
        $('.fl_btn_box').each(function (index, element) {
            var fl_btn_color = $(this).css("color");
            var fl_btn_bg = $(this).css("background-color");
            var fl_btn_border_color = $(this).css("border-color");
            $(element).hover(
                function () {
                    $(this).css({
                        'color': $(this).attr('data-text-hv'),
                        'background': $(this).attr('data-bg-hv'),
                        'border-color': $(this).attr('data-bg-hv')
                    });
                },
                function () {
                    $(this).css({
                        'color': fl_btn_color,
                        'background': fl_btn_bg,
                        'border-color': fl_btn_border_color
                    });
                }
            );
        });
    });
/*------------------------------------------------------------------

   Banner Button

------------------------------------------------------------------*/
    $(document).ready(function() {
        $('.fl_banner_button').each(function (index, element) {
            var fl_banner_btn_color = $(this).css("color");
            var fl_banner_btn_bg = $(this).css("background-color");
            var fl_banner_btn_border_color = $(this).css("border-color");
            $(element).hover(
                function () {
                    $(this).css({
                        'color': $(this).attr('data-text-hv'),
                        'background': $(this).attr('data-bg-hv'),
                        'border-color': $(this).attr('data-bg-hv')
                    });
                },
                function () {
                    $(this).css({
                        'color': fl_banner_btn_color,
                        'background': fl_banner_btn_bg,
                        'border-color': fl_banner_btn_border_color
                    });
                }
            );
        });
    });
/*------------------------------------------------------------------

          Gif

-------------------------------------------------------------------*/
    var fl_gif_hover = $(".fl-hover-gif img"),
        gif_src = fl_gif_hover.data('gif'),
        static_src = fl_gif_hover.data('static'),
        fl_gif_click = $(".fl-click-gif img"),
        gif_src_click = fl_gif_click.data('gif'),
        static_src_click = fl_gif_click.data('static');
    $(document).ready(function(){
        fl_gif_hover.hover(
            function() {
                $(this).attr("src", gif_src);
            },
            function() {
                $(this).attr("src", static_src);
            }
        );
        fl_gif_click.on("click", function() {
            var animate = $(this).attr("data-animate");
            if (animate === "gif") {
                $(this).attr("src",static_src_click);
                $(this).attr("data-animate", "static");
            }
            else if (animate === "static") {
                $(this).attr("src",  gif_src_click);
                $(this).attr("data-animate", "gif");
            }
        });
    });

/*------------------------------------------------------------------

     Fun box Shortcode

-------------------------------------------------------------------*/
    $(".fl_fun_box_two").each(function() {
        var width= $(this).find('.fl_fun_text_one').width()+20;
        $(this).find('.fl_fun_text_two').css({ 'width': 'calc(100% - ' + width+ 'px)' });
    });

/*------------------------------------------------------------------

   Alert shortcode

-------------------------------------------------------------------*/
    $(".fl-alert_close").on('click', function() {
        $(this).parent('.fl-alert').addClass("fl_closed_alert");
        $(this).parent('.fl-alert').fadeOut( 900 );
    });

/*------------------------------------------------------------------

   Accordion

-------------------------------------------------------------------*/

    $('.fl_accordion_toggle').click(function(e) {
        e.preventDefault();

        var $this = $(this);

        if($this.parent().hasClass('show')){
            $this.parent().removeClass('show');
            $this.next().slideUp(350);
        } else {
            $this.parent().parent().find('li').removeClass('show');
            $this.parent().parent().find('li .inner').removeClass('show');
            $this.parent().parent().find('li .inner').slideUp(350);
            $this.next().toggleClass('show');
            $this.next().slideToggle(350);
            $this.parent().addClass('show');
        }
    });

});