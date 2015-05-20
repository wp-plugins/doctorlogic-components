jQuery(function() {
	jQuery('.dl__hideshow').click(function () { 
		jQuery(this).parent().siblings('.dl__m_hidden').toggle();
	});
	
	
	jQuery('#showadvanced').click(function(){
			alert('hi');
			jQuery('#dl_advanced_styles').show();
			jQuery('#hideadvanced').show();
			jQuery('#showeadvanced').hide();
			
	});
	jQuery('#hideadvanced').click(function(){
			jQuery('#dl_advanced_styles').hide();
			jQuery('#hideadvanced').hide();
			jQuery('#showeadvanced').show();
			
	});
	jQuery('.dl__modal').dl__leanModal();
});


(function($){$.fn.extend({dl__leanModal:function(options){var defaults={top:100,overlay:0.5,closeButton:null};var overlay=$("<div id='dl__lean_overlay'></div>");$("body").append(overlay);options=$.extend(defaults,options);return this.each(function(){var o=options;$(this).click(function(e){var modal_id=$(this).attr("href");$("#dl__lean_overlay").click(function(){close_modal(modal_id)});$(o.closeButton).click(function(){close_modal(modal_id)});var modal_height=$(modal_id).outerHeight();var modal_width=$(modal_id).outerWidth();
$("#dl__lean_overlay").css({"display":"block",opacity:0});$("#dl__lean_overlay").fadeTo(200,o.overlay);$(modal_id).css({"display":"block","position":"fixed","opacity":0,"z-index":11000,"left":50+"%","margin-left":-(modal_width/2)+"px","top":o.top+"px"});$(modal_id).fadeTo(200,1);e.preventDefault()})});function close_modal(modal_id){$("#dl__lean_overlay").fadeOut(200);$(modal_id).css({"display":"none"})}}})})(jQuery);
