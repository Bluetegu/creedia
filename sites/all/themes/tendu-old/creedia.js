if (Drupal.jsEnabled) {

  // align vertical position to middle
  (function ($) {
    $.fn.vAlignMiddle = function(margin) {
      return this.each(function(i){
	// the Granparent has position relative therefore the height 
	// is taken from it (bottom class).
	// Determine who is setting this height, either your parent
	// or a sibling of your parent (leftbar or main).
	// If its your parent who is setting the height, no need 
	// to align to bottom.
	// If its the sibling, set the absolute position compared
	// with the grandparent. There grandparent height will not
	// change as a result, as it is fixed by the sibling.
	// container height. 
	var gph = $(this).parent().parent().height();
	var ph = $(this).parent().outerHeight(true);
	if (gph <= ph) return;
	
	var sh = $(this).prev().height();
	var nh = $(this).next().height();
	var h = $(this).height();

	if ((gph-h)/2 > sh + margin && (gph-h)/2 > nh + margin) {
	  // align only if it will not override top or bottom elements
	  $(this).css("top", gph/2 + "px");
	  $(this).css("margin-top", "-" + h/2 + "px");
	  $(this).css("position", "absolute");
	}
      });
    };
  })(jQuery);

  // align vertical position to bottom
  (function ($) {
    $.fn.vAlignBottom = function(margin) {
      return this.each(function(i){
	// the Granparent has position relative therefore the height 
	// is taken from it (bottom class).
	// Determine who is setting this height, either your parent
	// or a sibling of your parent (leftbar or main).
	// If its your parent who is setting the height, no need 
	// to align to bottom.
	// If its the sibling, set the absolute position compared
	// with the grandparent. There grandparent height will not
	// change as a result, as it is fixed by the sibling.
	// container height. 
	var gph = $(this).parent().parent().height();
	var ph = $(this).parent().outerHeight(true);
	if (gph - margin <= ph) return;
	
	$(this).css("bottom", margin + "px");
	$(this).css("position", "absolute");
      });
    };
  })(jQuery);


  function creediaVerAlign() {
    // Vertical align bottom leftbar
    $(".opinion-leftbar-bottom, .interpretation-leftbar-bottom, .member-leftbar-bottom, .image-cck-leftbar-bottom").vAlignBottom(6);
    // Safary makes a lot of problems when assigning absolute position to footers. So, as its not that
    // important for main footer to be aligned to the bottom, we leave it as is.
    //    $(".opinion-main-footer, .interpretation-main-footer, .member-main-footer").vAlignBottom(12);
    $(".creed-leftbar-bottom").vAlignBottom(8);

    // Vertical align middle leftbar
    $(".opinion-leftbar-middle, .interpretation-leftbar-middle, .image-cck-leftbar-middle").vAlignMiddle(6);
    $(".creed-leftbar-middle").vAlignMiddle(12);
  }

  //  $(document).ready(function(){
  // Safari and Chrome fail to calculate correct height and weight of divs that includes loaded images, unless 
  // they are fully loaded. So waiting for window load is required.
  $(window).load(function(){
    // Enable all JS specific tags
    // Hide all JS-disabled specific tags
    $(".jsonly").show();
    $(".jsdisabled").hide();

  });

  $(window).load(function(){
    creediaVerAlign();
  });
}
