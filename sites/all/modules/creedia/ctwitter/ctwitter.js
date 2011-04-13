if (Drupal.jsEnabled) {
  $(document).ready(function(){
 
    var name = Drupal.settings.ctwitter.name;
    var url = 'http://twitter.com/statuses/user_timeline/' + name + '.json?callback=twitterCallback2&count=5';

    if (name) {
      var script = document.createElement('script');
      script.setAttribute('src', url);
      document.body.appendChild(script);
    }

  });
}