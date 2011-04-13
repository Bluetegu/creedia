/**
 *  Order list of creeds through drag and drop
 *
 *  Tabs using jquery.ui.tabs
 *
 */

if (Drupal.jsEnabled) {
  $(document).ready(function() {

    // OLD PROFILE CODE - TO BE REMOVED
    // hide/show interpretations
    $('#cprofile-hide').toggle(function() {
      $('.interpretation-wrapper').css("display", "block");
      $('#cprofile-hide-hide').show();
      $('#cprofile-hide-show').hide();
      $('.tip').text(" ");
    }, 
			       function() {
      $('.interpretation-wrapper').css("display", "none");
      $('#cprofile-hide-hide').hide();
      $('#cprofile-hide-show').show();
			       });

    // Initialize facet
    facetInit();

    if (Drupal.settings.cprofile.order) {

      // make creed panels sortable
      sortableInit();

      // Initialize the hidden multi-select boxes
      // Override Firefox caching problem
      // selectInit();
      
      // catch the profile howto flag event and hide the message
      $(document).bind('flagGlobalAfterLinkUpdate', function(event, data){
	if (data.flagName == 'profile_howto' && data.flagStatus == 'flagged') {
	  $('#cprofile-howto').hide();
	}
      });

      var hiConfig = {
	sensitivity: 3, // sensitivity threshold > 1
	interval: 500, // milliseconds onMouseOver polling interval
	over: hoverIntentOver,
	timeout: 500, // milliseconds delay before onMouseOut
	out: hoverIntentStub
      };

      $('.cprofile-entry-tags').hoverIntent(hiConfig);
      
      $('.creed-footer .footer-close').click(function() {
	$(this).parents('.creed-panel')
	.removeClass('in-edit')
	.css('background-color','transparent').css('cursor', 'pointer')
	.find('.ajax-os').hide()
	.end()
	.find('.creed-footer').slideUp()
	.end()
	.find('.terms-religion').unbind('click')
	.find('img').each(function(i){
	  $(this).attr('title', $(this).attr('alt'));
	});
	// remove the creed panel if it was unflagged
	if ($(this).parent().find('.flag-adopt .unflagged').length) {
	  $(this).parents('.creed-panel').remove();
	}
	return false;
      });

      $('.os-select:input').change(function(){
	var i = $(this).val();
	$(this).parents('.creed-panel').find('.origin-statement')
	.css("display", "none")
	.eq(i).css("display", "block");
 	saveAttrAjax($(this).parents('.creed-panel'));
      });
    }

    var optionsInit = [];
    // functions

    function selectInit() {
      // Initialize select elements changed by js
      // Avoid Firefox bug that keeps in cache the selected values
      $('.select-init').each(function(i) {
	optionsInit = [];
	//$('option:selected', $(this)).each(function(j) {
	$("option[selected='selected']", $(this)).each(function(j) {
	  optionsInit.push($(this).attr('value'));
	});
	$(this).val(optionsInit);
      });
    }

    /// Hover Intent

    // called when hoverIntent decides user did intend to hover
    function hoverIntentOver() {
      var panel = $(this).parents('.creed-panel');

      $('.creed-footer', panel).slideDown();

      if (panel.hasClass('in-edit') == false) {
	panel.css('background-color','white')
	.addClass('in-edit')
	.css('cursor', 'default')
	.find('.ajax-os').show();

	$('.terms-religion', $(this)).each(function(i){
	  // Todo change to PHP set strings (for translation)
	  var title = $(this).hasClass('terms-enabled') ? 'Click to Disable' : 'Click to Enable';
	  $('img', this).attr('title', title);
	});

	$('.terms-religion', $(this)).click(function(){
	  var cid = $(this).attr('id').split('-')[1]; // term-cid-tid
	  var tid = $(this).attr('id').split('-')[2]; // term-cid-tid

	  var options = $('#edit-religion-' + cid).val() || [];

	  if ($(this).hasClass('terms-disabled')) {
	    $(this).removeClass('terms-disabled').addClass('terms-enabled');
	    $('img', this).attr('title', 'Click to Disable');
	    options.push(tid); // add the option
	    //$(this).siblings('.ajax-terms').find('option[value=' + tid + ']').attr("selected", "selected");
	  }
	  else {
	    $(this).removeClass('terms-enabled').addClass('terms-disabled');
	    $('img', this).attr('title', 'Click to Enable');
	    i = jQuery.inArray(tid, options);
	    if (i > -1) {
	      options.splice(i,1); // remove the option
	    }
	    //$(this).siblings('.ajax-terms').find('option[value=' + tid + ']').removeAttr('selected');
	  }
	  $('#edit-religion-' + cid).val(options);
	  saveAttrAjax($(this).parent().parent());
	  return false;
	});

      }
      return false;
    }

    function hoverIntentStub() {
//      alert('in stub');
      return false;
    }

    /// Sortable

    function sortableInit() {
      // indicate drag and drop
      $('.creed-panel').css("cursor", "pointer");

      // unbind clicking the creed titles
      $('.cprofile-creed-list a')
      .bind("dblclick",function(){return false;})
      .bind("click", function(){return false;});

      // make the creed panels sortable
      $('.cprofile-creed-list').sortable({
	connectWith: $('.cprofile-creed-list'),
	update: function(event, ui) {
	  //console.log(event);
	  //console.log(ui);
	  if (ui.sender == null) {
	    // when creed panels are moved from one facet to another
	    // update is called twice. Call save once.
	    saveAjax();
	  }
	},
	receive: function(event, ui) {
	  $(this).parents('.cprofile-facet.tcollapsed').find('.tool-expand').click();
	}
      });
    }

    /// Facet Functions

    function facetInit(){
      // run over the facets and set appropriate classes
      $('.cprofile-facet').addClass('texpanded')
      .filter(':not(:last)')
      .filter(':not(:first)').addClass('up').end()
      .filter(':not(:last)').addClass('down').end()
      .filter(':not(:has(li:not(.jt-drop)))').addClass('delete');
      
      // Bind tool behavior
      facetToolBind();
    }

    function facetUpdate(){
      // run over the facets and set appropriate classes
      if (tool != 'collapse' && tool != 'expand' && tool != 'save') {
	$('.cprofile-facet').addClass('save');
      }
      $('.cprofile-facet').removeClass('up').removeClass('down')
      .filter(':not(:last)')
      .filter(':not(:first)').addClass('up').end()
      .filter(':not(:last)').addClass('down').end()
      .filter('.delete').removeClass('delete').end()
      .filter('.texpanded')
      .filter(':not(:has(li:not(.jt-drop)))').addClass('delete').end()
      .filter(':has(li:not(.jt-drop))').removeClass('delete');
    }

    function facetToolBind(){
      // unbind double clicking tools
      $('.tool').unbind('dblclick');

      $('.tool').each(function(i) {
	// id is tool-<name>-i
	var type = $(this).attr('id').split('-')[1];
	switch(type) {
	case 'collapse':
	  $(this).click(function() {
	    var facet = $(this).parents('.cprofile-facet');
	    facet.removeClass('texpanded').addClass('tcollapsed');
	    $('.creed-panel', facet).slideUp("normal");
	    tool = 'collapse';
	    return false;
	  });
	  break;
	case 'expand':
	  $(this).click(function(facet) {
	    var facet = $(this).parents('.cprofile-facet');
	    facet.removeClass('tcollapsed').addClass('texpanded');
	    $('.creed-panel', facet).slideDown("normal");
	    tool = 'expand';
	    return false;
	  });
	  break;
	case 'delete':
	  $(this).click(function() {
	    var facet = $(this).parents('.cprofile-facet');
	    facet.remove();
	    tool = 'delete';
	    facetUpdate();
	    return false;
	  });
	  break;
	case 'up':
	  $(this).click(function() {
	    var facet = $(this).parents('.cprofile-facet');
	    var facetId = facet.attr("id");
//.slice('facet-'.length);;
	    facet.prev().insertAfter('#' + facetId);

	    //appendTo('#' + facetId);
	    tool = 'up';
	    facetUpdate();
	    saveAjax();
	    return false;

	  });
	  break;
	case 'down':
	  $(this).click(function() {
	    var facet = $(this).parents('.cprofile-facet');
	    var facetId = facet.attr("id");
	    facet.next().insertBefore('#' + facetId);
	    tool = 'down';
	    facetUpdate();
	    saveAjax();
	    return false;
	  });
	  break;
	case 'save':
	  $(this).click(function(){
	    saveAjax();
	    tool = 'save';
	    return false;
	  });
	  break;
	case 'more':
	case 'less':
	case 'throbber':
	  // do nothing
	  break;
	default:
	  alert('Unknown tool ' + type);
	  break;
	}

      });
    }

    var saveAttrAjax = function(e) {
      $('.cprofile-facet').addClass('throbber');

      // Serialize the order of facets and creed panels. 
      // Each facet number is included in a hidden input field in the title 
      // Each panel number is included in a hidden input field as well
      // Ignore the ui-sortable creed panel placeholder to avoid duplicate creed numbers sent to server
      var attr = $('select', e).serialize();

      $.ajax({
        type : "POST",
        url : Drupal.settings.cprofile.basepath + 'attr',
	data: attr,
        dataType : "json",
        error : function(msg) {
	  alert(Drupal.settings.cprofile.attrErrorMessage);
	  return false;
        },
        success : function(msg) {
          if (msg.success) {
          }
          else {
            alert(msg.msg);
          }
	  return false;
        },
	complete : function(msg) {
	  $('.cprofile-facet').removeClass('throbber');
	  return false;
	}
      });
    };
    
    var saveAjax = function() {
      $('.cprofile-facet').removeClass('save').addClass('throbber');

//      var facets = $('.cprofile-facet-title-bar input:hidden').each(function(i){
//        $(this).attr("name", i);
//      }).serialize();
      
      // Serialize the order of facets and creed panels. 
      // Each facet number is included in a hidden input field in the title 
      // Each panel number is included in a hidden input field as well
      // Ignore the ui-sortable creed panel placeholder to avoid duplicate creed numbers sent to server
      var creeds = $(".cprofile-facet-title-bar input:hidden, .creed-panel:not(.ui-sortable-placeholder) > input:hidden").each(function(i) {
	var pid = $(this).parents('.cprofile-facet').attr("id").slice(6); // remove the 'facet-'
        $(this).attr("name", pid + '-' + i);
      }).serialize();

      $.ajax({
        type : "POST",
        url : Drupal.settings.cprofile.basepath + 'order',
//        data : ({'creeds' : creeds,
//		 'facets' : facets }),
	data: creeds,
        dataType : "json",
        error : function(msg) {
	  alert(Drupal.settings.cprofile.orderErrorMessage);
	  return false;
        },
        success : function(msg) {
          if (msg.success) {
          }
          else {
            alert(msg.msg);
          }
	  return false;
        },
	complete : function(msg) {
	  $('.cprofile-facet').removeClass('throbber');
	  return false;
	}
      });
    };

  });
}

