{
  // Utils
  const find = (scope, selector) => scope.querySelector(selector)
  const findAll = (scope, selector) => [].slice.call(scope.querySelectorAll(selector))
  const $ = (selector) => find(document, selector)
  const $$ = (selector) => findAll(document, selector)

  // Elements
  const $toggle = $("#navtoggle")
  const $nav = $("#navigation")
  const $$submenuToggles = $$("[data-submenu-toggle]")
  const $$submenuLis = $$(".secondary-navigation li.has-submenu")

  // State
  let isOpen = false
  let isDesktop = window.matchMedia("(min-width: 1040px)").matches;

  // Handlers
  $toggle.addEventListener("click", (e) => {
    isOpen = !isOpen
    $toggle.classList.toggle("open", isOpen)
    $nav.classList.toggle("open", isOpen)
  })

  $$submenuToggles.forEach($btn => {
    $btn.addEventListener("click", (e) => {
      const isExpanded = $btn.getAttribute("aria-expanded") === "true"
      const $submenu = $btn.nextElementSibling
      if (isExpanded) {
        $btn.setAttribute("aria-expanded", "false")
        $submenu.hidden = true
      } else {
        $btn.setAttribute("aria-expanded", "true")
        $submenu.hidden = false
      }
    })
  })

  $$submenuLis.forEach($li => {
    $li.addEventListener("mouseenter", (e) => {
      if (isDesktop) {
        find($li, "[data-submenu]").hidden = false
        find($li, "[data-submenu-toggle]").setAttribute("aria-expanded", "true")
      }
    })
    $li.addEventListener("mouseleave", (e) => {
      if (isDesktop) {
        find($li, "[data-submenu]").hidden = true
        find($li, "[data-submenu-toggle]").setAttribute("aria-expanded", "false")
      }
    })
  })
}


/* -----------------------------------------------------------------------------------------------------------------

  Cart & Cookies.

----------------------------------------------------------------------------------------------------------------- */

function emptyCart(){
  Cookies.set( 'cart', '[]', { expires: 36000 } );
}

function addToCart(){
  var MINUMUM_ORDER_LENGTH = 2000
  var lengths = []
  var totalLength = 0

  var repeat_length = jQuery('#repeat_value').val()*1;
  var min_order_length = Math.ceil( 2100 / repeat_length ) * repeat_length; // rounds UP to whole number


  jQuery('#order-lengths').find('input').each(function(){
    var length_value = parseInt( jQuery(this).val(), 10 );
    if ( length_value > 0 ){
      lengths.push( length_value ); // convert length from mm to meters?
    }
    totalLength += jQuery(this).val() * 1;
  });


  if (totalLength < MINUMUM_ORDER_LENGTH) {
    notification({
      message:
        "Sorry, the minimum order length for this pattern is " +
        min_order_length / 1000 +
        "m.",
      stateClass: "error",
    })
    return false
  }

  // Cart Cookies

  var cart = getCartCookie();

  var selected_basecloth_id = get_current_basecloth_id();
  var selected_colour_1_id = get_current_colour_1();
  var selected_colour_2_id = get_current_colour_2();

  var hash = [];
  var labels = [];

  hash.push( selected_basecloth_id );
  labels.push( all_basecloth_data()[selected_basecloth_id].title );

  hash.push( selected_colour_1_id );
  labels.push( all_colours_1_data()[selected_colour_1_id].title );

  if ( selected_colour_2_id ){
    hash.push( selected_colour_2_id );
    labels.push( all_colours_2_data()[selected_colour_2_id].title );
  }

  // Cart structure:
  var item = {
    'postID' : jQuery('#post_id').val(),
    'postTitle' : jQuery('#post_title').val(),
    'postUrl' : jQuery('#post_url').val(),
    'baseclothID' : get_current_basecloth_id(),
    'hash' : hash,
    'lengths' : lengths,
    'totalLength' : totalLength,
    'repeatLength' : jQuery('#repeat_value').val(),
    'labels' : labels
  };

  cart.push( item );

  Cookies.set( 'cart', JSON.stringify( cart ), { expires: 36000 } );

  notification( { 'message': item.postTitle + ' added to your order.' } );

  var $yourCartNavItem = jQuery('#navigation').find('a[href="/order"]');
  $yourCartNavItem.addClass('pop');
  setTimeout( function(){
    $yourCartNavItem.removeClass('pop');
  }, 400 );

};

