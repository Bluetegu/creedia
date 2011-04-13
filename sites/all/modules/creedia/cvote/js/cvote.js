/**
 * Modified Star Rating - jQuery plugin
 *
 * Copyright (c) 2006 Wil Stuckey
 *
 * Original source available: http://sandbox.wilstuckey.com/jquery-ratings/
 * Extensively modified by Lullabot: http://www.lullabot.com
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */

/**
 *  The following changes/hacks were made:
 *  
 *  Fivestar has two icon types; cancel and star. Here we need three types
 *  of icons; a negative, cancel or zero and positive stars. 
 *  
 *  - Add event handlers for the negative class (in addition to the cancel 
 *    star classes).
 *  
 *  - Changed mapping between average and star position. The voting is
 *    100 per star, and -100 for negative.
 */


/**
 * Create a degradeable star rating interface out of a simple form structure.
 * Returns a modified jQuery object containing the new interface.
 *   
 * @example jQuery('form.rating').rating();
 * @cat plugin
 * @type jQuery 
 *
 */
(function($){ // Create local scope.
    /**
     * Takes the form element, builds the rating interface and attaches the proper events.
     * @param {Object} $obj
     */
    var buildRating = function($obj){
        var $widget = buildInterface($obj),
            $stars = $('.star', $widget),
            $cancel = $('.cancel', $widget),
            $negative = $('.negative', $widget),
            $summary = $('.cvote-summary', $obj),
            feedbackTimerId = 0,
            summaryText = $summary.html(),
            summaryHover = $obj.is('.cvote-labels-hover'),
            currentValue = $("select", $obj).val(),
            cancelTitle = $('label', $obj).html(),
            voteTitle = cancelTitle != Drupal.settings.cvote.titleAverage ? cancelTitle : Drupal.settings.cvote.titleUser,
            voteChanged = false;

        // Record star display.
        if ($obj.is('.cvote-user-stars')) {
          var starDisplay = 'user';
        }
        else if ($obj.is('.cvote-average-stars')) {
          var starDisplay = 'average';
          currentValue = $("input[@name=vote_average]", $obj).val();
        }
        else if ($obj.is('.cvote-combo-stars')) {
          var starDisplay = 'combo';
        }
        else {
          var starDisplay = 'none';
        }

        // Smart is intentionally separate, so the average will be set if necessary.
        if ($obj.is('.cvote-smart-stars')) {
          var starDisplay = 'smart';
        }

        // Record text display.
        if ($summary.size()) {
          var textDisplay = $summary.attr('class').replace(/.*?cvote-summary-([^ ]+).*/, '$1').replace(/-/g, '_');
        }
        else {
          var textDisplay = 'none';
        }

        // Add hover and focus events.
        $stars
            .mouseover(function(){
                event.drain();
                event.fill(this);
            })
            .mouseout(function(){
                event.drain();
                event.reset();
            })
            .focus(function(){
                event.drain();
                event.fill(this)
            })
            .blur(function(){
                event.drain();
                event.reset();
            });
        
        // Cancel button events.
        $cancel
            .mouseover(function(){
                event.drain();
		event.hover(this, 2);
            })
            .mouseout(function(){
                event.reset();
                $(this).removeClass('hover')
            })
            .focus(function(){
                event.drain();
		event.hover(this, 2);
            })
            .blur(function(){
                event.reset();
                $(this).removeClass('hover')
            });
        // negative button events (ronc).
	// .... since negative is a single entity in this hack, it behaves similary to
	// cancel, i.e. it removes the class 'on' as opposed to 'filling' the stars
        $negative
            .mouseover(function(){
                event.drain();
		event.hover(this, 1);
            })
            .mouseout(function(){
                event.reset();
                $(this).removeClass('hover')
            })
            .focus(function(){
                event.drain();
		event.hover(this, 1);
            })
            .blur(function(){
                event.reset();
                $(this).removeClass('hover')
            });
        
        // Click events.
        $cancel.click(function(){
            currentValue = 0;
            event.reset();
            voteChanged = false;
            // Inform a user that his vote is being processed
            if ($("input.cvote-path", $obj).size() && $summary.is('.cvote-feedback-enabled')) {
              setFeedbackText(Drupal.settings.cvote.feedbackDeletingVote);
            }
            // Save the currentValue in a hidden field.
            $("select", $obj).val(0);
            // Update the title.
            cancelTitle = starDisplay != 'smart' ? cancelTitle : Drupal.settings.cvote.titleAverage;
            $('label', $obj).html(cancelTitle);
            // Update the smart classes on the widget if needed.
            if ($obj.is('.cvote-smart-text')) {
              $obj.removeClass('cvote-user-text').addClass('cvote-average-text');
              $summary[0].className = $summary[0].className.replace(/-user/, '-average');
              textDisplay = $summary.attr('class').replace(/.*?cvote-summary-([^ ]+).*/, '$1').replace(/-/g, '_');
            }
            if ($obj.is('.cvote-smart-stars')) {
              $obj.removeClass('cvote-user-stars').addClass('cvote-average-stars');
            }
            // Submit the form if needed.
            $("input.cvote-path", $obj).each(function () { $.ajax({ type: 'GET', dataType: 'xml', url: this.value + '/' + 0, success: voteHook }); });
            return false;
        });
        $stars.click(function(){
            currentValue = $('select option', $obj).get($stars.index(this) + $cancel.size() + $negative.size() + 1).value;
            // Save the currentValue to the hidden select field.
            $("select", $obj).val(currentValue);
            // Update the display of the stars.
            voteChanged = true;
            event.reset();
            // Inform a user that his vote is being processed.
            if ($("input.cvote-path", $obj).size() && $summary.is('.cvote-feedback-enabled')) {
              setFeedbackText(Drupal.settings.cvote.feedbackSavingVote);
            }
            // Update the smart classes on the widget if needed.
            if ($obj.is('.cvote-smart-text')) {
              $obj.removeClass('cvote-average-text').addClass('cvote-user-text');
              $summary[0].className = $summary[0].className.replace(/-average/, '-user');
              textDisplay = $summary.attr('class').replace(/.*?cvote-summary-([^ ]+).*/, '$1').replace(/-/g, '_');
            }
            if ($obj.is('.cvote-smart-stars')) {
              $obj.removeClass('cvote-average-stars').addClass('cvote-user-stars');
            }
            // Submit the form if needed.
            $("input.cvote-path", $obj).each(function () { $.ajax({ type: 'GET', dataType: 'xml', url: this.value + '/' + currentValue, success: voteHook }); });
            return false;
        });
	// 'negativ'e click event
	// 'negative' behaves similary to a (single) star.
        $negative.click(function(){
            currentValue = $('select option', $obj).get(1).value;
            // Save the currentValue in a hidden field.
            $("select", $obj).val(currentValue);
            // Update the display of the stars.
            voteChanged = true;
            event.reset();
            // Inform a user that his vote is being processed.
            if ($("input.cvote-path", $obj).size() && $summary.is('.cvote-feedback-enabled')) {
              setFeedbackText(Drupal.settings.cvote.feedbackSavingVote);
            }
            // Update the smart classes on the widget if needed.
            if ($obj.is('.cvote-smart-text')) {
              $obj.removeClass('cvote-average-text').addClass('cvote-user-text');
              $summary[0].className = $summary[0].className.replace(/-average/, '-user');
              textDisplay = $summary.attr('class').replace(/.*?cvote-summary-([^ ]+).*/, '$1').replace(/-/g, '_');
            }
            if ($obj.is('.cvote-smart-stars')) {
              $obj.removeClass('cvote-average-stars').addClass('cvote-user-stars');
            }
            // Submit the form if needed.
            $("input.cvote-path", $obj).each(function () { $.ajax({ type: 'GET', dataType: 'xml', url: this.value + '/' + currentValue, success: voteHook }); });
            return false;
        });

        var event = {
	    hover: function(el, index) {
                $(el).addClass('hover');
		if (summaryHover && !feedbackTimerId) {
                    var summary = $("select option", $obj)[index].text;
                    var value = $("select option", $obj)[index].value;
                    $summary.html(summary);
                    $('label', $obj).html(voteTitle);
		}
	    },
            fill: function(el){
              // Fill to the current mouse position.
              var index = $stars.index(el) + 1;
              $stars
                .children('a').css('width', '100%').end()
                .filter(':lt(' + index + ')').addClass('hover').end();
              // Update the description text and label.
              if (summaryHover && !feedbackTimerId) {
                  var summary = $("select option", $obj)[index + $cancel.size() + $negative.size()].text;
                  var value = $("select option", $obj)[index + $cancel.size() + $negative.size()].value;
                $summary.html(summary != index + 1 ? summary : '&nbsp;');
                $('label', $obj).html(voteTitle);
              }
            },
            drain: function() {
              // Drain all the stars.
              $stars
                .filter('.on').removeClass('on').end()
                .filter('.hover').removeClass('hover').end();
              $negative
                .filter('.on').removeClass('on').end()
                .filter('.hover').removeClass('hover').end();
              $cancel
                .filter('.on').removeClass('on').end()
                .filter('.hover').removeClass('hover').end();
		
              // Update the description text.
              if (summaryHover && !feedbackTimerId) {
                var cancelText = $("select option", $obj)[0].text;
                $summary.html(($cancel.size() && cancelText != 0) ? cancelText : '&nbsp');
                if (!voteChanged) {
                  $('label', $obj).html(cancelTitle);
                }
              }
            },
            reset: function(){
              // Reset the stars to the default index.
	      // ronc: modified the values to run between -100 to 100*stars
              var starValue = currentValue/100;
              var percent = (starValue - Math.floor(starValue)) * 100;
		if (starValue > 0) {
		    $stars.filter(':lt(' + Math.floor(starValue) + ')').addClass('on').end();
		    if (percent > 0) {
			$stars.eq(Math.floor(starValue)).addClass('on').children('a').css('width', percent + "%").end().end();
		    }
		}
		else if (starValue < 0) {
		    $negative.addClass('on');
// 		    if (percent > 0) {
// 			percent = 100 - percent;
// 			$negative.addClass('off').children('a').css('width', percent + "%").end().end();
// 		    }
		}
		else {
		    $cancel.addClass('on');
		}

              // Restore the summary text and original title.
              if (summaryHover && !feedbackTimerId) {
                $summary.html(summaryText ? summaryText : '&nbsp;');
              }
              if (voteChanged) {
                $('label', $obj).html(voteTitle);
              }
              else {
                $('label', $obj).html(cancelTitle);
              }
            }
        };

        var setFeedbackText = function(text) {
          // Kill previous timer if it isn't finished yet so that the text we
          // are about to set will not get cleared too early.
          feedbackTimerId = 1;
          $summary.html(text);
        };

        /**
         * Checks for the presence of a javascript hook 'cvoteResult' to be
         * called upon completion of a AJAX vote request.
         */
        var voteHook = function(data) {
          var returnObj = {
            result: {
              count: $("result > count", data).text(),
              average: $("result > average", data).text(),
              summary: {
                average: $("summary average", data).text(),
                average_count: $("summary average_count", data).text(),
                user: $("summary user", data).text(),
                user_count: $("summary user_count", data).text(),
                combo: $("summary combo", data).text(),
                count: $("summary count", data).text()
              }
            },
            vote: {
              id: $("vote id", data).text(),
	      tag: $("vote tag", data).text(),
              type: $("vote type", data).text(),
              value: $("vote value", data).text()
            },
            display: {
              stars: starDisplay,
              text: textDisplay
            }
          };
          // Check for a custom callback.
          if (window.cvoteResult) {
            cvoteResult(returnObj);
          }
          // Use the default.
          else {
            cvoteDefaultResult(returnObj);
          }
          // Update the summary text.
          summaryText = returnObj.result.summary[returnObj.display.text];
          if ($(returnObj.result.summary.average).is('.cvote-feedback-enabled')) {
            // Inform user that his/her vote has been processed.
            if (returnObj.vote.value != 0) { // check if vote has been saved or deleted 
              setFeedbackText(Drupal.settings.cvote.feedbackVoteSaved);
            }
            else {
              setFeedbackText(Drupal.settings.cvote.feedbackVoteDeleted);
            }
            // Setup a timer to clear the feedback text after 3 seconds.
            feedbackTimerId = setTimeout(function() { clearTimeout(feedbackTimerId); feedbackTimerId = 0; $summary.html(returnObj.result.summary[returnObj.display.text]); }, 2000);
          }
          // Update the current star currentValue to the previous average.
          if (returnObj.vote.value == 0 && (starDisplay == 'average' || starDisplay == 'smart')) {
            currentValue = returnObj.result.average;
            event.reset();
          }
        };

        event.reset();
        return $widget;
    };
    
    /**
     * Accepts jQuery object containing a single cvote widget.
     * Returns the proper div structure for the star interface.
     * 
     * @return jQuery
     * @param {Object} $widget
     * 
     */
    var buildInterface = function($widget){
        var $container = $('<div class="cvote-widget clear-block"></div>');
        var $options = $("select option", $widget);
        var size = $('option', $widget).size() - 1;
        var cancel = 1;
        for (var i = 1, option; option = $options[i]; i++){
	    if (i == 1) {
              $div = $('<div class="negative"><a href="#0" title="' + option.text + '">' + option.text + '</a></div>');
	    }
            else if (option.value == "0") {
              //cancel = 0;
              $div = $('<div class="cancel"><a href="#0" title="' + option.text + '">' + option.text + '</a></div>');
            }
            else {
              //var zebra = (i + cancel - 1) % 2 == 0 ? 'even' : 'odd';
              //var count = i + cancel - 1;
              //var first = count == 1 ? ' star-first' : '';
              //var last = count == size + cancel - 1 ? ' star-last' : '';
		// ronc: too much to think how to change this, and no one seems to use the additional notation
		var zebra = 'zebra';
		var count = i + cancel - 1;
		var first = '';
		var last = '';
              $div = $('<div class="star star-' + count + ' star-' + zebra + first + last + '"><a href="#' + option.value + '" title="' + option.text + '">' + option.text + '</a></div>');
            }
            $container.append($div[0]);
        }
        $container.addClass('cvote-widget-' + (size + cancel - 1));
        // Attach the new widget and hide the existing widget.
        $('select', $widget).after($container).css('display', 'none');
        return $container;
    };

    /**
     * Standard handler to update the average rating when a user changes their
     * vote. This behavior can be overridden by implementing a cvoteResult
     * function in your own module or theme.
     * @param object voteResult
     * Object containing the following properties from the vote result:
     * voteResult.result.count The current number of votes for this item.
     * voteResult.result.average The current average of all votes for this item.
     * voteResult.result.summary.average The textual description of the average.
     * voteResult.result.summary.user The textual description of the user's current vote.
     * voteResult.vote.id The id of the item the vote was placed on (such as the nid)
     * voteResult.vote.type The type of the item the vote was placed on (such as 'node')
     * voteResult.vote.tag The multi-axis tag the vote was placed on (such as 'vote')
     * voteResult.vote.average The average of the new vote saved
     * voteResult.display.stars The type of star display we're using. Either 'average', 'user', or 'combo'.
     * voteResult.display.text The type of text display we're using. Either 'average', 'user', or 'combo'.
     */
    function cvoteDefaultResult(voteResult) {
      // Update the summary text.
      $('div.cvote-summary-'+voteResult.vote.tag+'-'+voteResult.vote.id).html(voteResult.result.summary[voteResult.display.text]);
      // If this is a combo display, update the average star display.
      if (voteResult.display.stars == 'combo') {
        $('div.cvote-form-'+voteResult.vote.id).each(function() {
          // Update stars.
          var $stars = $('.cvote-widget-static .star span', this);
          var $negative = $('.cvote-widget-static .negative span', this);
          var average = voteResult.result.average/100;  // ronc: change calc
            var index = Math.floor(average);
	    $stars.removeClass('on').addClass('off').css('width', 'auto');
	    $negative.removeClass('on').addClass('off');
	    if (average > 0) {
		$stars.filter(':lt(' + (index + 1) + ')').removeClass('off').addClass('on');
		$stars.eq(index).css('width', ((average - index) * 100) + "%");
	    }
	    if (average < 0) {
		$negative.addClass('on');
		$negative.css('width', ((1-(average - index)) * 100) + "%");
	    }
          // Update summary.
          var $summary = $('.cvote-static-form-item .cvote-summary', this);
          if ($summary.size()) {
            var textDisplay = $summary.attr('class').replace(/.*?cvote-summary-([^ ]+).*/, '$1').replace(/-/g, '_');
            $summary.html(voteResult.result.summary[textDisplay]);
          }
        });
      }
    };

    /**
     * Set up the plugin
     */
    $.fn.rating = function() {
      var stack = [];
      this.each(function() {
          var ret = buildRating($(this));
          stack.push(ret);
      });
      return stack;
    };

  // Fix ie6 background flicker problem.
  if ($.browser.msie == true) {
    try {
      document.execCommand('BackgroundImageCache', false, true);
    } catch(err) {}
  }
})(jQuery);

if (Drupal.jsEnabled) {
  $(document).ready(function() {
    $('div.cvote-form-item').rating();
    $('input.cvote-submit').css('display', 'none');
  });
}