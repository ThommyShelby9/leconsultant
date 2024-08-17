'use strict';

$(function() {
    console.log("Hey there");
    //code here



    //AOS
    AOS.init({ once: true });

    // $('#nav-toggle').click(function () {
    //     $('#nav-content:visible').hide(500);
    //     $('#nav-content:hidden').show(500);
    // });

    // AOS.init();

    // Javascript to toggle the menu
    $('#nav-toggle').click(function () {
        $('#main-menu-navigation:visible').hide(400);

        $('#main-menu-navigation:hidden').show(400);
    });

    var $window = $(window);
    $window.on('scroll', function () {
        var header = $("header");
        var nav = $("#main-menu");
        var logo = $("#main-menu #logo img");
        var scroll = $window.scrollTop();
        if (scroll >= 100){
            // header.removeClass("lg:px-12");
            // header.removeClass("px-4");
            nav.removeClass("unsticky");
            nav.addClass("collant");
            // logo.attr('src', 'assets/img/logo_black.png');
            // nav.addClass("fixed")
            // $('#topbar').addClass("hidden");
        }
        else {
            // header.addClass("lg:px-12");
            // header.addClass("px-4");
            nav.removeClass("collant");
            nav.addClass("unsticky");
            // logo.attr('src', 'assets/img/logoqotto_b.png');
            // nav.removeClass("fixed")
            // $('#topbar').removeClass("hidden");
        }
    });

    $("#ns").on('click', function(event) {
        event.preventDefault();
        $("html, body").animate({
            scrollTop: $('#solutions').offset().top - (70)
        }, 1250);
    });

    /*Vanilla Js*/
    // const toggler = document.querySelector("#nav-toggle");
    // const toggleNav = () => {
    //     toggler.classList.toggle("open");
    //
    //     const ariaToggle = toggler.getAttribute("aria-expanded") === "true" ? "false" : "true";
    //     toggler.setAttribute("aria-expanded", ariaToggle);
    //
    // }
    // toggler.addEventListener("click", toggleNav);

    /* Jquery js */
    const togglerV2 = $("#nav-toggle");
    const toggleNavV2 = () => {
        togglerV2.toggleClass("open");

        const ariaToggleV2 = togglerV2.attr("aria-expanded") === "true" ? "false" : "true";
        togglerV2.attr("aria-expanded", ariaToggleV2);
    }
    togglerV2.click(toggleNavV2);

});