function removeItemFromCart( index ){
  var $cart = jQuery('#cart');
  var cart = getCartCookie();

  if ( ! cart.length || ! $cart.length )
    return false;

  cart.splice( index, 1 );
  Cookies.set( 'cart', JSON.stringify( cart ), { expires: 36000 } );
  notification( { 'message': 'Item removed from your order.' } );
  outputCart();
};

function getCartCookie(){
  var cartCookie = Cookies.get( 'cart' );

  if ( ! cartCookie ){
    return [];
  }

  try {
    var parsed = JSON.parse( cartCookie );
    return Array.isArray( parsed ) ? parsed : [];
  } catch ( error ) {
    if ( window.console && console.warn ) {
      console.warn( 'Resetting invalid cart cookie', error );
    }
    Cookies.set( 'cart', '[]', { expires: 36000 } );
    return [];
  }
}

function outputCart(){
  var cart = getCartCookie();
  var $cart = jQuery('#cart');
  var $cartform = jQuery('#cartform');
  var $form_input = $cartform.find('.hidden_order_field').first().find('.textarea');

  if ( cart.length ){
    var all_basecloth_data = jQuery('#cart-basecloths').data('basecloths')[0];

    var total_price = 0;
    var total_length = 0
    var o = '';

    jQuery.each( cart, function( index, item ) {
      var basecloth = all_basecloth_data[item.baseclothID]
      var is_trade_customer = basecloth.wsp
      var one_colour_pricing = item.hash.length === 2 || item.hash[1] === "0";

      var price_per_m = one_colour_pricing
        ? basecloth.retail_price_one_colour
        : basecloth.retail_price_two_colour

      if (is_trade_customer) {
        price_per_m = one_colour_pricing
          ? basecloth.trade_price_one_colour
          : basecloth.trade_price_two_colour
      }

      var item_price = item.totalLength / 1000 * price_per_m
      total_price += item_price*1;
      total_length += item.totalLength

      var itemLengthsInMetres = [];
      jQuery.each( item.lengths, function(index, value) {
        itemLengthsInMetres.push( value / 1000 + 'm' );
      });

      o += '<tr class="cart-row item-row" data-cart-index="' + index + '">';
      o +=   '<td class="description-column">';
      o +=     '<a href="' + item.postUrl + '#!' + item.hash + '">' + item.postTitle + '</a> ';
      o +=     '<br />';
      o +=     item.labels.join(', ');
      o +=   '</td>';
      o +=   '<td class="lengths-column">' + itemLengthsInMetres.join(', ') + '</td>';
      o +=   '<td class="price-column">' +  item_price.toFixed(2) + ' <div><span class="item-remove" data-cart-index="' + index + '">&times;</span></div></td>';
      o += '</tr>';
    });

    o += '<tr class="cart-row totals-row subtotal-row">';
    o +=   '<td class="empty"></td>';
    o +=   '<th>Subtotal</th>';
    o +=   '<td class="price-column">' + total_price.toFixed(2) + '</td>';
    o += '</tr>';

    var gst = total_price * 0.1

    o += '<tr class="cart-row totals-row gst-row">';
    o +=   '<td class="empty"></td>';
    o +=   '<th>GST</th>';
    o +=   '<td class="price-column">' + gst.toFixed(2) + '</td>';
    o += '</tr>';
    o += '<tr class="cart-row totals-row total-row">';
    o +=   '<td class="empty"></td>';
    o +=   '<th>Total</th>';
    o +=   '<td class="price-column">' + ( total_price + gst ).toFixed(2) + '</td>';
    o += '</tr>';
    o += '<tr class="cart-row totals-row gst-row">';
    o +=   '<td class="empty"></td>';
    o +=   '<th>Any Bulk discounts will be applied to your final invoice.</th>';
    o += '</tr>';

    $cartform.css( 'display', 'block' );
    $cart.html( o );
    $form_input.val( '<table style="width: 100%;">' + o.split('<div><span class="item-remove">&times;</span></div>').join('') + '</table>' );

  } else {

    if ( jQuery('#gforms_confirmation_message').length ){
      $cartform.css( 'display', 'block' );
      $cart.html( '' );
    } else {
      $cartform.css( 'display', 'none' );
      $cart.html( '<table><tr><td style="text-align:center;">You have no items in your order.</td></tr></table>' );
      $form_input.text( '' );
    }
  }

}

