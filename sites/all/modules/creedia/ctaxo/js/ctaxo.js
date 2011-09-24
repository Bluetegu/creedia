if (Drupal.jsEnabled) {
  $(document).ready(function(){

    var initialized = false;
    var request;

    $("div.scrollable").css("overflow", "hidden")
    .scrollable({vertical:true, 
      size: 8, 
      clickable: false, 
      next: ".next-single",
      prev: ".prev-single",
      nextPage: ".next",
      prevPage: ".prev",
      easing: "swing" });

    // Remove taxobar tip once a term is selected
    $(".taxoterm").one('click', function(){
      $(".taxobar-tip").remove();
    });

    // unbind clicks from taxoterm urls
    // $(".taxoterm a").unbind('click');

    // Assign toggle event functions to all terms
    $(".taxoterm").toggle(function(){
      var vid = $(this).attr('class').slice('taxoterm vid_'.length);
      var tid = $(this).attr('id').slice(5); // term_tid
      // hide first to avoid flickering
      $(this).find("img + a").hide(); 
      $(this).appendTo(".taxobar-target");
      var api = $('#vid_' + vid).parent("div.scrollable").scrollable();
      api.reload();

      var name = Drupal.settings.ctaxo['vid_' + vid];
      var vals = $('#sidebar-left .edit-' + name).val() || [] ; // all selected values
      vals.push(tid); 
      $('.edit-' + name).val(vals); // update the new values

      ajaxify();

    },function(){
      var vid = $(this).attr('class').slice('taxoterm vid_'.length);
      var tid = $(this).attr('id').slice(5); // term_tid
      $(this).prependTo('#vid_' + vid).find("img + a").show();
      var api = $('#vid_' + vid).parent("div.scrollable").scrollable();
      api.reload().begin();

      var name = Drupal.settings.ctaxo['vid_' + vid];
      var vals = $('#sidebar-left .edit-' + name).val() || [] ; // all selected values
      vals.splice($.inArray(tid, vals),1); // remove 
      $('.edit-' + name).val(vals); // update the new values

      ajaxify();
    });

    $("#taxobar .taxoterm").each(function(){
      $(".taxobar-tip").remove();
      $(this).unbind('click').click(function(){
        $(this).remove();
      });
    });
    // Remove the terms already selected and
    // grab these terms from the selectors instead
    $("#taxobar .staxoterm").each(function(){
      // The terms already in the bar are tagged with id="sterm_#".
      var term_id = $(this).attr("id").slice(1);
      $(this).remove();
      $('#' + term_id).trigger('click');
    });
    $("#sidebar-left .views-exposed-form select option:selected").each(function() {
      $('#term_' + $(this).val()).click();
    });

    //override clicking the 'sort' links
    $('.tabs.primary a').click(function(){
      //  grab the taxonomy in the taxobar and retrieve the page
      //  location.href = $(this).attr("href") + taxoPath;
      ajaxify($(this).attr("href"));
      $('.tabs.primary li').removeClass("active");
      $(this).parent().addClass("active");
      return false;
    });

    bindPager();

    initialized = true;

    // initialization complete. Function definition only below
    
    function bindPager() {
      //  override clicking the pager links
      $('.pager a').click(function(){
        ajaxify($(this).attr("href"));
        return false;
      });
      return false;
    }

    function ajaxify(basePath) {
      var url;
      var data;
      if (!initialized) {
        return false;
      }
      if (request) {
        // Abort any pending ajax calls
        request.abort();
      }
      if (!basePath) {
        basePath = $('.tabs.primary li.active a').attr("href");
        if (!basePath) {
          basePath = $("#taxobar a:first").attr("href");
        }
      }
//    langCode = basePath.substr(0,4); 
//    basePath = basePath.slice(3); // remove the language code
//    url = langCode + 'd' + basePath;
      url = '/d' + basePath;
      // serialize the selected values 
      data = $("#sidebar-left .views-exposed-form").parents('form').serialize();
      if (!data) {
        url += '?'; // Force clearing all filters.
      }
      
      $('#taxobar-throbber').css("display", "block");
      // remove any printed messages
      $('#content-header').remove();
      
      request = $.ajax({
        type : "GET",
        url : url,
        data : data,
        dataType : "json",
        error : function(data, textStatus, errorThrown) {
          $('#content-area').html('');
          $('#content-area').html('Server Error (' + textStatus + '). Please reload page.');
        },
        success : function(data) {
          $('#content-area').html('');
          $('#content-area').html(data.view);
          $('.pager-result').replaceWith(data.pager);
          $('#sidebar-right').html(data.blocks);
//        $('head').html(data.head);
//        $('head link[type="application/rss+xml"]').remove();
//        $('head').append(data.feeds);

          // rebind the flags
          if (Drupal.flagLink != null) {
            Drupal.flagLink(document);
          }
          // vertical align left bars
          creediaVerAlign();
          // rerun xfbml parser to process all fbml tags loaded via ajax
          if ($("#fb-root > *").length){
            FB.XFBML.parse(document.getElementById('content-area'));
          }
          // rerun Google's plusone
          if ($('.g-plusone-wrapper').length) {
        	gapi.plusone.go();
          }
          // Make sure slideshow do not show double images
          // I assume here only one slideshow per page
          if ($("#views_slideshow_main_1").length) {
            views_slideshow_init("1");
          }
          bindPager();
        },
        complete : function(data) {
          $('#taxobar-throbber').css("display", "none");

          // scroll to the top of the page (pressing pager links)
          $('html, body').animate({scrollTop:0}, 'slow');
        }
      }); // end of ajax call
    } // end of ajaxify def
  });
}