/**
 * Front page handling 
 * 
 * - slogan newsticker
 * - newsticker
 *
 */

if (Drupal.jsEnabled) {
  $(document).ready(function() {

    var sloganInterval = 6000;
    var sloganTimeout;
    var sloganLast = $('li', '#front-slogan').length;
    var sloganIndex = sloganLast;
    // start rolling the slogan
    sloganFadeIn();

    function sloganFadeOut() {
      $('li', '#front-slogan').eq(sloganIndex).fadeOut('slow', sloganFadeIn);
    }
    function sloganFadeIn() {
      sloganIndex = sloganIndex + 1 >= sloganLast ? 0 : sloganIndex + 1;
      $('li', '#front-slogan').eq(sloganIndex).fadeIn('slow', sloganShow);
    }
    function sloganShow() {
      sloganTimeout = setTimeout(sloganFadeOut, sloganInterval);
    }

//     options for BBC newsTicker
//
//     var options = {
//       newsList: "ul#news",
//       startDelay: 10,
//       placeHolder1: " _",
//       placeHolder2: " _"

//     }
    $.ajax({
      type: "GET",
      url: "en/rss.xml",
//      dataType: "xml",
      dataType: ($.browser.msie) ? "text" : "xml",
      success: function(data) {
	// fix for IE per http://docs.jquery.com/Specifying_the_Data_Type_for_AJAX_Requests
	var xml;
	if (typeof data == "string") {
	  xml = new ActiveXObject("Microsoft.XMLDOM");
	  xml.async = false;
	  xml.loadXML(data);
	} 
	else {
	  xml = data;
	}
	// Returned data available in object "xml"
//      success: function(xml) {
//	$('<ul id="news"></ul>').appendTo('body');
	$(xml).find('item').each(function(){
          var title = $(this).find('title').text();
          var link = $(this).find('link').text();
	  var dateStr = $(this).find('pubDate').text();
	  var bbctime = Date.parse(dateStr);
	  var bbcdate = new Date;
	  bbcdate.setTime(bbctime);
	  $('<li><span>'+bbcdate.toDateString()+'</span><a href="'+link+'">'+title+'</a></li>').appendTo('ul#news');
//	  alert($('ul#news li').text());
	});
//	$().newsTicker(options);
        $('ul#news').liScroll({travelocity:0.05});
      },
      error: function(req, status, error){
 	var check = Boolean(req);
// 	if (check == false) alert('req is null');
// 	for (var att in bbcreq) alert(att);
// 	alert('failure: status '+status+' error '+error);
      }
    });

  });
}