jQuery(function($){
    "use strict";
    if($('body').hasClass('woocommerce-page')){
        //Do not Init Infinite Scroll
    } else {
        var button = $('.fl-loading-more-enable-vc'),
            page = 2,
            loading = false;
        $('body').on('click', '.fl-loading-more-enable-vc', function () {
            button.addClass('loading');
            button.text(restloadmorepostvc.button_loading);
            var grid = $(this).attr('data-grid');
            var post_per_page = $(this).attr('data-post-per-page');
            var posts_column = $(this).attr('data-posts-column');
            var excerpt_limit = $(this).attr('data-excerpt-limit');
            var max_page = $(this).attr('data-max-page');
            if (!loading) {
                loading = true;
                var data = {
                    action: 'rest_ajax_load_more_post_vc',
                    grid: grid,
                    posts_per_page: post_per_page,
                    posts_column: posts_column,
                    excerpt_limit: excerpt_limit,
                    max_page: max_page,
                    nonce: restloadmorepostvc.nonce,
                    page: page,
                    query: restloadmorepostvc.query
                };
                $.post(restloadmorepostvc.url, data, function (res) {

                    if (res.success) {
                        var $content = $(res.data);
                        if ($('.fl-post-list-vc').length) {
                                $('.fl_content_story-vc .fl_content-vc .fl-post-list-vc').append($content).cubeportfolio('append', $content);
                        } else {
                            $('.fl_content_story-vc .fl_content-vc .fl-post-list-vc').append($content);
                        }

                        //Hide the Load More button if no more posts to load
                        if (page == restloadmorepostvc.maxpage) {
                            button.text(restloadmorepostvc.button_text_no_post);
                            button.removeClass('fl-loading-more-enable-vc');
                        } else {
                            button.text(restloadmorepostvc.button_text);
                        }
                        page = page + 1;

                        loading = false;
                        button.removeClass('loading');
                    } else {
                        // console.log(res);

                    }
                }).fail(function (xhr, textStatus, e) {
                    // console.log(xhr.responseText);
                });
            }
        });
    }
});