/* -----------------------------------------------------------------------------------------------------------------

  Pattern

----------------------------------------------------------------------------------------------------------------- */

function update_share_links(){
  var url = (window.location.href).split('#').join('%23'); // Replace # so Facebook don't strip it, yo!
  jQuery('#share__twitter').attr('href', 'https://twitter.com/intent/tweet?url=' + url );
  jQuery('#share__facebook').attr('href', 'http://www.facebook.com/sharer/sharer.php?u=' + url );
}

function get_default_basecloth_id(){
  var id = jQuery('#basecloth').attr('data-defaultid');
  return id ? id : false;
}

function get_default_colour_1(){
  var id = jQuery('#screen-1').attr('data-defaultid');
  return id ? id : false;
}

function get_default_colour_2(){
  var id = jQuery('#screen-2').attr('data-defaultid');
  return id ? id : false;
}


function all_basecloth_data(){
  if ( jQuery('#basecloth').length ){
    return jQuery('#basecloth').data('basecloths')[0];
  }
  return false;
}
function all_basecloth_sortorder(){
  if ( jQuery('#basecloth').length ){
    return jQuery('#basecloth').data('basecloths')[1];
  }
  return false;
}


function all_colours_1_data(){
  if ( jQuery('#screen-1').length ){
    return jQuery('#screen-1').data('colours')[0];
  }
  return false;
}
function all_colours_1_sortorder(){
  if ( jQuery('#screen-1').length ){
    return jQuery('#screen-1').data('colours')[1];
  }
  return false;
}


function all_colours_2_data(){
  if ( jQuery('#screen-2').length ){
    return jQuery('#screen-2').data('colours')[0];
  }
  return false;
}
function all_colours_2_sortorder(){
  if ( jQuery('#screen-2').length ){
    return jQuery('#screen-2').data('colours')[1];
  }
  return false;
}


function get_current_basecloth_id(){
  var id = jQuery('#basecloth').val();
  if ( ! id ){ return false; }
  return id;
}

function get_current_colour_1(){
  let val = jQuery('#screen-1').val();
  if (val === "false") val = "0";
  return val;
}

function get_current_colour_2(){
  let val = jQuery('#screen-2').val();
  if (val === "false") val = "0";
  return val;
}


function set_current_basecloth_id( value ){
  jQuery('#basecloth').val( value );
}

function set_current_colour_1( value ){
  jQuery('#screen-1').val( value );
}

function set_current_colour_2( value ){
  jQuery('#screen-2').val( value );
}


function set_url_params(){
  var params = [];
  params.push( get_current_basecloth_id() );
  params.push( get_current_colour_1() );
  if ( get_current_colour_2() ){
    params.push( get_current_colour_2() );
  }

  window.location.hash = '!' + params.join(',');
}

