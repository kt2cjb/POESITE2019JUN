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
            button.text(restloadmoreworkvc.button_loading);
            var grid = $(this).attr('data-grid');
            var work_per_page = $(this).attr('data-work-per-page');
            var works_column = $(this).attr('data-works-column');
            var img_hv_animation = $(this).attr('data-img-animation');
            var text_mask = $(this).attr('data-text-mask');
            var mask_animation = $(this).attr('data-mask-animation');
            var style_mask = $(this).attr('data-style-mask');
            var max_page = $(this).attr('data-max-page');
            if (!loading) {
                loading = true;
                var data = {
                    action: 'rest_ajax_load_more_work_vc',
                    grid: grid,
                    works_per_page: work_per_page,
                    works_column: works_column,
                    img_hv_animation:img_hv_animation,
                    text_mask:text_mask,
                    mask_animation: mask_animation,
                    style_mask: style_mask,
                    max_page: max_page,
                    nonce: restloadmoreworkvc.nonce,
                    page: page,
                    query: restloadmoreworkvc.query
                };
                $.post(restloadmoreworkvc.url, data, function (res) {

                    if (res.success) {
                        var $content = $(res.data);
                        if ($('.fl-work-grid-style').length) {
                                $('.fl_content_story-vc .fl_content-vc .fl-work-grid-style').append($content).cubeportfolio('append', $content);
                        } else {
                            $('.fl_content_story-vc .fl_content-vc .fl-work-grid-style').append($content);
                        }

                        //Hide the Load More button if no more posts to load
                        if (page == restloadmoreworkvc.maxpage) {
                            button.text(restloadmoreworkvc.button_text_no_post);
                            button.removeClass('fl-loading-more-enable-vc');
                        } else {
                            button.text(restloadmoreworkvc.button_text);
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