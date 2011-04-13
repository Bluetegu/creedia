/**
 * Javascript VirtualKeyboard
 */

if (Drupal.jsEnabled) {
  $(document).ready(function() {

    var selectLang = $('.jsvk-lang').length;

    // add VK buttons
    $('.jsvk-textfield').each(function(i) {
      var tid = $(this).attr('id'); // target id
      var bid = 'jsvk-button-' + i; // button id
      var button = '<input type="button" id="' + bid + '" value="Keyboard"/>';
      var kid = 'jsvk-keyboard-' + i;  // keyboard placeholder id
      var keyboard = '<div class="jsvk-keyboard" id="' + kid + '"></div>';
      // add the VK button and keyboard placeholder
      $(this).after(button).after(keyboard);
      // bind button to VK
      $('#' + bid).data('firstRun', {value:true}).bind("click", function(e){
	if (IFrameVirtualKeyboard.isOpen()) {
	  var active = $(this).hasClass('jsvk-active');
	  // close VK. VK is hidden, not closed.
	  IFrameVirtualKeyboard.toggle(tid, kid);
	  // remove active indication
	  $('.jsvk-active').removeClass('jsvk-active');
	  // detach inputs. Since VK is only hidden, if we do not detach
	  // inputs keyboard strokes will continue to use VK even if closed.
	  IFrameVirtualKeyboard.detachInput();
	  if (active) return false;
	}
	// open VK
        IFrameVirtualKeyboard.toggle(tid, kid);
	if ($(this).data('firstRun').value) {
	  // once the iframe is loaded the load event doesn't fire again. 
	  $('#jsvk-keyboard-'+ i + ' iframe').one('load', null, function() {
	    // Wait until load finished to set layout.
	    setLayout(i);
	    // set the iframe height to avoid scroll bars (FF only?)
	    // var h = $('iframe', '#jsvk-keyboard-' + i)[0].contentWindow.document.body.scrollHeight;
	    // $('iframe', '#jsvk-keyboard-' + i)[0].height = h;
	    // Setting width to 100% ensures that FF doesn't open scroll bars.
	    // Not sure why. The solution of setting the height (above) didn't work. Checked with IE6&7 
	    // Safari and FF.
	    $('iframe', '#jsvk-keyboard-' + i).width('100%');
	  });
	  $(this).data('firstRun', {value:false});
	}
	else {
	  var inputE = selectLang ?  $('.jsvk-textfield-' + i)[0] : $('#edit-field-origin-statement-0-value')[0];
	  IFrameVirtualKeyboard.attachInput(inputE);
	  // I'm not sure why delay is needed. Delay of 0 is not good enough
	  // setTimeout(setLayout, 1000, i);  // Doesn't work in IE...
	  setTimeout(function(){setLayout(i)}, 1000); 
	}
	// set active indication
	$(this).addClass('jsvk-active');
        return false;
      });
    });

//     // Attach input to allow multiple fields controlled by a single VK
//     $('.jsvk-textfield').each(function(i){
//       $(this).bind("focus", function(e){
//         IFrameVirtualKeyboard.attachInput(this);
//         return false;
//       });
//     });

    // Set statement lang and dir attributes
    // Chnage VK layout (language)
    $('.jsvk-lang').each(function(i){
      $(this).change(function(){
	var lang = $('option:selected', this)[0].value;
	var dir = Drupal.settings.jsvk.rtl[lang] ? 'rtl' : 'ltr';
	$('.jsvk-textfield-' + i).attr({'lang': lang, 'dir': dir});
	if ($('#jsvk-button-' + i).hasClass('jsvk-active')){
	  setLayout(i);
	}
      });
    });

    function setLayout(i) {
      // find active button and set the layout
      var lang = selectLang ?
//	$('.jsvk-lang-' + i + ' option:selected')[0].value:
	$('.jsvk-lang-' + i).val():  // we need the display value, not the option:selected one
	$('#edit-field-origin-statement-0-value').attr('lang');
      var layout = Drupal.settings.jsvk.layouts[lang];
      if (IFrameVirtualKeyboard.switchLayout(layout)== false){
	alert('Virtual Keyboard Layout Switch Failed: ' + layout);
      }
      // set focus to enable keyboard keystroke emulation
      // otherwise user has to set focus to textfield manually
      if (selectLang) {
	$('.jsvk-textfield-' + i).focus();
      }
      else {
	$('#edit-field-origin-statement-0-value').focus();
      }
    }
  });
}