function setupSwatchSelection( swatches ){

  if ( ! get_default_basecloth_id() ){
    return false;
  }

  var message = '';
  var errormessage = '';
  var hashes = {};
  var valid = true;

  if ( window.location.hash ){

    if ( window.location.hash == "!" || window.location.hash.split('#!')[1] === undefined ){
      selectDefaultSwatches();
      return true;
    }

    var hash = window.location.hash.split('#!')[1].split(',');
    var basecloth_id_param = hash[0];
    var colour_1_id_param = hash[1];
    var colour_2_id_param = hash[2];

    if ( hash[3] ){
      errormessage += 'Invalid URL params (too many params in the # hash). ';
      valid = false;
    }

    if ( basecloth_id_param && swatches.basecloths[basecloth_id_param] ){
      hashes['basecloth_id'] = basecloth_id_param;
    } else {
      errormessage += 'Requested basecloth not available. ';
      valid = false;
    }

    if ( colour_1_id_param ){
      if ( swatches.colours_1[colour_1_id_param] ){
        hashes['colour_1_id'] = colour_1_id_param;
      } else {
        errormessage += 'Requested Colour 1 not available. ';
        valid = false;
      }
    } else {
      message += 'A Colour 1 parameter is required. ';
      valid = false;
    }

    if ( ! swatches.colours_2 && colour_2_id_param ){
      errormessage += 'Colour 2 parameter is not available for this pattern.';
      valid = false;
    }

    if ( swatches.colours_2 && colour_2_id_param ){
      if ( swatches.colours_2[colour_2_id_param] ){
        hashes['colour_2_id'] = colour_2_id_param;
      } else {
        errormessage += 'Requested Colour 2 not available. ';
        valid = false;
      }
    }

    if ( swatches.colours_2 && ! colour_2_id_param ){
      errormessage += 'A Colour 2 parameter is required. ';
      valid = false;
    }

    if ( valid ){
      set_current_basecloth_id( basecloth_id_param );
      set_current_colour_1( colour_1_id_param );
      if ( swatches.colours_2 ){
        set_current_colour_2( colour_2_id_param );
      }

      var topSpacing = jQuery('.site-header').css('position') == 'fixed' ? 104 : 0;
      jQuery('html, body').stop().animate({
        scrollTop: ( jQuery('#customise').offset().top - topSpacing )
      }, 600);

      return true;

    } else {
      selectDefaultSwatches();
      errormessage += '<br /> Requested custom pattern not found.'
      return true;

    }

  } else {
    selectDefaultSwatches();
    return true;
  }

  return true;

}

function selectDefaultSwatches(){
  set_current_basecloth_id( get_default_basecloth_id() );
  set_current_colour_1( get_default_colour_1() );
  if ( get_default_colour_2() ){
    set_current_colour_2( get_default_colour_2() );
  }
}

function buildSwatches( swatches ){

  var current_basecloth_id = get_current_basecloth_id(),
    current_colour_1_id = get_current_colour_1(),
    current_colour_2_id = get_current_colour_2();

  if ( ! current_basecloth_id || ! current_colour_1_id ){
    return false;
  }

  if ( swatches.basecloths && current_basecloth_id ){

    var o = '';
    var sortOrder = all_basecloth_sortorder();

    jQuery.each( sortOrder, function( i, index ){

      var obj = swatches.basecloths[index];
      var selected = ( obj.id == current_basecloth_id ) ? 'selected' : '';

      o += '<div rel="' + obj.id + '" class="basecloth-swatch ' + selected + '">';
      o +=   '<div class="media">';
      o +=      '<div class="shear-wrapper small">';
      o +=        '<div class="shear">';
      o +=          '<div class="img">' + '<img src="' + obj.images.thumb + '" alt width="100" height="100" />' + '</div>';
      o +=       '</div>';
      o +=     '</div>';
      o +=     '<b></b>';
      o +=   '</div>';
      o += '</div>';

    });

    jQuery('#basecloth-swatches').append( o );

  }

  if ( swatches.colours_1 && current_colour_1_id ){

    var o = '';
    var sortOrder = all_colours_1_sortorder();

    jQuery.each( sortOrder, function( i, index ){

      var obj = swatches.colours_1[index];
      var selected = ( obj.id == current_colour_1_id ) ? 'selected' : '';
      var none_class = ( obj.title == 'None' ) ? '-none' : '';
      o += '<div rel="' + obj.id + '" class="colour-swatch ' + selected + ' ' + none_class + '">';
      o +=   '<div class="media">';
      o +=    '<span style="opacity:' + ( obj.white / 100 ) + ';"></span>'; // white
      o +=    '<span style="background-color:' + '#' + obj.hex + '; opacity:' + ( obj.opacity / 100 ) + '"></span>';
      o +=     '<b></b>';
      o +=   '</div>';
      o +=   obj.title;
      o += '</div>';
    });

    jQuery('#colour-swatches-1').append( o );

  }

  if ( swatches.colours_2 && current_colour_2_id ){

    var o = '';
    var sortOrder = all_colours_2_sortorder();

    jQuery.each( sortOrder, function( i, index ){
      var obj = swatches.colours_2[index];
      var selected = ( obj.id == current_colour_2_id ) ? 'selected' : '';
      var none_class = ( obj.title == 'None' ) ? '-none' : '';
      o += '<div rel="' + obj.id + '" class="colour-swatch ' + selected + ' ' + none_class + '">';
      o +=   '<div class="media">';
      o +=    '<span style="opacity:' + ( obj.white / 100 ) + ';"></span>'; // white
      o +=    '<span style="background-color:' + '#' + obj.hex + '; opacity:' + ( obj.opacity / 100 ) + '"></span>';
      o +=     '<b></b>';
      o +=   '</div>';
      o +=   obj.title
      o += '</div>';
      });

    jQuery('#colour-swatches-2').append( o );

  }

  return true;

}

