$('.menu_btn').click(function (e) {
    e.preventDefault();
    var $this = $(this).parent().find('.sub_list');
    $('.sub_list').not($this).slideUp(function () {
      var $icon = $(this).parent().find('.change-icon');
      $icon.removeClass('bx-chevron-down').addClass('bx-chevron-right');
    });

    $this.slideToggle(function () {
      var $icon = $(this).parent().find('.change-icon');
      $icon.toggleClass('bx-chevron-right bx-chevron-down')
    });
  });

  $(window).bind("resize", function () {
    if ($(this).width() < 500) {
      $('div').removeClass('open');
      closeBtn.classList.replace("bx-arrow-to-left", "bx-menu");
    }
    else if ($(this).width() > 500) {
      $('.sidebar').addClass('open');
      closeBtn.classList.replace("bx-menu", "bx-arrow-to-left");
    }
  }).trigger('resize');