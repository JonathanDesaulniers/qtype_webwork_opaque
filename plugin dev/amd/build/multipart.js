//     Multipart JS
//     (c) 2023-20XX Jonathan Desaulniers



define('qtype_webwork_opaque/multipart', ["jquery"], function($) {
	
	var h = {
        init : function() {

	$.fn.canshow = function() {
   $(this).addClass("canshow ui-accordion-header ui-helper-reset ui-state-default ui-corner-top ui-corner-bottom")
   .hover(function() { $(this).toggleClass("ui-state-hover"); })
   .prepend('<span class="ui-icon ui-icon-triangle-1-e"></span>')
   .click(function() {
     if ($(this).hasClass("ui-accordion-header-active")) {
       var THIS = this;
       $(this)
         .toggleClass("ui-accordion-header-active ui-state-active ui-state-default")
         .find("> .ui-icon").toggleClass("ui-icon-triangle-1-e ui-icon-triangle-1-s").end()
         .next().slideToggle(400,function () {$(THIS).toggleClass("ui-corner-bottom")});
     } else {
       $(this)
         .toggleClass("ui-accordion-header-active ui-state-active ui-state-default ui-corner-bottom")
         .find("> .ui-icon").toggleClass("ui-icon-triangle-1-e ui-icon-triangle-1-s").end()
         .next().slideToggle();
     }
     return false;
   })
   .next()
     .addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom")
     .hide();
	};
		}
	};
	return h;
});