function updatePrices () {
  var id = get_current_basecloth_id();
  var basecloth = all_basecloth_data()[ id ];
  var price_per_m = '';

  var colour_1 = get_current_colour_1();
  var colour_2 = get_current_colour_2();

  var one_colour_pricing = colour_1 === "0" || colour_2 === undefined

  price_per_m = one_colour_pricing
    ? basecloth.retail_price_one_colour
    : basecloth.retail_price_two_colour
  jQuery("#retail-one-colour").text("$" + basecloth.retail_price_one_colour + "/m")
  jQuery("#retail-two-colour").text("$" + basecloth.retail_price_two_colour + "/m")

  if ( basecloth.wsp ){
    price_per_m = one_colour_pricing
      ? basecloth.trade_price_one_colour
      : basecloth.trade_price_two_colour
    jQuery("#trade-one-colour").text("$" + basecloth.trade_price_one_colour + "/m")
    jQuery("#trade-two-colour").text("$" + basecloth.trade_price_two_colour + "/m")
  }

  var total_mm = 0
  var total_price = 0

  jQuery('#order-lengths').find('input').each( function(){
    total_mm += jQuery(this).val() * 1;
  });

  jQuery('#total-meterage').text( total_mm / 1000 + 'm' );

  var $retail_pricebrackets = jQuery('#retail-pricebrackets')
  var $wholesale_pricebrackets = jQuery('#wholesale-pricebrackets')

  function updatePriceBrackets( index ){
    $retail_pricebrackets.children().removeClass('active');
    $retail_pricebrackets.children().eq( index ).addClass('active');
    $wholesale_pricebrackets.children().removeClass('active');
    $wholesale_pricebrackets.children().eq( index ).addClass('active');
  }

  total_price = (total_mm / 1000) * price_per_m

  if (one_colour_pricing) {
    updatePriceBrackets(0)
  } else {
    updatePriceBrackets(1)
  }

  jQuery("#price").text(total_price.toFixed(2))
  jQuery('#price-gst').text( (total_price/10).toFixed(2) );
  jQuery('#price-total').text( (total_price*1.1).toFixed(2) );

  return true;
}

