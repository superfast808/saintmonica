function setCookie(c_name,value,exdays)
{
    "use strict";
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=window.escape(value) + ((exdays===null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function resizeVideo(){
  "use strict";
	if(jQuery('.embedded_videos').length){
    
    var iframe_width;
    if( jQuery('.embedded_videos').parent().width() < 685){
      iframe_width = jQuery('.embedded_videos').parent().width();
    }else{
      iframe_width = 685;
    }
    jQuery('.embedded_videos iframe').each(function(){
      var iframe_height = iframe_width/1.5;  
      jQuery(this).attr('width',iframe_width);
      jQuery(this).attr('height',iframe_height);
    });

    jQuery('.embedded_videos div.video-js ').each(function(){
      var iframe_height = iframe_width/1.5;  

      jQuery(this).attr('width',iframe_width);
      jQuery(this).attr('height',iframe_height);
      jQuery(this).css('width',iframe_width);
      jQuery(this).css('height',iframe_height);
    });
  }
}


/* Mobile menu */


(function(jQuery){
  "use strict";
jQuery.fn.mobileMenu = function(options) {

  var defaults = {
      defaultText: mobile_menu_title.mobile_menu_title,
      className: 'select-menu',
      subMenuClass: 'sub-menu',
      subMenuDash: '&ndash;'
    },
    settings = jQuery.extend( defaults, options ),
    el = jQuery(this);

  this.each(function(){
    // ad class to submenu list
    el.find('ul').addClass(settings.subMenuClass);

    // Create base menu
    jQuery('<select />',{
      'class' : settings.className
    }).insertAfter( el );

    // Create default option
    jQuery('<option />', {
      "value"   : '#',
      "text"    : settings.defaultText
    }).appendTo( '.' + settings.className );

    // Create select option from menu
    el.find('a').each(function(){

      var el_text;

      if(jQuery(this).html().indexOf("<span>") !== -1){
        el_text = jQuery(this).html().replace(/<span>.*<\/span>/gi,'');
      } else{
        el_text = jQuery(this).text();
      }

      
      
      var $this   = jQuery(this),
          optText = '&nbsp;' + el_text,
          optSub  = $this.parents( '.' + settings.subMenuClass ),
          len     = optSub.length,
          dash;

      // if menu has sub menu
      if( $this.parents('ul').hasClass( settings.subMenuClass ) ) {
        dash = new Array( len+1 ).join( settings.subMenuDash );
        optText = dash + optText;
      }

      // Now build menu and append it
      jQuery('<option />', {
        "value" : this.href,
        "html"  : optText  
      }).appendTo( '.' + settings.className );

    }); // End el.find('a').each

    // Change event on select element
    jQuery('.' + settings.className).change(function(){
      var locations = jQuery(this).val();
      if( locations !== '#' ) {
        window.location.href = jQuery(this).val();
      }
    });

  }); // End this.each

  return this;

};
})(jQuery);

function elastislide_carousel(){
  "use strict";
  var slide_margin = 0;
  jQuery('.ourcarousel').elastislide({
      margin : slide_margin,
      imageW    : jQuery('.ourcarousel .es-carousel').width(),
      minItems  : 1
  });

    //slideshow single carousel
    var the_width;
    
    if(jQuery('.es-carousel > ul > li').length){
        the_width = jQuery('.es-carousel > ul > li').width(); /*for list view thumbs*/
    }else{
        the_width = 1140; /*for single page*/
    } 

    /*for single page*/
    jQuery('article.post .featimg .single_carousel').elastislide({
        margin : 0 ,
        imageW  : 1140
    });

    var timeline_width;

    if(jQuery('.timeline-view article .entry-image').length){
        timeline_width = jQuery('.timeline-view article .entry-image').width();
    }else{
        timeline_width = 825;
    }

    jQuery('.timeline-view .single_carousel').elastislide({
        margin : 0 ,
        imageW  : timeline_width
    });  

    var list_width;
    if(jQuery('.list-view  article.list-medium-image .single_carousel, .list-view article.list-small-image .single_carousel').length){
        list_width = jQuery('.list-view .element .single_carousel, .list-view .full-thumb-article .single_carousel').width();
    }else{
        list_width = 825;
    }

    jQuery('.list-view  article.list-medium-image .single_carousel, .list-view article.list-small-image .single_carousel').elastislide({
        margin : 0 ,
        imageW  : list_width
    });  

    var grid_width;
    if(jQuery('.grid-view .masonry_elem').length){
        grid_width = jQuery('.grid-view .masonry_elem').width();
    }else{
        grid_width = 825;
    }

    jQuery(' .grid-view .single_carousel').elastislide({
        margin : 0 ,
        imageW  : grid_width
    });   

    var big_gallery_width;
    if(jQuery('.list-large-image  .featimg').length){
        big_gallery_width = jQuery('.list-large-image .featimg').width();
    }else{
        big_gallery_width = 540;
    } 

    jQuery('.list-large-image .single_carousel').elastislide({
        margin : 0 ,
        imageW  : big_gallery_width
    });
    jQuery('.single_carousel li').each(function() {
        jQuery(this).show();
    });

    jQuery(window).trigger('resize'); /*trigger window resize to fix the carousel */

}

/* Repair thumbs on small size */

function thumbsRepair(){
  "use strict";
  jQuery('.thumb-view').each(function() {
    var this_view = jQuery(this);
    jQuery(this_view).find('article').each(function() {
      var first_elem_settings = jQuery(this).first();
      var elem = jQuery(this);
      var elem_half_height = jQuery(first_elem_settings).height() - 35;
      if(jQuery(elem).width() < '220' && jQuery(elem).is(':visible')){
        jQuery(elem).find('a.format-video, a.format').hide();
        jQuery(elem).find('.top-hover h5').css('margin', '5px 10px 7px 10px');
        jQuery(elem).find('.top-hover h5').css('font-size', '13px');
        jQuery(elem).find('.top-hover span.entry-date').css('padding-left', '10px');
        jQuery(elem).find('.top-hover').height(elem_half_height);
        jQuery(elem).find('.top-hover').css('overflow', 'hidden');
        jQuery(elem).find('.bottom-hover li a span i').css('display', 'none');
      }
      if(jQuery(elem).width() < '130' && jQuery(elem).is(':visible')){
        jQuery(elem).find('.bottom-hover').css('display', 'none');
        jQuery(elem).find('.top-hover').height(elem_half_height + 30);
        jQuery(elem).find('.top-hover h5').css('font-size', '11px');
      }
    });
  });
}

/* ###### Filters ##### */


/* thumbs filter */
jQuery(function(){
    "use strict";
    var $container = jQuery('.filter-on');

    $container.isotope({
      itemSelector : '.masonry_elem'
    });
    
    
    var $optionSets = jQuery('.thumbs-splitter'),
        $optionLinks = $optionSets.find('a');

    $optionLinks.click(function(){
      var $this = jQuery(this);
      // don't proceed if already selected
      if ( $this.hasClass('selected') ) {
        return false;
      }
      var $optionSet = $this.parents('.thumbs-splitter');
      $optionSet.find('.selected').removeClass('selected');
      $this.addClass('selected');

      // make option object dynamically, i.e. { filter: '.my-filter-class' }
      var options = {},
          key = $optionSet.attr('data-option-key'),
          value = $this.attr('data-option-value');
      // parse 'false' as false boolean
      value = value === 'false' ? false : value;

      options[ key ] = value;
      $container.isotope( options );
      
      return false;
  });
});

/* grid / list switch */




function viewPort(){ 
  "use strict";
  /* Determine screen resolution */
  //var $body = jQuery('body');
  var wSizes = [1200, 960, 768, 480, 320, 240];
  
  //$body.removeClass(wSizesClasses.join(' '));
  var size = jQuery(window).width();
  //alert(size);
  for (var i=0; i<wSizes.length; i++) { 
    if (size >= wSizes[i] ) { 
      //$body.addClass(wSizesClasses[i]);

      
      jQuery('.cosmo-comments .fb_iframe_widget iframe,.cosmo-comments .fb_iframe_widget span').css({'width':jQuery('.cosmo-comments.twelve.columns').width() });   
      
      break;
    }
  }

    if(typeof(FB) !== 'undefined' ){
        window.fbAsyncInit = function() {
            FB.Event.subscribe('xfbml.render', function(response) {
                FB.Canvas.setAutoGrow();
            });
        };
    }
  /** Mobile/Default      -   320px
 * Mobile (landscape)  -   480px
 * Tablet              -   768px
 * Desktop             -   960px
 * Widescreen          -   1200px
 * Widescreen HD       -   1920px*/
  
}

//init menu - you need just to give him the menu class
function initMenu(menu){
  "use strict";
  jQuery(menu).supersubs({ 
        minWidth:    14,   // minimum width of sub-menus in em units 
        maxWidth:    35,   // maximum width of sub-menus in em units
        animation: {height:'show'}   // slide-down effect without fade-in 
                           // due to slight rounding differences and font-family 
    }).superfish({
      dropShadows:   false
    });  // call supersubs first, then superfish, so that subs are 
   // not display:none when measuring. Call before initialising 
   // containing tabs for same reason. 
}

function initTestimonialsCarousel(){
  "use strict";
  //jQuery('.testimonials-view ul.testimonials-carousel').height(jQuery('.testimonials-carousel-elem.active').height());

  jQuery('.testimonials-view ul.testimonials-carousel, .widget ul.testimonials-carousel').each(function(){
    if(jQuery(this).children().length<=1){
      jQuery('.testimonials-carousel-nav', jQuery(this).parent()).css('display', 'none');
    }
  });

  

  jQuery('.testimonials-view ul.testimonials-carousel-nav > li, .widget ul.testimonials-carousel-nav > li').click(function(){
    var thisElem = jQuery(this);
    var thisTestimonialContainer = jQuery(this).parent().parent();
    var activeTestimonial = jQuery('.testimonials-carousel-elem.active', thisTestimonialContainer);
    var indexOfActiveElem = jQuery('.testimonials-carousel-elem', thisTestimonialContainer).index(jQuery('.testimonials-carousel-elem.active', thisTestimonialContainer));

    var listOfTestimonials = jQuery('.testimonials-carousel-elem', thisTestimonialContainer).toArray();
    var lengthOfList = listOfTestimonials.length-1;
    var IndexOfNextTestimonial;
    var IndexOfPrevTestimonial;
    var nextTestimonial;
    var prevTestimonial;


    if(indexOfActiveElem+1 > lengthOfList){
      IndexOfNextTestimonial = 0;
    }else{
      IndexOfNextTestimonial = indexOfActiveElem+1;
    }

    if(indexOfActiveElem-1 < 0){
      IndexOfPrevTestimonial = lengthOfList;
    }else{
      IndexOfPrevTestimonial = indexOfActiveElem-1;
    }

    nextTestimonial = listOfTestimonials[IndexOfNextTestimonial];
    prevTestimonial = listOfTestimonials[IndexOfPrevTestimonial];


    if( thisElem.hasClass('testimonials-carousel-nav-left') ){

      activeTestimonial.fadeOut('fast', function(){
        activeTestimonial.removeClass('active');
        jQuery(prevTestimonial).addClass('active');
        jQuery(prevTestimonial).fadeIn();
      });

    }else{

      activeTestimonial.fadeOut('fast', function(){
        activeTestimonial.removeClass('active');
        jQuery(nextTestimonial).addClass('active');
        jQuery(nextTestimonial).fadeIn();
      });

    }
  });

}

/* init slideshow function */
jQuery.fn.initSlideShow = function(userOptions){
  "use strict";
  var animationFinished = true;
  var defaults = {
    autoPlay:true,
    slideSpeed: 5, 
    transitionSpeed: 1
  };

  if(userOptions.slideSpeed>10 || userOptions.slideSpeed < 0.5){
    userOptions.slideSpeed = defaults.slideSpeed;
  }

  if(userOptions.transitionSpeed>10 || userOptions.transitionSpeed < 0.5){
    userOptions.transitionSpeed = defaults.transitionSpeed;
  }

  var options = jQuery.extend({}, defaults, userOptions);

  if(options.autoPlay){
    autoPlayLoop();
  }

  function autoPlayLoop(){
    var curentSlideId = jQuery('.header-slideshow-navigation-elem.active').data('slide');
    var nextSlideId = curentSlideId + 1;
    var nextSlide = jQuery('.header-slideshow-navigation-elem[data-slide='+nextSlideId+']');

    if(nextSlide.length>0){
      nextSlide.trigger('click');
      setTimeout(function(){
        autoPlayLoop();
      }, options.slideSpeed*1000);
    }else{
      nextSlide = jQuery('.header-slideshow-navigation-elem')[0];
      jQuery(nextSlide).trigger('click');
      setTimeout(function(){
        autoPlayLoop();
      }, options.slideSpeed*1000);
    }
  }

  jQuery('.header-slideshow-elem-content.active').fadeIn(options.transitionSpeed*1000);

  jQuery('.header-slideshow-navigation').prependTo('.main-container-wrapper').css('display','block');
  jQuery('.header-slideshow-captions').prependTo('.main-container-wrapper').css('display','block');

    jQuery('.header-slideshow-navigation-elem').click(function(){
        var thisElem = jQuery(this);
        var activeButton = jQuery('.header-slideshow-navigation-elem.active');
        var activeElem = jQuery('.header-slideshow-elem.active');
        var clickedId = thisElem.data('slide');
        var clickedElem = jQuery('.header-slideshow-elem[data-slide='+clickedId+']');
        var activeCaption = jQuery('.header-slideshow-elem-content.active');
        var clickedCaption = jQuery('.header-slideshow-elem-content[data-slide='+clickedId+']');

        if(animationFinished){
          if(activeElem.data('slide')!==clickedElem.data('slide')){

            activeButton.removeClass('active');
            thisElem.addClass('active');
            clickedElem.css('display','list-item');

            animationFinished = false;

            activeCaption.removeClass('active').fadeOut(options.transitionSpeed*1000,function(){
              clickedCaption.fadeIn(options.transitionSpeed*1000,function(){
                jQuery(this).addClass('active');
                animationFinished = true;
              });
            });

            activeElem.fadeOut(options.transitionSpeed*1000,function(){
              activeElem.removeClass('active');
              clickedElem.addClass('active');
            });
          }
        }
    });
};


function initCarousel(){
"use strict";
  jQuery('.carousel-wrapper').each(function(){
    var thisElem = jQuery(this);
    var numberOfElems = parseInt(jQuery('.carousel-container', thisElem).children().length, 10);
    var oneElemWidth;
    var numberOfColumns = [['two',6],['three',4],['four',3],['six',2]];
    var curentNumberOfColumns;
    var moveMargin;
    var leftHiddenElems = 0;
    var rightHiddenElems; 
    var curentMargin = 0;
    var numberOfElemsDisplayed;
    var index = 0;
    var carouselContainerWidth;
    var carouselContainerWidthPercentage;
    var elemWidth;
    var elemWidthPercentage;

    while( index < numberOfColumns.length){
      if ( jQuery('.carousel-container>.columns', thisElem).hasClass(numberOfColumns[index][0]) ){
        curentNumberOfColumns = numberOfColumns[index][1];
        break;
      }
      index ++;
    }

    elemWidth = 100/numberOfElems;
    elemWidth = elemWidth.toFixed(4);
    elemWidthPercentage = elemWidth + '%';

    reinitCarousel();

    jQuery(window).resize(function() {
      reinitCarousel();
    });

    function showHideArrows(){
      if(curentNumberOfColumns>=numberOfElems){
        jQuery('ul.carousel-nav > li.carousel-nav-left', thisElem).css('display','none');
        jQuery('ul.carousel-nav > li.carousel-nav-right', thisElem).css('display','none');
      }else if(curentMargin===0){
        jQuery('ul.carousel-nav > li.carousel-nav-left', thisElem).css('display','none');
        jQuery('ul.carousel-nav > li.carousel-nav-right', thisElem).css('display','block');
      }else if(rightHiddenElems===0){
        jQuery('ul.carousel-nav > li.carousel-nav-left', thisElem).css('display','block');
        jQuery('ul.carousel-nav > li.carousel-nav-right', thisElem).css('display','none');
      }else{
        jQuery('ul.carousel-nav > li.carousel-nav-left', thisElem).css('display','block');
        jQuery('ul.carousel-nav > li.carousel-nav-right', thisElem).css('display','block');
      }
    }

    function reinitCarousel(){

      showHideArrows();

      jQuery('.carousel-container', thisElem).css('margin-left',0);
      leftHiddenElems = 0;
      jQuery('ul.carousel-nav > li', thisElem).unbind('click');

      if(jQuery(window).width()<=767){

        carouselContainerWidth = 100 * numberOfElems;
        carouselContainerWidthPercentage = carouselContainerWidth + '%';
        rightHiddenElems = numberOfElems - 1;
        moveMargin = 100;

        curentMargin = 0;

        jQuery('ul.carousel-nav > li', thisElem).unbind('click');

        jQuery('ul.carousel-nav > li', thisElem).click(function(){



          if( jQuery(this).hasClass('carousel-nav-left') ){

            if (leftHiddenElems!==0){

              curentMargin = curentMargin + moveMargin;
              jQuery('.carousel-container', thisElem).css('margin-left',curentMargin+'%');
              rightHiddenElems++;
              leftHiddenElems--;
            }

            showHideArrows();

          }else{

            if (rightHiddenElems!==0){
              curentMargin = curentMargin - moveMargin;
              jQuery('.carousel-container', thisElem).css('margin-left', curentMargin+'%');
              rightHiddenElems--;
              leftHiddenElems++;
            }

            showHideArrows();

          }

        });

      }else{

        while( index < numberOfColumns.length){
          if ( jQuery('.carousel-container>.columns', thisElem).hasClass(numberOfColumns[index][0]) ){
            numberOfElemsDisplayed = numberOfColumns[index][1];
            moveMargin = 100/numberOfElemsDisplayed;
            rightHiddenElems = numberOfElems - numberOfElemsDisplayed;
            oneElemWidth = 100 / numberOfColumns[index][1];
            break;
          }
          index ++;
        }

        carouselContainerWidth = oneElemWidth * numberOfElems;
        carouselContainerWidthPercentage  = carouselContainerWidth + '%';

        curentMargin = 0;

        jQuery('ul.carousel-nav > li', thisElem).click(function(){

          if( jQuery(this).hasClass('carousel-nav-left') ){

            if (leftHiddenElems!==0){
              curentMargin = curentMargin + moveMargin;
              jQuery('.carousel-container', thisElem).css('margin-left',curentMargin+'%');
              rightHiddenElems++;
              leftHiddenElems--;
            }

            showHideArrows();

          }else{

            if (rightHiddenElems!==0){
              curentMargin = curentMargin - moveMargin;
              jQuery('.carousel-container', thisElem).css('margin-left', curentMargin+'%');
              rightHiddenElems--;
              leftHiddenElems++;
            }

            showHideArrows();

          }

        });

      }

      //set container width
      jQuery('.carousel-container', thisElem).width(carouselContainerWidthPercentage).css({'max-height':'999px', 'opacity':'1'});


      //set eachelem width
      jQuery('.carousel-container>.columns', thisElem).each(function(){
        jQuery(this).attr('style','width: '+elemWidthPercentage+' !important; float:left;');
      });
      
    }

  });
}

function initHeaderVerticalAlign(){
    "use strict";
    if(jQuery(window).width()>768){
        jQuery('header#header-container .align-middle').each(function(){
            var thisElem = jQuery(this);

            var parentHeight = thisElem.parent().parent().innerHeight();
            var selfHeight = thisElem.innerHeight();
            var margintop = (parentHeight/2) - (selfHeight/2);

            thisElem.css('margin-top',margintop);
        });

        jQuery('header#header-container .align-bottom').each(function(){
            var thisElem = jQuery(this);

            var parentHeight = thisElem.parent().parent().innerHeight();
            var selfHeight = thisElem.innerHeight();
            var margintop = parentHeight - selfHeight;

            thisElem.css('margin-top',margintop);
        }); 
    }
}

/*==========================================BOF Pretty Photo Settings===============================*/

if (prettyPhoto_enb.enb_lightbox) { 
    jQuery(document).ready(function(){
    "use strict";
        /* show images inserted in gallery */
        jQuery("a[rel^='prettyPhoto']").prettyPhoto({
              autoplay_slideshow: false,
              theme: 'light_square',
              social_tools:false,
              deeplinking: false 

        });

        /* show images inserted into post in LightBox */
        jQuery("[class*='wp-image-']").parents('a').not("a[rel^='attachment']").prettyPhoto({
              autoplay_slideshow: false,
              theme: 'light_square',
              deeplinking: false 

        });
    });
}

/*==========================================EOF Pretty Photo Settings===============================*/

function showDiv()
{
  jQuery(".ourcarousel ul").show('slow');
}

jQuery( window ).load( function(){
    "use strict";
    initTestimonialsCarousel();
    initCarousel();
    elastislide_carousel();
    setInterval("showDiv()",300);

    jQuery('.header-slideshow-elem:first-child, .header-slideshow-navigation-elem:first-child, .header-slideshow-elem-content:first-child').addClass('active');
    if (typeof slideshowSettings !== 'undefined') {
      jQuery(document).initSlideShow(slideshowSettings);
    }
    jQuery('.filter-on').isotope();

  initHeaderVerticalAlign();

  jQuery("#spinner").animate({ opacity: 0}, 400, function(){
      jQuery(this).css('display','none');
  });
});


jQuery(document).ready(function(){

  /*Tweets widget*/
  "use strict";
    var delay = 4000; //millisecond delay between cycles
    function cycleThru(variable, j){
    var jmax = jQuery(variable + " div").length;
    jQuery(variable + " div:eq(" + j + ")")
        .css('display', 'block')
        .animate({opacity: 1}, 600)
        .animate({opacity: 1}, delay)
        .animate({opacity: 0}, 800, function(){
            if(j+1 === jmax){
                j=0;
            }else{
                j++;
            }

            jQuery(this).css('display', 'none').animate({opacity: 0}, 10);
            cycleThru(variable, j);
        });
    }
         
  jQuery('.tweets').each(function(index, val) {
   //iterate through array or object
   var parent_tweets = jQuery(val).parent().attr('id');
   var actioner = '#' + parent_tweets + ' .tweets .dynamic .cosmo_twitter .slides_container';
   cycleThru(actioner, 0);
  });


  /* list view tabs */

  jQuery('.tabment-tabs li:first-child a').addClass('active'); // Set the class for active state
  jQuery('.tabment-tabs li a').click(function( event ){ // When link is clicked
    if(!jQuery(this).hasClass('active')){
      var tabment_id = jQuery(this).attr('href'); // Set currentTab to value of href attribute
      jQuery(this).parent().parent().find('.active').removeClass('active');
      jQuery(this).parent().parent().parent().parent().next().find('.tabment-tabs-container').find('li.tabs-container').hide();
      jQuery(this).parent().parent().parent().parent().next().find('.tabment-tabs-container').find(tabment_id).fadeIn(500);
      jQuery(window).trigger('resize');
      jQuery(this).addClass('active');
    }
    event.preventDefault();
    return false;
  });

  jQuery('.menu nav.main-menu').mobileMenu();
  jQuery('.top_menu nav.top-menu').mobileMenu({
      defaultText: 'Top menu',
      className: 'mobile-select-top-sub-menu',
      subMenuDash: '&ndash;'
    });
  jQuery('.mobile-login-menu li.signin').mobileMenu({
      defaultText: 'User menu',
      className: 'mobile-select-sub-menu',
      subMenuDash: '&ndash;'
  });

  /* Masonry */
  jQuery( window ).resize( function(){
      if( jQuery(window).width() > 767 ){
          jQuery('.masonry').isotope({
              // options
              itemSelector : '.masonry .masonry_elem'
          });
      }
  });

  /* Related tabs */
  jQuery('.related-tabs li a').click(function(){
      if(!jQuery(this).parent().hasClass('active')){
        var element_id =  jQuery(this).attr('href');
        jQuery(this).parents('li').parent().find('.active').removeClass('active');
        jQuery(this).parents('li').addClass('active');
        jQuery(this).parents('li').parent().next().find(' > div:visible').fadeOut(400);
        jQuery(this).parents('li').parent().next().find(element_id).delay(400).fadeIn(400,function(){
            jQuery(window).trigger('resize');  
        });
        thumbsRepair();
      }
      return false;
  });

  thumbsRepair();
 
  /*right side meta*/
  jQuery('.metas').hover(function(){
      jQuery(this).addClass('flip');
      if (jQuery.browser.opera || jQuery.browser.msie) {
        jQuery(this).addClass('flip-shitty-browser');
      }
  },function(){
      jQuery(this).removeClass('flip');
      if (jQuery.browser.opera || jQuery.browser.msie) {
        jQuery(this).removeClass('flip-shitty-browser');
      }
  });


  jQuery('.tabs-controller > li > a').click(function(){
      var this_id = jQuery(this).attr('href'); // Get the id of the div to show
      var tabs_container_divs = '.' + jQuery(this).parent().parent().next().attr('class') + ' >  div'; // All of elements to hide
      jQuery(tabs_container_divs).hide(); // Hide all other divs
      jQuery(this).parent().parent().next().find(this_id).show(); // Show the selected element
      jQuery(this).parent().parent().find('.active').removeClass('active'); // Remove '.active' from elements
      jQuery(this).addClass('active'); // Add class '.active' to the active element
      return false;
  }); 

	/*resize FB comments depending on viewport*/

	setTimeout(function(){
        viewPort();
    },3000); 
	
	resizeVideo();

	jQuery( window ).resize( function(){
     viewPort();
     resizeVideo();
  });
	
	/* Accordion */
	jQuery('.cosmo-acc-container').hide();
	jQuery('.cosmo-acc-trigger:first').addClass('active').next().show();
	jQuery('.cosmo-acc-trigger').click(function(){
		if( jQuery(this).next().is(':hidden') ) {
			jQuery('.cosmo-acc-trigger').removeClass('active').next().slideUp();
			jQuery(this).toggleClass('active').next().slideDown();
		}
		return false;
	});

    
	/* Hide Tooltip */
	jQuery(function() {
		jQuery('a.close').click(function() {
			jQuery(jQuery(this).attr('href')).slideUp();
            jQuery.cookie(cookies_prefix + "_tooltip" , 'closed' , {expires: 365, path: '/'});
            jQuery('.header-delimiter').removeClass('hidden');
			return false;
		});
	});
	
	

  /* initialize tabs */
  jQuery('.cosmo-tabs').each(function(){
    // Set default active classes
    jQuery(this).find('.tabs-container').not(':first').css('display','none');
    jQuery(this).find('ul li:first').addClass('tabs-selected');

     jQuery(this).find('ul li a').click(function(){
      if( jQuery(this).parent().hasClass('tabs-selected') ){
        return false;
      }
      var tabId = jQuery(this).attr('href');

      // We clear all active clasees
      jQuery(this).parent().parent().find('.tabs-selected').removeClass('tabs-selected');


      jQuery(this).parent().addClass('tabs-selected');
      jQuery(this).parents('.cosmo-tabs').find('.tabs-container').not(tabId).css('display','none');
      jQuery(this).parents('.cosmo-tabs').find(tabId).css('display','block');
      return false;
    })

  });
	
  

	jQuery(window).on('resize load orientationChanged', function() {
        // do your stuff here
        if(jQuery(this).width() < 767){
            jQuery('#access').addClass('hide');
            jQuery('#d-menu').addClass('hide');
            jQuery('.mobile-menu').removeClass('hide');
            jQuery('.mobile-menu').css('display','block');
        } else{
            jQuery('#access').removeClass('hide');
            jQuery('#d-menu').removeClass('hide');
            jQuery('.mobile-menu').css('display','none');
            jQuery('.mobile-menu').addClass('hide');
        }
    });
	
	jQuery(document).ready(function() {
		jQuery('aside.widget').append('<div class="clear"></div>');
	});

	/* Mobile responsiveness */
    jQuery(window).on('resize load orientationChanged', function() {
        // do your stuff here
        if(jQuery(this).width() < 767){
            jQuery('#d-menu').addClass('hide');
            jQuery('.mobile-menu').removeClass('hide');
            jQuery('.mobile-menu').css('display','block');
            jQuery('.keyboard-demo').css('display','none');
        } else{
            jQuery('#d-menu').removeClass('hide');
            jQuery('.mobile-menu').css('display','none');
            jQuery('.mobile-menu').addClass('hide');
            jQuery('.keyboard-demo').css('display','block');
        }
    });

    /* widget tabber */
    jQuery( 'ul.widget_tabber li a' ).click(function(){
        jQuery(this).parent('li').parent('ul').find('li').removeClass('active');
        jQuery(this).parent('li').parent('ul').parent('div').find( 'div.tab_menu_content.tabs-container').fadeTo( 200 , 0 );
        jQuery(this).parent('li').parent('ul').parent('div').find( 'div.tab_menu_content.tabs-container').hide();
        jQuery( jQuery( this ).attr('href') + '_panel' ).fadeTo( 600 , 1 );
        jQuery( this ).parent('li').addClass('active');
    });
	
		
    /*toogle*/
    /*Case when by default the toggle is closed */
  jQuery('.open_title').click(function(){
    if (jQuery(this).find('a').hasClass('show')) {
      jQuery(this).find('a').removeClass('show');
      jQuery(this).find('a').addClass('toggle_close'); 
      jQuery(this).find('.title_closed').hide();
      jQuery(this).find('.title_open').show();
    } else {
      jQuery(this).find('a').removeClass('toggle_close');
      jQuery(this).find('a').addClass('show');     
      jQuery(this).find('.title_open').hide();
      jQuery(this).find('.title_closed').show();
    }
    jQuery('.cosmo-toggle-container').slideToggle("slow");
  });
  
    /*Case when by default the toggle is oppened */
  jQuery('.close_title').click(function(){
    if (jQuery(this).find('a').hasClass('hide')) {
      jQuery(this).find('a').removeClass('toggle_close');
      jQuery(this).find('a').addClass('show');     
      jQuery(this).find('.title_open').hide();
      jQuery(this).find('.title_closed').show();
    } else {
      jQuery(this).find('a').removeClass('show');
      jQuery(this).find('a').addClass('toggle_close');
      jQuery(this).find('.title_closed').hide();
      jQuery(this).find('.title_open').show();
    }
    jQuery('.cosmo-toggle-container').slideToggle("slow");
  });
  
  /*Accordion*/
  jQuery('.cosmo-acc-container').hide();
  jQuery('.cosmo-acc-trigger:first').addClass('active').next().show();
  jQuery('.cosmo-acc-trigger').click(function(){
  if( jQuery(this).next().is(':hidden') ) {
    jQuery('.cosmo-acc-trigger').removeClass('active').next().slideUp();
    jQuery(this).toggleClass('active').next().slideDown();
  }
  return false;
  });
	
	//Scroll to top
	jQuery(window).scroll(function() {
		if(jQuery(this).scrollTop() !== 0) {
			jQuery('#toTop').fadeIn();	
		} else {
			jQuery('#toTop').fadeOut();
		}
	});
	jQuery('#toTop').click(function() {
		jQuery('body,html').animate({scrollTop:0},300);
	});

  if(navigator.platform.match('Mac') !== null) {
    jQuery(document.body).addClass('OSX');
  }

  initMenu('.menu ul.sf-menu');
  initMenu('.top_menu ul.sf-menu');
});