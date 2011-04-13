if (Drupal.jsEnabled) {
  $(document).ready(function(){

    window.fbAsyncInit = function() {
      FB.init({
	appId  : '114229845285022', // Creedia Comments AppID
	status : true, // check login status
	cookie : true, // enable cookies to allow the server to access the session
	xfbml  : true  // parse XFBML
      });
    };

    (function() {
      var e = document.createElement('script');
      e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
      e.async = true;
      document.getElementById('fb-root').appendChild(e);
    }());

  });
}