function updateBaseclothLabel( swatches, id ){
  if ( ! swatches.basecloths || ! id ){
    return false;
  }

  var basecloth = swatches.basecloths[ id ];

  var $basecloth_info = jQuery('#current-basecloth');

  $basecloth_info.find('.title').text( basecloth.title );

  $basecloth_info.find('.media').css('background-image', 'url(' + basecloth.images.thumb + ')' );

  var specs = '';
  specs += '<ul>';
  specs += '<li><span class="label">Blend</span>' + '<span>' + basecloth.specs.fibre + '<span>' + '</li>';
  specs += '<li><span class="label">Weight</span>' + '<span>' + basecloth.specs.weight + '<span>' + '</li>';
  specs += '<li><span class="label">Width</span>' + '<span>' + basecloth.specs.width + '<span>' + '</li>';
  specs += '</ul>';

  $basecloth_info.find('.specs').html( specs );

}

function updateColourLabel( swatches, id, swatchSet ){
  if ( ! swatches || ! id || ! swatchSet ){
    return false;
  }

  var colour = ( swatchSet == 2 ) ? swatches.colours_2[ id ] : swatches.colours_1[ id ];
  var $toggle = jQuery('.currentcolour-' + swatchSet );

  $toggle.find('.title').text( colour.title );

  $toggle.find('.droplet').css('color', '#' + colour.hex );

}

/* -----------------------------------------------------------------------------------------------------------------

  Lengths

----------------------------------------------------------------------------------------------------------------- */

function addLength( length ){

  var lengthTemplate  = '<li>';
    lengthTemplate += '  <input type="hidden" value="' + length.min_no_repeats * length.repeat_length + '" />';
    lengthTemplate += '  <div class="ui-slider">';
    lengthTemplate += '    <a href="#" class="ui-slider-handle">';
    lengthTemplate += '        <span class="slider-label"></span>';
    lengthTemplate += '    </a>';
    lengthTemplate += '  </div>';
    lengthTemplate += '  <a href="#" class="remove">&times;</a>';
    lengthTemplate += '</li>';

  var $newLength = jQuery( lengthTemplate );
  var max_value = Math.floor(length.max_length / length.repeat_length) * length.repeat_length;

  $newLength.find('.ui-slider').slider({
    range: "min",
    min: 0,
    max: length.max_length,
    step: length.repeat_length,
    value : length.min_order_length, // start at minimum valid no of repeats
    slide : function( event, ui ) {
      var val = ui.value;
      if (val > max_value) {
        val = max_value;
        jQuery(this).slider("value", max_value)
        jQuery(this)
          .find(".slider-label")
          .text("— Repeats / —m")
      } else {
        jQuery(this).find('.slider-label').text( val / length.repeat_length + ' Repeats / ' + val / 1000 + 'm' );
      }
      jQuery(this).siblings('input').val( val ); // set length in mm to input value.
      updatePrices();
    },
    stop : function (event, ui) {
      var val = ui.value
      if (ui.value > max_value) {
        val = max_value;
        jQuery(this).find(".slider-label").text(val / length.repeat_length + " Repeats / " + val / 1000 + "m")
        jQuery(this).slider("value", max_value)
      }
    }
  });

  $newLength.find('.slider-label').text( length.min_order_length / length.repeat_length + ' Repeats / ' + length.min_order_length / 1000 + 'm' );;
  $newLength.find('input').val( length.min_order_length );
  $newLength.appendTo('#order-lengths');

  updatePrices();

}

function removeLength( index ){

  $orderLengths = jQuery('#order-lengths');
  if ( $orderLengths.children().length <= 1 ){
    notification( { message: 'You must have at least one length.', stateClass: 'error' } );
  } else {
    $orderLengths.children().eq( index ).remove();
    updatePrices();
  }

}

/* -----------------------------------------------------------------------------------------------------------------

  render canvas

----------------------------------------------------------------------------------------------------------------- */


function renderFullRepeatCanvas() {
  renderCanvas({
    width: 1440,
    height: 900,
    selector: "#render-full-repeat",
    fullRepeat: true,
  });
}


