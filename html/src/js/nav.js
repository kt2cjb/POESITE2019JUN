import $ from 'jquery';

export default () => {

    let mobileFlag = false;
    let windowWidth = window.innerWidth;
    const path = location.pathname;
    const navClass = '.nav';
    const toggleClass = '.nav-toggle';
    const navBg = '.nav__bg';
    const navCansel = '.nav__cansel';
    const spacePull = '.space__toggle';
    const spaceActive = '.pull-down';
    let spaceFlag = false;
    if ( windowWidth <= 900) {
        mobileFlag = true;
    } else {
        mobileFlag = false;
    }
    const toggleFun = () => {
        $(navClass).toggleClass('active');
        $(navBg).toggleClass('active');
        $(navCansel).toggleClass('active');
    }
    $(toggleClass).on('click',function(){
        toggleFun();
    });
    $(spacePull).on('click',function(){
        if(mobileFlag) {
            $(spaceActive).toggle('active');
            spaceFlag = true;
        }
    });
    $(navClass).on('click',function(){
        if(!spaceFlag) {
            $(navClass).removeClass('active');
            $(navBg).removeClass('active');
            $(navCansel).removeClass('active');
        } else {
            spaceFlag = false;
        }
    });
    $(navCansel).on('click',function(){
        toggleFun();
    });

    //下層ページだった場合はナビに線が入るように処理
    if(path.match(/about/)){
        $('#about').addClass('active');
    } else if (path.match(/service/)) {
        $('#service').addClass('active');
    } else if (path.match(/work/)) {
        $('#work').addClass('active');
    } else if (path.match(/blog/)) {
        $('#blog').addClass('active');
    } else if (path.match(/jobs/)) {
        $('#jobs').addClass('active');
    } else if (path.match(/contact/)) {
        $('#contact').addClass('active');
    }

}