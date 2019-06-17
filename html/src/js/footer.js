import $ from 'jquery'

export default () => {
    const footerSpace = $('#footer__space');
    const path = location.pathname;
    footerSpace.on('click',function(){
        localStorage.setItem('pageLink', '#top-space');
        if(path === '/'){
            const pageID = localStorage.getItem("pageLink");
            $('body,html').animate({
                scrollTop: $(pageID).offset().top,
            },1000);
            localStorage.removeItem("pageLink");
        } else {
            document.location.href = "/";
        }
    });
}