function renderCanvas (args) {
  var w = args ? args.width : 570
  var h = args ? args.height : 570
  var renderSelector = args ? args.selector : "#render"
  var isFullRepeat = args ? args.fullRepeat : false

  var fadeinoutSpeed = 400;

  var $canvas = jQuery('<canvas/>');
  $canvas.attr('width', w).attr('height', h);
  var canvas = $canvas[0]
  var ctx = canvas.getContext("2d", { willReadFrequently: true });

  var screen1 = jQuery('#screen-1').data(isFullRepeat ? 'fullrepeatsrc' : 'screensrc') || false
  var colour1data = all_colours_1_data()[get_current_colour_1()]
  var screen2 = jQuery("#screen-2").data(isFullRepeat ? "fullrepeatsrc" : "screensrc") || false

  var colour2data = screen2 ? all_colours_2_data()[get_current_colour_2()] : false

  var basecloth_src = loadImage( all_basecloth_data()[get_current_basecloth_id()]['images']['render'], main )
  var img2 = loadImage( screen1, main )
  var img3 = screen2 ? loadImage( screen2, main ) : false

  var imagesLoaded = 0
  var imagesCount = 1 + (screen1 ? 1 : 0) + (screen2 ? 1 : 0);

  if (imagesCount < 2) return true;

  jQuery(renderSelector).children().animate({ opacity: 0 }, fadeinoutSpeed, function(){
    jQuery(this).remove();
  });

  function main() {
    imagesLoaded += 1;
    if ( imagesLoaded == imagesCount ) {

      // ---------- BASECLOTH -----------
      var pattern = ctx.createPattern(basecloth_src, "repeat")
      ctx.fillStyle = pattern
      ctx.fillRect(0, 0, w, h)
      var basecloth = ctx.getImageData(0, 0, w, h)
      // ctx.drawImage(basecloth_src, 0, 0)
      // var basecloth = ctx.getImageData(0, 0, w, h)

      // ---------- LAYER -----------
      ctx.fillStyle = ctx.createPattern(img2, "repeat")
      ctx.fillRect(0, 0, w, h)
      var bottomLayer = ctx.getImageData(0, 0, w, h)
      var bottomLayerWhitePigment = ctx.getImageData(
        0,
        0,
        w,
        h
      )

      Filters.whitePigment( basecloth.data, bottomLayerWhitePigment.data, (colour1data.white/100) );
      Filters.selectiveColourise( bottomLayer.data, colour1data.hex );
      Filters.multiply( basecloth.data, bottomLayer.data, (colour1data.opacity/100) );

      // ---------- LAYER -----------
      if ( img3 ){
        ctx.fillStyle = ctx.createPattern(img3, "repeat")
        ctx.fillRect(0, 0, w, h)
        var topLayer = ctx.getImageData(0, 0, w, h)
        var topLayerWhitePigment = ctx.getImageData(0, 0, w, h)

        Filters.whitePigment( basecloth.data, topLayerWhitePigment.data, (colour2data.white/100) );
        Filters.selectiveColourise( topLayer.data, colour2data.hex );
        Filters.multiply( basecloth.data, topLayer.data, (colour2data.opacity/100) );
      }

      // ---------- Update Canvas -----------
      ctx.putImageData( basecloth, 0, 0 );

      if (isFullRepeat) {
        var $img = jQuery('<img src="' + canvas.toDataURL() + '" />')
          .attr("width", w + "px")
          .attr("height", h + "px")
          .appendTo(renderSelector)
        setTimeout(function () { $img.addClass("is-loaded") }, 100)
      } else {
        jQuery('<img src="' + canvas.toDataURL() + '" />')
          .css("opacity", 0)
          .appendTo(renderSelector)
          .animate({ opacity: 1 }, fadeinoutSpeed)
      }
    }
  }

  return true;

}

/* -----------------------------------------------------------------------------------------------------------------

  tabgroup

----------------------------------------------------------------------------------------------------------------- */

jQuery('.tabnav a').click( function(e){
  e.preventDefault();

  var $tabgroup = jQuery(this).parents('.tabgroup').first();

  $tabgroup.find('.tabnav a').removeClass('active');
  jQuery(this).addClass('active');

  $tabgroup.find('.tabpane').css('display','none');
  $tabgroup.find( jQuery(this).attr('href') ).css('display','block');

});
