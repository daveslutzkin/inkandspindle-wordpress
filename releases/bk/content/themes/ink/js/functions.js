$('.js-scroll').click(function(e) {
  e.preventDefault();
  $('html, body').stop().animate({
    scrollTop: $($(this).attr('href')).offset().top - 16
  }, 600);
});

$('.js-waypoint').waypoint({
  handler: function(direction) {
    if (direction == 'down') {
      $(this).addClass('active');
    }
    if (direction == 'up') {
      $(this).removeClass('active');
    }
  },
  offset: '85%'
});

$('.carbon-neutral b').waypoint({
  handler: function(direction) {			
    if (direction == 'down') {
      $(this).countTo()
    }
  },
  offset: '85%'
});

$('.waypoint-section')
  .waypoint(
    function(direction) {
      var $links = $('a[href="#' + this.id + '"]');
      $links.parent().toggleClass('current', direction === 'down');
    },
    { offset: '100%' }
  )
  .waypoint(
    function(direction) {
      var $links = $('a[href="#' + this.id + '"]');
      $links.parent().toggleClass('current', direction === 'up');
    },
    { offset: function() { return -$(this).height(); } }
  );
