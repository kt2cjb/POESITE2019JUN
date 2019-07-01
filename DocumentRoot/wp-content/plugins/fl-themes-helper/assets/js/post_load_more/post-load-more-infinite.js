jQuery(document).ready(function($){
    "use strict";
        if($('body').hasClass('woocommerce-page')){
            //Do not Init Infinite Scroll
        } else if($('.fl-post-list-vc').hasClass('fl-infinite-enable')) {
            var infinite_box = $('.fl-post-list-vc');
            var button = $('.fl-loading-enable-infinite-vc');
            var page = 2;
            var loading = false;
            var grid = button.attr('data-grid');
            var post_per_page = button.attr('data-post-per-page');
            var posts_column = button.attr('data-posts-column');
            var excerpt_limit = button.attr('data-excerpt-limit');
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
                        if (page <= restloadmoreinfinitepost.maxpage) {
                            button.addClass('loading');
                            button.text(restloadmoreinfinitepost.button_loading);
                        }
                        loading = true;
                        var data = {
                            action: 'rest_ajax_load_more_post_vc',
                            grid: grid,
                            posts_per_page: post_per_page,
                            posts_column: posts_column,
                            excerpt_limit: excerpt_limit,
                            max_page: max_page,
                            nonce: restloadmoreinfinitepost.nonce,
                            page: page,
                            query: restloadmoreinfinitepost.query
                        };
                        $.post(restloadmoreinfinitepost.url, data, function(res) {
                            if( res.success) {
                                var $content = $(res.data);
                                //Hide the Load More button if no more posts to load
                                if (page == restloadmoreinfinitepost.maxpage) {
                                    button.text(restloadmoreinfinitepost.button_text_no_post);
                                    button.removeClass('fl-loading-enable-infinite-vc');
                                    button.addClass('fl-loading-disable-infinite-vc');
                                    infinite_box.removeClass('fl-infinite-enable');
                                }
                                setTimeout(function() {
                                    $('.fl_content_story-vc .fl_content-vc .fl-post-list-vc').append($content).cubeportfolio('append', $content);
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