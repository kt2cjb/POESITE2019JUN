import $ from 'jquery'

export default () => {

    //spの時に大カテゴリーを押下すると子カテゴリーが出てくる
    let mobileFlag;
    let windowWidth = window.innerWidth;
    let bigCategory = $('input[name="checkbox"]#all');
    let smallCategory = $('input[name="checkbox"].tag__child--item');
    if ( windowWidth <= 750) {
        mobileFlag = true;
    } else {
        mobileFlag = false
    }
    if( mobileFlag ) {
        $('.tag__large').click(function(){
            const curr = $(this).next();
            const child = $(this).children('.accordion_icon');
            curr.fadeToggle('fast');
            child.toggleClass('active');
        });
    }

    //Allが設定された時に処理
    bigCategory.click(function(){
        const tagFlag = tagAll();
        if(!tagFlag[1] && tagFlag[0] === smallCategory.length) {
            smallCategory.prop("checked",false);
            bigCategory.prop('checked',true);
        } else if(!tagFlag[1] && tagFlag[0] === 0) {
            bigCategory.prop('checked',true);
        }
        else {
            smallCategory.prop("checked",false);
        }
    });

    smallCategory.click(function(){
        const tagFlag = tagAll();
        if(!tagFlag[1] && tagFlag[0] === smallCategory.length) {
            bigCategory.prop('checked',true);
        } else if(tagFlag[1] && tagFlag[0] < smallCategory.length) {
            bigCategory.prop('checked',false);
        } else if(!tagFlag[1] && tagFlag[0] === 0) {
            bigCategory.prop('checked',true);
        }
    });

    const tagAll = () => {
        try {
            let tagArr = [];
            let tagBig = false;
            for(let i = 0; i < smallCategory.length; i++) {
                if(smallCategory[i].checked){
                    tagArr.push(i);
                }
            }
            if(bigCategory[0].checked) {
                tagBig = true;
            }

            return [tagArr.length,tagBig]
        } catch {
            return;
        }
    }

    $(window).on('load',function(){
        if(bigCategory.length) {
            const tagFlag = tagAll();
            if(!tagFlag[1] && tagFlag[0] === 0) {
                bigCategory.prop('checked',true);
            }
        }
    });

};