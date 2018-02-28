/* ---------------------------------------------------------------- */
/* Mobile Menu
/* ---------------------------------------------------------------- */
jQuery('#mobile-navigation-btn').on("click",function(){
	"use strict";
	//jQuery('.mobile-nav').addClass('show').animate({ right: '0'}, 250, 'easeInCubic');
	//jQuery('body').addClass('expanded').animate({ left: '-300'}, 250, 'easeInCubic');
	jQuery('#mobile-navigation').stop(true,true).slideToggle(250, 'easeOutBack'); //easeInOutSine works also nice at 200ms
		return false;
});

jQuery('.close-mobile-nav').on("click",function(){
	"use strict";
	jQuery('.mobile-nav').removeClass('show').animate({ right: '-300'}, 200, 'easeOutCubic');
	//jQuery('body').removeClass('expanded').animate({ left: '0'}, 200, 'easeOutCubic');
});

jQuery('#mobile-navigation .container ul li').each(function(){
	if(jQuery(this).find('> ul').length > 0) {
		 jQuery(this).addClass('has-ul');
		 jQuery(this).find('> a').append('<i class="fa fa-angle-down"></i>');
	}
});
	
jQuery('#mobile-navigation ul li:has(">ul") > a i').click(function(){
	jQuery(this).parent().parent().toggleClass('open');
	jQuery(this).parent().parent().find('> ul').stop(true,true).slideToggle(300, 'easeOutBack');
	return false;
});

/* ---------------------------------------------------------------- */
/* Document Ready
/* ---------------------------------------------------------------- */

//Variables for sticky navigation
var yogax_scrollHeight = 500,
    yogax_nav,
    yogax_navOuterHeight,
    yogax_navScrolled = false,
    yogax_navFixed = false,
    yogax_outOfSight = false,
    yogax_scrollTop = 0;

jQuery(document).ready(function($) {
	"use strict";
	
	// Update scroll variable for scrolling functions
    addEventListener('scroll', function() {
        yogax_scrollTop = window.pageYOffset;
    }, false);
    
        
	// Fix nav to top while scrolling
    yogax_nav = $('body .sticky-nav:first');
    yogax_navOuterHeight = $('body header:first').outerHeight();
    window.addEventListener("scroll", stickyNav, false);
    
	// Dropdown Nav Menu
	$('.nav-menu ul li').on({
        mouseenter: function () {
            //stuff to do on mouse enter
            var sub = $(this).find('.second-lvl');
    		if(sub.length > 0 && $(window).width() > 979) {
    			sub.stop().fadeIn(300, 'easeOutCubic');
    		}
        },
        mouseleave: function () {
            //stuff to do on mouse leave
            var sub = $(this).find('.second-lvl');
    		if(sub.length > 0 && $(window).width() > 979) {
    			sub.stop().fadeOut(150, 'easeOutCubic');
    		}
        }
    });
    
    $('.timetable-tabs').tabs();  

	// Dropdown Nav Menu
	$(".responsive-menu .nav-menu").hide();
    $(".toggle-menu").on("click",function() {
        $(".responsive-menu .nav-menu").slideToggle(500);
    });
    
	// Mega Menu Background Image
	$('.mega-menu').each(function(){
		var menuBackground = ($(this).attr("data-background-image")) ? ($(this).attr("data-background-image")) : '',
			menuBackgroundPos = ($(this).attr("data-background-pos")) ? ($(this).attr("data-background-pos")) : '';
		$(this).find('.second-lvl').css({
			'background-image' : 'url('+menuBackground+')',
			'background-position' : menuBackgroundPos,
		});
	});
	
	flexsliderLoad();
	
	//Masonry Blog
	var $blogcontainer = $('.blog-masonry');

	$blogcontainer.imagesLoaded( function() {
			setTimeout(function(){
		        $blogcontainer.isotope({ layoutMode : 'masonry', itemSelector: '.masonry-item' });
				$blogcontainer.animate({'opacity' : 1}, 600);
				flexsliderLoad();
		    }, 500);
	    });
	    
	// Append .background-image-holder <img>'s as CSS backgrounds
    $('.background-image-holder').each(function() {
        var imgSrc = $(this).children('img').attr('src');
        $(this).css('background', 'url("' + imgSrc + '")');
        $(this).children('img').hide();
        $(this).css('background-position', 'initial');
    });
    
    // Fade in background images
    setTimeout(function() {
        $('.background-image-holder').each(function() {
            $(this).addClass('fadeIn');
        });
    }, 200);
    
    // Number Field Stepper
  	jQuery('.qty').bootstrapNumber({
		upClass: 'plus',
		downClass: 'minus'
	});
	
	jQuery('a.lightbox').nivoLightbox({
		effect: 'fade',                             // The effect to use when showing the lightbox
		theme: 'default',                           // The lightbox theme to use
		keyboardNav: true,                          // Enable/Disable keyboard navigation (left/right/escape)
		clickOverlayToClose: true,                  // If false clicking the "close" button will be the only way to close the lightbox
	});
	
	/*---------------------------------------------- 
				   	 P A R A L L A X
	------------------------------------------------*/
	if(jQuery().parallax) { 
		jQuery('.parallax-section').parallax();
	}
	
	//Button glow for default contact form and comments button
	jQuery('.wpcf7-form').find('input[type="submit"]').each(function() {
      jQuery(this).replaceWith(jQuery('<button type="submit" />').append('<span>'+this.value+'</span>').addClass(jQuery(this).get(0).className));
    });
    
    jQuery('.comment-form').find('input[type="submit"]').each(function() {
      jQuery(this).replaceWith(jQuery('<button type="submit" />').append('<span>'+this.value+'</span>').addClass(jQuery(this).get(0).className));
    });
    
});
/* ---------------------------------------------------------------- */
/* Top of Page Link
/* ---------------------------------------------------------------- */

