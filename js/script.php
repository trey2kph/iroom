// JavaScript Document
<?php 

include("config.php");

$moodlist = $main->get_mood();

echo '$(function() {	';

?>
	/* BALLOON */

	<?php foreach ($moodlist as $key => $mood) { ?>

	$("#balloon<?php echo $key + 1; ?>").hover(function() {
		$("#balloon<?php echo $key + 1; ?>").addClass("balloonholder2");	
		$("#balloont<?php echo $key + 1; ?>").addClass("balloontop2");	
	},function() {
		$("#balloon<?php echo $key + 1; ?>").removeClass("balloonholder2");	
		$("#balloont<?php echo $key + 1; ?>").removeClass("balloontop2");	
	});
  
  <?php } ?>

	/* BALLOON 2 */
  
  <?php foreach ($moodlist as $key => $mood) { ?>

	$("#aballoon<?php echo $key + 1; ?>").hover(function() {
		$("#taballoon<?php echo $key + 1; ?>").addClass("tballoonholder2");	
		$("#aballoont<?php echo $key + 1; ?>").addClass("balloontop2");	
	},function() {
		$("#taballoon<?php echo $key + 1; ?>").removeClass("tballoonholder2");	
		$("#aballoont<?php echo $key + 1; ?>").removeClass("balloontop2");	
	});
  
  <?php } ?>
		
	/* ADD MOOD */
	
  <?php foreach ($moodlist as $key => $mood) { ?>
  
	$("#aballoon<?php echo $key + 1; ?>").click(function(event){
			vmoodid = <?php echo $mood['mood_id']; ?>;
      vartid = $("#hidartid").val();
			$.post( 
				 "http://www.spot.ph/requests/addmood.php",
				 { 
						moodid: vmoodid,
						artid: vartid
				 },
				 function(data) {
						$('#artmoodset').html(data);
				 }
			);
	});
  
  <?php } ?>
  
  
      
  <?php if($_GET['artpage'] == 1) { ?>
    
  /* MOVE ARTICLE SOCIAL (ARTICLE) */

  if ($(window).width() > 999) {
  	
	$(window).scroll(function(){
		var contentdiv = $("#artcontent");
		var contentpos = contentdiv.position();
		var footerdiv = $("#footer");
		var footerpos = footerdiv.position();
        
        document.getElementById('adcon').style.position = "fixed";		     
        
		if ($(document).scrollTop() >= footerpos.top - 800) 
    {
         $('#skinningimg').hide("fade", 500);
         $('#skinninglink').hide("fade", 500);
		}
		
		else if ($(document).scrollTop() >= 600 - $("#artsocial2").height() + $("#artcontent").height() - 350) 
     {
         $('#skinningimg').show("fade", 500);
         $('#skinninglink').show("fade", 500);	 	
         
         document.getElementById('artsocial2').style.top = "15px";		 
         document.getElementById('artsocial2').style.position = "fixed";		 
         document.getElementById('artcontent').style.marginLeft = "48px";		 
         document.getElementById('artsocial2').style.display = "none";		
         
         $('#modal_box').width(580);
         $('#modal_box').height(580);
         $('#modal_box').css("top", "0");
         $('#m_right_column').hide();
         $('.gallery_lboard').hide();
         $('#modal_overlay').hide("fade", 500);
         $('.artsocial2').css( "zIndex", 15 );		
         $('.m_close').hide();		
         
		}
        
		else if (($(document).scrollTop() >= contentpos.top) || ($(document).scrollTop() >= 600)) 
    {
         $('#skinningimg').show("fade", 500);
         $('#skinninglink').show("fade", 500);	 	
         
         $('#bugreport').fadeIn();
         $('#backtotop').fadeIn(); 			 
         document.getElementById('artsocial2').style.top = "15px";		 
         document.getElementById('artsocial2').style.position = "fixed";
         document.getElementById('artcontent').style.marginLeft = "46px";
         document.getElementById('artsocial2').style.display = "inline-block";		 
		}
        
        else if ($(document).scrollTop() <= 600 - $("#artsocial2").height() + $("#artcontent").height() - 250 - 1100) 
        {
		 	 $('#bugreport').fadeOut();         
         	 $('#backtotop').fadeOut();
               
             $('#skinningimg').show("fade", 500);
             $('#skinninglink').show("fade", 500);	 	
             document.getElementById('artsocial2').style.top = "0px";
             document.getElementById('artsocial2').style.position = "relative";
             document.getElementById('artcontent').style.marginLeft = "0px";	
             document.getElementById('artsocial2').style.display = "inline-block";		 	
             
             $('#modal_box').width(580);
             $('#modal_box').height(580);
             $('#modal_box').css("top", "0");
             $('#m_right_column').hide();
             $('.gallery_lboard').hide();
             $('#modal_overlay').hide("fade", 500);
             $('.artsocial2').css( "zIndex", 15 );		
             $('.m_close').hide();		
		}		
		else
		{
    
         $('#skinningimg').show("fade", 500);
         $('#skinninglink').show("fade", 500);	 	
    
		 $('#bugreport').fadeOut();
		 $('#backtotop').fadeOut();
		 document.getElementById('artsocial2').style.top = "0px";
		 document.getElementById('artsocial2').style.position = "relative";
		 document.getElementById('artcontent').style.marginLeft = "0px";	
		 document.getElementById('artsocial2').style.display = "inline-block";
		}
	});
    
  } else {
  	
    $(window).scroll(function(){
		var contentdiv = $("#artcontent");
		var contentpos = contentdiv.position();
		var footerdiv = $("#footer");
		var footerpos = footerdiv.position();
        
		
		if ($(document).scrollTop() >= 600 - $("#socialmobile").height() + $("#artcontent").height() - 350) 
        {
		 document.getElementById('socialmobile').style.top = "15px";		 
		 document.getElementById('socialmobile').style.position = "fixed";		 
		 document.getElementById('socialmobile').style.display = "none";		
         
		}
        
		else if (($(document).scrollTop() >= contentpos.top) || ($(document).scrollTop() >= 600)) 
        {
		 $('#bugreport').fadeIn();
		 $('#backtotop').fadeIn(); 			 
		 document.getElementById('socialmobile').style.top = "15px";		 
		 document.getElementById('socialmobile').style.position = "fixed";
		 document.getElementById('socialmobile').style.display = "inline-block";		 
		}
        
        else if ($(document).scrollTop() <= 600 - $("#socialmobile").height() + $("#artcontent").height() - 250 - 1100) 
        {
		 	 $('#bugreport').fadeOut();         
         	 $('#backtotop').fadeOut();
             document.getElementById('socialmobile').style.top = "0px";
             document.getElementById('socialmobile').style.position = "relative";	
             document.getElementById('socialmobile').style.display = "inline-block";		 	
             
		}		
		else
		{
		 $('#bugreport').fadeOut();
		 $('#backtotop').fadeOut();
		 document.getElementById('socialmobile').style.top = "0px";
		 document.getElementById('socialmobile').style.position = "relative";	
		 document.getElementById('socialmobile').style.display = "inline-block";
		}
	});
  
  }
    
  <?php } else {  ?>
  
  
    
  /* MOVE ARTICLE SOCIAL (HOME) */
	
	$(window).scroll(function(){
		var footerdiv = $("#footer");
		var footerpos = footerdiv.position();
		
        
		if ($(document).scrollTop() >= footerpos.top - 800) 
        {
         $('#skinningimg').hide("fade", 500);
         $('#skinninglink').hide("fade", 500);
		}
        
		else if ($(document).scrollTop() >= 600) {
         $('#backtotop').fadeIn(); 
         $('#bugreport').fadeIn();
         $('#skinningimg').show("fade", 500);
         $('#skinninglink').show("fade", 500);	 	
		}
        
		else
		{
		 $('#backtotop').fadeOut();
		 $('#bugreport').fadeOut();	
         $('#skinningimg').show("fade", 500);
         $('#skinninglink').show("fade", 500);	 	
		}
	});
    
  <?php } ?>
  
  <?php if ($_GET["cslug"] == 1) { ?>
  
  /* SOCIAL EXPAND (ESTABLISHMENT) */
	
  $('#artsocial2').hover(function(){			
  		$('#socialdiv').animate({ width: "280px" }, 100, function() { $('#socialright').css('opacity', 1); $('#socialright').css('position', 'relative'); $('#socialright').css('left', '0px'); });					 	
  }, function() {
  		$('#socialright').css('position', 'absolute'); 
        $('#socialright').css('left', '-5000px');
  		$('#socialright').css('opacity', 0);
  		$('#socialdiv').animate({ width: "30px" }, 100, function() { $('#socialright').css('position', 'absolute'); $('#socialright').css('left', '-5000px');$('#socialright').css('opacity', 0); });					 	
  });
  
  <?php } else { ?>
  
  /* SOCIAL EXPAND (ARTICLE) */
	
  $('#artsocial2').hover(function(){			
  		$('#socialdiv').animate({ width: "230px" }, 100, function() { $('#socialright').css('opacity', 1); $('#socialright').css('position', 'relative'); $('#socialright').css('left', '0px'); });					 	
  }, function() {
  		$('#socialright').css('position', 'absolute'); 
        $('#socialright').css('left', '-5000px');
  		$('#socialright').css('opacity', 0);
  		$('#socialdiv').css('width', '30px');					 	
  });
  
  <?php } ?>  
  

});

