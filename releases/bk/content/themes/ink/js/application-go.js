jQuery(document).ready(function($){

  var $inspirationContainer = $('.inspiration-wrapper')

  if ( $inspirationContainer.length ){

    // initialize Isotope for responsive layout using percentages
    $inspirationContainer.isotope({
      resizable: false,
      masonry: { columnWidth: $inspirationContainer.width() / 3 }
    });

    // update columnWidth on window resize
    $(window).smartresize(function(){
      $inspirationContainer.isotope({
        // update columnWidth to a percentage of inspirationContainer width
        masonry: { columnWidth: $inspirationContainer.width() / 3 }
      });
    });

    // filter items when filter link is clicked
    ;(function() {
      var $filters = $("#filters a")

      $filters.click(function(e) {
        e.preventDefault()
        var selector = $(this).attr("data-filter")
        $inspirationContainer.isotope({
          filter: selector,
        })
        $filters.parent("li").removeClass("current")
        $(this)
          .parent("li")
          .addClass("current")
        window.location.hash = removeTypeFromFilterString(selector)
      })

      var filterStrings = []
      $filters.each(function(i, filter) {
        if (filter.getAttribute("data-filter")) {
          filterStrings.push(
            removeTypeFromFilterString(filter.getAttribute("data-filter"))
          )
        }
      })

      var hash = window.location.hash.split("#").join("")
      var selector = ".type-" + hash
      if (filterStrings.indexOf(hash) !== -1) {
        setTimeout(function () {
          $inspirationContainer.isotope({
            filter: selector,
          })
          $filters.parent("li").removeClass("current")
          $("#filters").find("[data-filter='" + selector + "']").parent("li").addClass("current")
        }, 200)
      }

      function removeTypeFromFilterString(str) {
        return str.split(".type-").join("")
      }
    })()

    $(".fancybox").fancybox({
      padding : 0,
      margin : 0,
      helpers : { title : { type : 'inside' } }
    });

  }


  /* -----------------------------------------------------------------------------------------------------------------

    Gallery Toggle

  ----------------------------------------------------------------------------------------------------------------- */

  $('.module-gallery').responsiveSlides({
    auto: false,
    pager: true
  });

  $('.module-gallery').on( 'click', '.toggle', function(){

    var settings = {
      slide_all: false,
      speed: 300
    };

    var $gallery = $(this).parents('.module-gallery').first();
    var $slide = settings.slide_all ? $gallery.find('.slide') : $(this).parents('.slide').first();
    var $contents = $slide.find('.contents');
    var $description = $(this).parents('.slide').first().find('.description');

    function open(){
      $contents.stop();
      $contents.css({ bottom: 'auto', top: 0 });
      $gallery.addClass('open');
      $contents.animate(
        { top: -1 * $description.height() },
        settings.speed,
        function(){
          $contents.css({
            top: '',
            bottom: ''
          });
        }
      );
    }

    // Slide up the active slide down, hide description:
    function close(){
      $contents.stop();
      $contents.css({ top: -1 * $description.height(), bottom: 'auto' });
      $gallery.removeClass('open');
      $contents.animate(
        { top: 0 * $description.height() },
        settings.speed,
        function(){
          $contents.css({
            top: '',
            bottom: ''
          });
        }
      );
    }

    if ( $gallery.hasClass('open') ){
      close();
    } else {
      open();
    }

  });


  $('.module-gallery').on( 'click', '.img img', function(){
    var $gallery = $(this).parents('.module-gallery');
    var $tabs = $gallery.next('ul').find('li');
    var current = $tabs.index( $tabs.filter('li.rslides_here') );

    var ix = current + 1 > $tabs.length - 1 ? 0 : current + 1;

    $tabs.eq( ix ).find('a').trigger('click');
  });

  var scrollToElement = function( elementSelector, topSpacing ){
    var $destination = $(elementSelector);

    if ( ! topSpacing ) topSpacing = 0;

    if ( $destination.length > 0 ){
      var offset = $destination.offset().top *1;
      var margins = parseInt( $destination.css('margin-top'), 10 ) ? parseInt( $destination.css('margin-top'), 10 ) : 0;

      $('html, body').stop().animate({ scrollTop: ( offset - margins - topSpacing ) }, 600);
    }
  };

  /* -----------------------------------------------------------------------------------------------------------------

    FAQ page toggle/collapse

  ----------------------------------------------------------------------------------------------------------------- */

  $('.faq__topic-heading').each(function(){
    $(this).data('instanceOfCollapserr', $(this).collapserr({ sectionSelector : '#' + $(this).attr('data-topicID') }) );
  }).click(function(){
    window.location.hash = '#!' + $(this).attr('id');
  });

  /* -----------------------------------------------------------------------------------------------------------------

    Scroll to FAQ item

  ----------------------------------------------------------------------------------------------------------------- */

  if ( $('#faqpage').length ){
    if ( window.location.hash ){
      if ( window.location.hash.split('#!')[1] !== undefined ){
        var id = window.location.hash.split('#!')[1];
        var $el = $('#'+id);

        if ( $el.length ){
          scrollToElement( '#'+id, 70 );

          setTimeout(function(){ $el.data('instanceOfCollapserr').open(); }, 750);
        }
      }
    }
  }

  $('.js-scroll').click( function(e){
    e.preventDefault();

    scrollToElement( $(this).attr('href') );
  });

  /* -----------------------------------------------------------------------------------------------------------------

    Home

  ----------------------------------------------------------------------------------------------------------------- */

  $('.js-waypoint').waypoint({
    handler: function(direction) {
      if ( direction == 'down'){
        $(this).addClass('active');
      }
      if ( direction == 'up'){
        $(this).removeClass('active');
      }
    },
    offset: '85%'
  });

  $('.carbon-neutral b').waypoint({
    handler: function(direction) {
      if ( direction == 'down'){
        $(this).countTo()
      }
    },
    offset: '85%'
  });

  var $nav_lis = $('.secondary-navigation').find('li');

  $('.waypoint-section')
    .waypoint(
      function(direction) {
        $nav_lis.removeClass('.current');
        var $link = $('a[href="#' + this.id + '"]');
        $link.parent().toggleClass('current', direction === 'down');
      },
      { offset: '5%' }
    )
    .waypoint(
      function(direction) {
      $nav_lis.removeClass('.current');
        var $link = $('a[href="#' + this.id + '"]');
        $link.parent().toggleClass('current', direction === 'up');
      },
      { offset: function() { return -$(this).height() * 0.95; } }
    );

  /* -----------------------------------------------------------------------------------------------------------------

    Cart

  ----------------------------------------------------------------------------------------------------------------- */

  if ( Cookies.enabled ) {

    $('#addtocart').click(function(e){
      e.preventDefault();
      addToCart();
    });

    $('#logcart').click(function(e){
      e.preventDefault();
      logCart();
    });


    if ( $('#cart-basecloths').length ){
      outputCart();
    }

    $('#cart').on( 'click', '.item-remove', function(){
      var $row = $(this).closest('.item-row');
      var index = parseInt($(this).attr('data-cart-index'), 10);

      if ( isNaN(index) ) {
        index = parseInt($row.attr('data-cart-index'), 10);
      }

      if ( isNaN(index) ) {
        index = $row.index();
      }

      removeItemFromCart( index );
    });

    if ( $('#gforms_confirmation_message').length ){
      emptyCart();
      outputCart();
    }

  }

  /* -----------------------------------------------------------------------------------------------------------------

    Pattern customising

  ----------------------------------------------------------------------------------------------------------------- */

  if ( get_default_basecloth_id() ){

    var swatches = [];
    swatches['basecloths'] = all_basecloth_data();
    swatches['colours_1'] = all_colours_1_data();
    swatches['colours_2'] = all_colours_2_data();

    function build_init(){

      if ( ! setupSwatchSelection( swatches ) ){
        notification( { 'message': 'setupSwatchSelection() failed.', 'stateClass': 'error' } );
        return false;
      }

      if ( ! buildSwatches( swatches ) ){
        notification( { 'message': 'buildSwatches() failed.', 'stateClass': 'error' } );
        return false;
      }

      updateBaseclothLabel( swatches, get_current_basecloth_id() );
      updateColourLabel( swatches, 	get_current_colour_1(), 1 );
      updateColourLabel( swatches, 	get_current_colour_2(), 2 );

      if ( ! updatePrices( swatches ) ){
        notification( { 'message': 'updatePrices() failed.', 'stateClass': 'error' } );
        return false;
      }

      if ( ! renderCanvas() ){
        notification( { 'message': 'renderCanvas() failed.', 'stateClass': 'error' } );
        return false;
      }
      update_share_links();
    }

    build_init();

    function refresh_build(){
      if ( ! setupSwatchSelection( swatches ) ){
        notification( { 'message': 'setupSwatchSelection() failed.', 'stateClass': 'error' } );
        return false;
      }
      updateBaseclothLabel( swatches, get_current_basecloth_id() );
      updateColourLabel( swatches, 	get_current_colour_1(), 1 );
      updateColourLabel( swatches, 	get_current_colour_2(), 2 );

      if ( ! updatePrices( swatches ) ){
        notification( { 'message': 'updatePrices() failed.', 'stateClass': 'error' } );
        return false;
      }

      if ( ! renderCanvas() ){
        notification( { 'message': 'renderCanvas() failed.', 'stateClass': 'error' } );
        return false;
      }

      $('#basecloth-swatches').children().removeClass('selected').end().find('[rel="'+get_current_basecloth_id()+'"]').addClass('selected');

      $('#colour-swatches-1').children().removeClass('selected').end().find('[rel="'+get_current_colour_1()+'"]').addClass('selected');

      $('#colour-swatches-2').children().removeClass('selected').end().find('[rel="'+get_current_colour_2()+'"]').addClass('selected');

      update_share_links();

    }

    $('.js-force-rebuild').click(function(e){
      e.preventDefault();
      window.location.href = $(this).attr('href');
      refresh_build();
    });

    $('#basecloth-swatches').on('click', '.basecloth-swatch', function(e){
      e.preventDefault();
      $(this).siblings().removeClass('selected');
      $(this).addClass('selected');
      set_current_basecloth_id( $(this).attr('rel') );
      set_url_params();
      renderCanvas();
      updatePrices();
      updateBaseclothLabel( swatches, $(this).attr('rel') );
      update_share_links();
    });

    $('#colour-swatches-1').on('click', '.colour-swatch', function(e){
      e.preventDefault();
      $(this).siblings().removeClass('selected');
      $(this).addClass('selected');
      set_current_colour_1( $(this).attr('rel') );
      set_url_params();
      renderCanvas();
      updatePrices();
      updateColourLabel( swatches, $(this).attr('rel'), 1 );
    });

    $('#colour-swatches-2').on('click', '.colour-swatch', function(e){
      e.preventDefault();
      $(this).siblings().removeClass('selected');
      $(this).addClass('selected');
      set_current_colour_2( $(this).attr('rel') );
      set_url_params();
      renderCanvas();
      updatePrices();
      updateColourLabel( swatches, $(this).attr('rel'), 2 );
      update_share_links();
    });


    var $fullRepeatModalButton = $(".full-repeat-button");
    var $fullRepeatModal = $(".full-repeat-modal");
    var $fullRepeatCaption = $(".full-repeat-modal-caption");

    var onOpenEnd = function() {
      $fullRepeatModal.off("transitionend", onOpenEnd)
      $fullRepeatModal.removeClass("is-transitioning")
    }

    var onCloseEnd = function() {
      $fullRepeatModal.off("transitionend", onCloseEnd)
      $fullRepeatModal.removeClass("is-transitioning")
      $fullRepeatModal.find("img").removeClass("is-loaded")
      $fullRepeatCaption.text("")
    }

    // Open
    $fullRepeatModalButton.on("click", function() {
      renderFullRepeatCanvas();

      var captionParts = []
      var baseclothTitle = all_basecloth_data()[get_current_basecloth_id()].title
      captionParts.push(baseclothTitle)
      var colour1 = get_current_colour_1()
      var colour2 = get_current_colour_2()
      var colourData = all_colours_1_data()
      if (colour1) {
        captionParts.push(colourData[colour1].title)
      }
      if (colour2) {
        captionParts.push(colourData[colour2].title)
      }

      $fullRepeatModal.on("transitionend", onOpenEnd)
      $fullRepeatModal.addClass("is-transitioning")
      $fullRepeatCaption.text(captionParts.join(", "))
      void $fullRepeatModal[0].clientWidth //
      $fullRepeatModal.addClass("is-active")
    })

    // Close
    $fullRepeatModal.on("click", function() {
      $fullRepeatModal.on("transitionend", onCloseEnd)
      $fullRepeatModal.addClass("is-transitioning")
      void $fullRepeatModal[0].clientWidth //
      $fullRepeatModal.removeClass("is-active")
    })

    // Lengths
    var min_allowed = 2000;
    var repeat_length = $('#repeat_value').val()*1;
    var min_order_length = Math.ceil( min_allowed / repeat_length ) * repeat_length;

    var length = {};

    length['repeat_length'] = repeat_length;
    length['min_order_length'] = min_order_length;
    length['max_length'] = 13000;

    addLength( length );

    $('#min_order').text( min_order_length/1000 );

    $('#order-lengths').on( 'click', '.remove', function(e){
      e.preventDefault();
      var index = $(this).parents('li').first().index();
      removeLength( index );
    });

    $('#addlength').click(function(e){
      e.preventDefault();
      addLength( length );
    });

    var baseToggle = $('#current-basecloth').collapserr({ sectionSelector : '#basecloth-collapse' });
    var col1Toggle = $('#current-colour-1').collapserr({ sectionSelector : '#colour-1-collapse' });
    var col2Toggle = $('#current-colour-2').collapserr({ sectionSelector : '#colour-2-collapse' });

    $('#current-basecloth').click( function(){
      col1Toggle.close();
      col2Toggle.close();
    });
    $('#current-colour-1').click( function(){
      baseToggle.close();
      col2Toggle.close();
    });
    $('#current-colour-2').click( function(){
      baseToggle.close();
      col1Toggle.close();
    });

  }

  /* -----------------------------------------------------------------------------------------------------------------

    Share

  ----------------------------------------------------------------------------------------------------------------- */

  $('#share-trigger').click(function(e){
    e.preventDefault();
    $('#share-container').toggleClass('is-open')
  });


  $('#share__facebook, #share__twitter').click(function(e) {
    e.preventDefault();

    var width  = 575,
        height = 400,
        left   = ($(window).width()  - width)  / 2,
        top    = ($(window).height() - height) / 2,
        url    = this.href,
        opts   = 'status=1' +
                 ',width='  + width  +
                 ',height=' + height +
                 ',top='    + top    +
                 ',left='   + left;

    window.open(url, 'twitter', opts);
  });

  /* -----------------------------------------------------------------------------------------------------------------

    tabgroup

  ----------------------------------------------------------------------------------------------------------------- */

  $('.tabnav a').click( function(e){
    e.preventDefault();

    var $tabgroup = $(this).parents('.tabgroup').first();

    $tabgroup.find('.tabnav a').removeClass('active');
    $(this).addClass('active');

    $tabgroup.find('.tabpane').css('display','none');
    $tabgroup.find( $(this).attr('href') ).css('display','block');

  });

});
