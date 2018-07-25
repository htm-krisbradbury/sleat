$(document).ready(function () {

    // Custom Menu Toggle
    // ---------------------------------
    $('#custom-menu-toggle').click(function () {
        $('body').toggleClass('show-nav');
    });

    // Site news ticker
    // ---------------------------------
    var $pArr = $('#site-news-forum>.forumpost');
    var pArrLen = $pArr.length;
    for (var i = 0; i < pArrLen; i += pArrLen) {
        $pArr.filter(':eq(' + i + '),:lt(' + (i + pArrLen) + '):gt(' + i + ')').wrapAll('<div id="newsSlider" class="d-flex flex-wrap flex-row"/>');
    }

    $(window).resize(function () {
    });

    console.log('custom.js loaded');


});
