<!-- FACEBOOK INIT -->
        <div id="fb-root"></div>	
        <div id="bootloader"></div>
        <script>
          window.fbAsyncInit = function() {
            FB.init({
            appId: '97653614520',
            status : true,
            cookie: true,
            xfbml: true,
            oauth: true,
            channelUrl: ''
          });
		  
		  FB.Event.subscribe('edge.create', function(href, widget) {
			//alert("Like button clicked");
			$.post('addshare.php', {id: <?php echo $_GET['id']; ?>, sharecount: <?php echo $allsharecount; ?>}, function(){
				//successful ajax request
			  });
		  });
		  
		  _ga.trackFacebook();
          
          };
            (function() {
          var e = document.createElement('script'); e.async = true;
          e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
          document.getElementById('fb-root').appendChild(e);
          }());
          
          (function() {
          var e = document.createElement('script'); e.async = true;
          e.src = document.location.protocol + '//s7.addthis.com/js/250/addthis_widget.js';
          document.getElementById('bootloader').appendChild(e);
          
          var s = document.createElement('script'); e.async = true;
          s.src = document.location.protocol + '//static.ak.fbcdn.net/connect.php/js/FB.Share';
          document.getElementById('bootloader').appendChild(s);
          }());
      
        </script>
        
         <!-- TWITTER INIT -->
		<script type="text/javascript">
          (function(){
            var twitterWidgets = document.createElement('script');
            twitterWidgets.type = 'text/javascript';
            twitterWidgets.async = true;
            twitterWidgets.src = 'http://platform.twitter.com/widgets.js';
            
            // Setup a callback to track once the script loads.
            twitterWidgets.onload = _ga.trackTwitter;
            
            document.getElementsByTagName('head')[0].appendChild(twitterWidgets);
          })();
        </script>
      
        <!-- GOOGLE PLUS INIT -->
        <script type="text/javascript" src="<https://apis.google.com/js/plusone.js>"></script>