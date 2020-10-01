     
        <!-- asynchronous google analytics: mathiasbynens.be/notes/async-analytics-snippet change the UA-XXXXX-X to be your site's ID -->
        <script type="text/javascript">
          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', '']); <!-- GOOGLE SITE ID HERE -->
          _gaq.push(['_trackPageview']);
          _gaq.push(['_trackPageLoadTime']);
          _gaq.push(['summitmediaTracker._setAccount', 'UA-252180-1']); // for summitmedia
          (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();
        </script>
        
       <script type="text/javascript">
          function richMediaClicks(category,action) {
            _gaq.push(['summitmediaTracker._trackEvent', ''+category+'', ''+action+'']);
          }
        </script> 