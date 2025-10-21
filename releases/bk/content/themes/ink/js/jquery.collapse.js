(function($) {
  $.fn.collapserr = function(options) {
    var settings = $.extend({
      sectionSelector: '.collapser',
      speed: 500,
      openClass: 'open',
      closedClass: 'closed'
    }, options);
            
    var $toggle = this;
    var $collapser = $(settings.sectionSelector);
    var $collapserChild = $collapser.children().first();

    var navHeight = function() {
      return ($collapserChild.height() + parseInt($collapserChild.css("padding-top"), 10) + parseInt($collapserChild.css("padding-bottom"), 10)) + "px";
    }

    var openMenu = function() {
      $toggle.addClass(settings.openClass);
      $collapser.addClass(settings.openClass);
      $collapser.stop().animate(
	{ 'max-height': navHeight() },
	settings.speed,
	function() { $collapser.css('max-height', 'none'); }
      );
    }
  
    var closeMenu = function() {
      $collapser
        .stop()
        .css('max-height', $collapser.height());
      
      $toggle.removeClass(settings.openClass);
      $collapser.removeClass(settings.openClass);
      
      $collapser.animate({ 'max-height': 0 }, settings.speed, function() {});
    }

    if ($(this).hasClass(settings.openClass)) {
      openMenu();
    } else {
      closeMenu();  
    }

    $toggle.click(function() {
      if ($(this).hasClass(settings.openClass)) {
        closeMenu();  
      } else {
        openMenu();
      }
    });
    
    return {
      open: openMenu,
      close: closeMenu
    };
  };
})(jQuery);
