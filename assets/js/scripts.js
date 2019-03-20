jQuery(document).ready(function() {
  var is_480 = false;

  $(window).resize(function() {
    if ( $(window).width() <= 480 ) {
      is_480 = true;
    }
  });

  $(window).trigger('resize');

  $('.tabs-nav a').click(function() {
    var target = $(this).data('target');
    $('.tabs-nav a').removeClass('active');
    $(this).addClass('active');
    $('.main-items .list').hide();
    $('.main-items #' + target).show();
    $('.item').each(function() {
      if ( is_480 ) {
        $(this).find('.info').css({ paddingRight: 0 });
      } else {
        $(this).find('.info').css({ paddingRight: $(this).find('.btn').outerWidth(true) });
      }
    });
  });

  $('.item').each(function() {
    if ( is_480 ) {
      $(this).find('.info').css({ paddingRight: 0 });
    } else {
      $(this).find('.info').css({ paddingRight: $(this).find('.btn').outerWidth(true) });
    }
  });

  if ( $('.embed').length ) {
    $('.embed').fitVids();
  }
});
