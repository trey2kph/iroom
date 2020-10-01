<!-- FOOTER -->
            
            </div>
            </div>				        
          </div>
        	
          <div id="bottom" class="bottom">
            <div id="bottomcontainer" class="bottomcontainer">
              
            </div>				        
          </div>
          <div id="footer" class="footer">
            <div id="footercontainer" class="footercontainer">
            	
              <div id="copyright" class="copyright">
                <div class="lcopyright whitetext roboto mediumtext2">
                	&copy; <?php echo date("Y"); ?> Fortunegate Holdings Philippines Inc., All Rights Reserved
                 </div>
              </div>
            </div>				        
        	
          </div>
        
		</div>        				
        
    <!-- JAVASCRIPTS -->
		<script type="text/javascript" src="<?php echo JS; ?>/jquery-ui.js"></script>    
    <script type="text/javascript" src="<?php echo JS; ?>/jquery.touchwipe.min.js"></script>    
    <script type="text/javascript" src="<?php echo JS; ?>/jquery.cycle.lite.js"></script>
    <script type="text/javascript" src="<?php echo JS; ?>/jquery.resizecrop.min.js"></script>
    <script type="text/javascript" src="<?php echo JS; ?>/jquery.marquee.min.js"></script>
    <script type="text/javascript" src="<?php echo JS; ?>/jquery.cycle.js"></script>
    <script type="text/javascript" src="<?php echo JS; ?>/jquery.hoverIntent.min.js"></script>
    <script type="text/javascript" src="<?php echo JS; ?>/modernizr.js"></script>
    <script type="text/javascript" src="<?php echo JS; ?>/jquery.resizecrop.min.js"></script>
    <script type="text/javascript" src="<?php echo JS; ?>/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="<?php echo JS; ?>/jquery.jscrollpane.min.js"></script>
    <script type="text/javascript" src="<?php echo JS; ?>/fullcalendar.js"></script>
    <script type="text/javascript" src="<?php echo JS; ?>/colorpicker.js"></script>
    <script type="text/javascript" src="<?php echo JS; ?>/jquery-ui-timepicker-addon.js"></script>

    <!-- FOR IFRAME UPLOAD -->
    <script type="text/javascript" src="<?php echo JS; ?>/jquery.iframe-post-form.js"></script>
    <script type="text/javascript" src="<?php echo JSCRIPT; ?>/iframe-post-form.php"></script>
        
    <!-- LOCAL JAVASCRIPTS -->
    <script type="text/javascript" src="<?php echo JSCRIPT; ?>/plugins.php<?php 
                if ($_GET['roomid']) echo "?roomid=".$_GET['roomid'];
                elseif ($_GET['page']) echo "?page=".$_GET['page'];
                elseif ($_GET['roomid'] && $_GET['page']) echo "?roomid=".$_GET['roomid']."&page=".$_GET['page'];
                else echo "";  
            ?>"></script>
    <?php if ($_GET['section'] == "reservation") { ?><script type="text/javascript" src="<?php echo JSCRIPT; ?>/rcalendar.php<?php echo $_GET['roomid'] ? "?roomid=".$_GET['roomid'] : ""; ?>"></script>
    <?php } else { ?><script type="text/javascript" src="<?php echo JSCRIPT; ?>/rcalendar2.php<?php echo $_GET['roomid'] ? "?roomid=".$_GET['roomid'] : ""; ?>"></script><?php } ?>
        
  </body>
</html>