// Li-Scroller plugin by Gian Carlo Mingati
//
// http://www.gcmingati.net
//
jQuery.fn.liScroll = function(settings) {
		settings = jQuery.extend({
		travelocity: 0.07
		}, settings);		
		return this.each(function(){
				var $strip = jQuery(this);
				$strip.addClass("newsticker")
				var stripWidth = 0;
				var $mask = $strip.wrap("<div class='mask'></div>");
				var $tickercontainer = $strip.parent().wrap("<div class='tickercontainer'></div>");								
				var containerWidth = $strip.parent().parent().width();	//a.k.a. 'mask' width 	
				$strip.find("li").each(function(i){
                                  // I'm taking twice the width for two reasons:
				  // - In IE6 when you load the page with text size normal and then increase
                                  //   the text size to largest, the width of each li grows bigger, while
                                  //   the container size remains the same (no recalculation). This causes some
                                  //   li-s to fold and create a second line.
                                  // - To solve a collapsed margin problem in IE7 I added display:block-inline
                                  //   for some unknown reason this causes the calculation of the widths to sum
                                  //   up to a width which is smaller than the actual width the li-s take, which
                                  //   again causes for li folding. It is not clear to me why I needed to add
                                  //   the inline-block hack while the demo doesn't suffer from this issue and
                                  //   I don't understand why the width calculation is broken, but this fix
                                  //   seems to work.
                                  // The downside effect is that there is a long wait between series of news items.
				stripWidth += jQuery(this, i).width()*2;
				});
				$strip.width(stripWidth);			
				var defTiming = stripWidth/settings.travelocity;
				var totalTravel = stripWidth+containerWidth;								
				function scrollnews(spazio, tempo){
				$strip.animate({left: '-='+ spazio}, tempo, "linear", function(){$strip.css("left", containerWidth); scrollnews(totalTravel, defTiming);});
				}
				scrollnews(totalTravel, defTiming);				
				$strip.hover(function(){
				jQuery(this).stop();
				},
				function(){
				var offset = jQuery(this).offset();
				var residualSpace = offset.left + stripWidth;
				var residualTime = residualSpace/settings.travelocity;
				scrollnews(residualSpace, residualTime);
				});			
		});	
};