jQuery(window).load(function() {
    animateOnScroll();
});

jQuery(window).scroll(function () {
	"use strict";
	if (jQuery(this).scrollTop() > 300) {
		jQuery('#go-top').fadeIn();
	} else {
		jQuery('#go-top').fadeOut();
	}
	
	animateOnScroll();
});

jQuery('#go-top').on("click",function () {
	"use strict";
	jQuery("html, body").animate({ scrollTop: 0 }, 600, "easeInOutExpo");
	return false;
});

/* ---------------------------------------------------------------- */
/* Smooth scroll to inner links
/* ---------------------------------------------------------------- */
jQuery('nav a[href^="#"]:not(a[href="#"]), a.btn[href^="#"], .ttbase-intro-header a[href^="#"]').smoothScroll({
    offset: -350,
    speed: 800
});
	
/* ---------------------------------------------------------------- */
/* Forms
/* ---------------------------------------------------------------- */
jQuery('.wpcf7-acceptance').parent().addClass('checkbox-option acceptance').prepend('<div class="outer"><div class="inner" /></div>');
jQuery('.gfield_radio li').addClass('radio-option').prepend('<div class="outer"><div class="inner" /></div>');
jQuery('select').wrap('<div class="select-option" />').parent().prepend('<i class="fa fa-angle-down"></i>');
jQuery(":file").filestyle({buttonName: "btn-primary", icon: false});

	
// Checkboxes
jQuery('.checkbox-option.acceptance').click(function () {
    jQuery(this).closest('form').wpcf7ToggleSubmit();
});

// Radio Buttons
jQuery('.gfield_radio .radio-option').click(function() {
    jQuery(this).closest('.gfield_radio').find('.radio-option').removeClass('checked');
    jQuery(this).addClass('checked');
    jQuery(this).find('input').prop('checked', true);
});

/* do animations if element is visible
------------------------------------------------*/
function animateOnScroll() {
	
	/* has-animation elements */
	jQuery('.has-animation').each(function() {
		var thisItem = jQuery(this);
		if (jQuery(window).width() > 1024) {
			var visible = thisItem.visible(true);
			var delay = thisItem.attr("data-delay");
			if (!delay) { delay = 0; }
			if (thisItem.hasClass( "animated" )) {} 
			else if (visible) {
				thisItem.delay(delay).queue(function(){thisItem.addClass('animated');});
			}
		} else {
			thisItem.addClass('animated');	
		}
	});
}
/* do animations function
------------------------------------------------*/

//Function for sticky nav
function stickyNav() {

    var scrollY = yogax_scrollTop;

    if (scrollY <= 0) {
        if (yogax_navFixed) {
            yogax_navFixed = false;
            yogax_nav.removeClass('fixed');
        }
        if (yogax_outOfSight) {
            yogax_outOfSight = false;
            yogax_nav.removeClass('nav-hide');
        }
        if (yogax_navScrolled) {
            yogax_navScrolled = false;
            yogax_nav.removeClass('scrolled');
        }
        return;
    }

    if (scrollY > yogax_scrollHeight) {
        if (!yogax_navScrolled) {
            yogax_nav.addClass('scrolled');
            yogax_navScrolled = true;
            return;
        }
    } else {
        if (scrollY > yogax_navOuterHeight) {
            if (!yogax_navFixed) {
                yogax_nav.addClass('fixed');
                yogax_navFixed = true;
            }

            if (scrollY > yogax_navOuterHeight * 2) {
                if (!yogax_outOfSight) {
                    yogax_nav.addClass('nav-hide');
                    yogax_outOfSight = true;
                }
            } else {
                if (yogax_outOfSight) {
                    yogax_outOfSight = false;
                    yogax_nav.removeClass('nav-hide');
                }
            }
        } else {
            if (yogax_navFixed) {
                yogax_navFixed = false;
                yogax_nav.removeClass('fixed');
            }
            if (yogax_outOfSight) {
                yogax_outOfSight = false;
                yogax_nav.removeClass('nav-hide');
            }
        }

        if (yogax_navScrolled) {
            yogax_navScrolled = false;
            yogax_nav.removeClass('scrolled');
        }

    }
}

//Function for blog flexslider
function flexsliderLoad() {

     jQuery('.flexslider').flexslider({
        selector: ".slides > li",
        animation: "slide", 
        prevText: "",
        nextText: "",
        easing: "easeOutQuad", 
        smoothHeight: true,
        pauseOnHover: true,
        animationSpeed: 300
    });

}



//Disabled because input fields are not working on touch devices

// jQuery('body').on('touchstart', function(e) {
//     jQuery('input, textarea').css("pointer-events","auto");
// });
// jQuery('body').on('touchmove', function(e) {
//     jQuery('input, textarea').css("pointer-events","none");
// });
// jQuery('body').on('touchend', function(e) {
//     setTimeout(function() {
//         jQuery('input, textarea').css("pointer-events", "none");
//     },0);
// });

