jQuery(document).ready(function($){
    "use strict";
        if($('body').hasClass('woocommerce-page')){
            //Do not Init Infinite Scroll
        } else if($('.fl-work-grid-style').hasClass('fl-infinite-enable')) {
            var infinite_box = $('.fl-work-grid-style');
            var button = $('.fl-loading-enable-infinite-vc');
            var page = 2;
            var loading = false;
            var grid = button.attr('data-grid');
            var work_per_page = button.attr('data-work-per-page');
            var works_column = button.attr('data-work-column');
            var img_hv_animation = button.attr('data-img-animation');
            var text_mask = button.attr('data-text-mask');
            var mask_animation = button.attr('data-mask-animation');
            var style_mask = button.attr('data-style-mask');
            var max_page = button.attr('data-max-page');
            var scrollHandling = {
                allow: true,
                reallow: function () {
                    scrollHandling.allow = true;
                },
                delay: 200 //(milliseconds) adjust to the highest acceptable value
            };

            $(window).scroll(function () {

                if( ! loading && scrollHandling.allow ) {
                    scrollHandling.allow = false;
                    setTimeout(scrollHandling.reallow, scrollHandling.delay);
                    var button_offser = button.offset().top;
                    var topOfWindow = $(window).scrollTop();
                    if( button_offser < topOfWindow+$(window).height()+50 ) {
                        if (page <= restloadmoreinfinite.maxpage) {
                            button.addClass('loading');
                            button.text(restloadmoreinfinite.button_loading);
                        }
                        loading = true;
                        var data = {
                            grid: grid,
                            works_per_page: work_per_page,
                            works_column: works_column,
                            img_hv_animation:img_hv_animation,
                            text_mask:text_mask,
                            mask_animation: mask_animation,
                            style_mask: style_mask,
                            max_page: max_page,
                            action: 'rest_ajax_load_more_work_vc',
                            nonce: restloadmoreinfinite.nonce,
                            page: page,
                            query: restloadmoreinfinite.query,
                        };
                        $.post(restloadmoreinfinite.url, data, function(res) {
                            if( res.success) {
                                var $content = $(res.data);
                                //Hide the Load More button if no more posts to load
                                if (page == restloadmoreinfinite.maxpage) {
                                    button.text(restloadmoreinfinite.button_text_no_post);
                                    button.removeClass('fl-loading-enable-infinite-vc');
                                    button.addClass('fl-loading-disable-infinite-vc');
                                    infinite_box.removeClass('fl-infinite-enable');
                                }
                                setTimeout(function() {
                                    $('.fl_content_story-vc .fl_content-vc .fl-work-grid-style').append($content).cubeportfolio('append', $content);
                                    page = page + 1;
                                    button.removeClass('loading');
                                    loading = false;
                                }, 1400);
                            } else {
                                // console.log(res);
                            }
                        }).fail(function(xhr, textStatus, e) {
                            // console.log(xhr.responseText);
                        });

                    }
                }
            });
        }
});