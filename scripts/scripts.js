jQuery(function($) {
	$('.dl__hideshow').click(function () { 
		$(this).parent().siblings('.dl__m_hidden').toggle();
	});

	$('.dl__modal').dl__leanModal();

  setInterval(function() {
    dl_moveRight();
  }, 4000);

  var slideCount = $('#dl__slider ul li').length;
  var slideWidth = $('#dl__slider ul li').width();
  var sliderUlWidth = $ * slideWidth;

  $('#dl__slider').css({
    width: slideWidth,
    height: jQuery('#dl__slider ul li').height()
  });

  $('#dl__slider ul').css({
    width: sliderUlWidth,
    marginLeft: -slideWidth
  });

  $('#dl__slider ul li:last-child').prependTo('#dl__slider ul');

  function dl_moveRight() {
    $('#dl__slider ul').animate({
      left: -slideWidth
    }, 500, function() {
      $('#dl__slider ul li:first-child').appendTo('#dl__slider ul');
      $('#dl__slider ul').css('left', '');
    });
  }
  	$('.dl__only6 li').listItemsToggle();
});



/*LeanModal used on Review.php*/
(function($){$.fn.extend({dl__leanModal:function(options){var defaults={top:100,overlay:0.5,closeButton:null};
	var overlay=$("<div id='dl__lean_overlay'></div>");$("body").append(overlay);options=$.extend(defaults,options);
	return this.each(function(){var o=options;$(this).click(function(e){var modal_id=$(this).attr("href");
		$("#dl__lean_overlay").click(function(){close_modal(modal_id)});$(o.closeButton).click(function(){close_modal(modal_id)});
		var modal_height=$(modal_id).outerHeight();var modal_width=$(modal_id).outerWidth();
$("#dl__lean_overlay").css({"display":"block",opacity:0});$("#dl__lean_overlay").fadeTo(200,o.overlay);
$(modal_id).css({"display":"block","position":"fixed","opacity":0,"z-index":11000,"left":50+"%","margin-left":-(modal_width/2)+"px","top":o.top+"px"});
$(modal_id).fadeTo(200,1);e.preventDefault()})});function close_modal(modal_id){$("#dl__lean_overlay").fadeOut(200);$(modal_id).css({"display":"none"})}}})})(jQuery);

/*listItemsToggle - used on Gallery.php*/
(function($) {

    $.fn.listItemsToggle = function(options) {
        var $listItems = this,
            settings,
            moreText,
            lessText,
            hiddenItems,
            toggleListDisplay;

        settings = $.extend({
            maxShownItems: 6,
            moreText: 'More...',
            lessText: 'Less...',
            moreClass: 'more-text',
            lessClass: 'less-text'
        }, options);

        if($listItems.length > settings.maxShownItems) {
            moreText = $('<li class="' + settings.moreClass + '"><a href="javascript:void(0);">' + settings.moreText + '</a>');
            lessText = $('<li class="' + settings.lessClass + '"><a href="javascript:void(0);">' + settings.lessText + '</a>');
            hiddenItems = $listItems.filter(':gt(' + (settings.maxShownItems - 2) + ')');

            moreText.insertBefore($listItems[settings.maxShownItems - 1]);
            lessText.insertAfter($listItems.last()).hide();
            hiddenItems.hide();

            toggleListDisplay = function() {
                hiddenItems.toggle();
                moreText.toggle();
                lessText.toggle();
            };

            moreText.click(toggleListDisplay);
            lessText.click(toggleListDisplay);
        }
    };

})(jQuery);