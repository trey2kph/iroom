<?php include("../config.php"); ?>
// JavaScript Document

$(function() {	


	/* MAIN NAVIGATION */
	
	$("#nav1").live("click", function(){ parent.location='http://portal.megaworldcorp.com/papyrus.php'; return false; });
	$("#nav2").live("click", function(){ parent.location='http://portal.megaworldcorp.com/ihelp/'; return false; });
	$("#nav3").live("click", function(){ parent.location='http://portal.megaworldcorp.com/hr/'; return false; });
	$("#nav4").live("click", function(){ parent.location='http://portal.megaworldcorp.com/availability/'; return false; });
	$("#nav5").live("click", function(){ parent.location='http://portal.megaworldcorp.com/#'; return false; });

	$("#nav1").hover(function() {		
		$("#ftab1").hide();
		$("#ntab1").show();
		$("#tabtext1").addClass("lgraytext");	
	},function() {
		$("#ntab1").hide();
		$("#ftab1").show();
		$("#tabtext1").removeClass("lgraytext");	
	});
	
	$("#nav2").hover(function() {		
		$("#ftab2").hide();
		$("#ntab2").show();
		$("#tabtext2").addClass("lgraytext");	
	},function() {
		$("#ntab2").hide();
		$("#ftab2").show();
		$("#tabtext2").removeClass("lgraytext");	
	});
	
	$("#nav3").hover(function() {		
		$("#ftab3").hide();
		$("#ntab3").show();
		$("#tabtext3").addClass("lgraytext");	
	},function() {
		$("#ntab3").hide();
		$("#ftab3").show();
		$("#tabtext3").removeClass("lgraytext");	
	});
	
	$("#nav4").hover(function() {		
		$("#ftab4").hide();
		$("#ntab4").show();
		$("#tabtext4").addClass("lgraytext");	
	},function() {
		$("#ntab4").hide();
		$("#ftab4").show();
		$("#tabtext4").removeClass("lgraytext");	
	});
	
	$("#nav5").hover(function() {		
		$("#ftab5").hide();
		$("#ntab5").show();
		$("#tabtext5").addClass("lgraytext");	
	},function() {
		$("#ntab5").hide();
		$("#ftab5").show();
		$("#tabtext5").removeClass("lgraytext");	
	});

	$(".closeEvDetail").live("click", function() {		
		$("#floatDiv").addClass("invisible");
		$("#rcal").addClass("invisible");
		$("#redit").addClass("invisible");
		$("#rdel").addClass("invisible");
		$("#rpost").addClass("invisible");
	});

	$(".closeEvCon").live("click", function() {		
		$("#floatDiv").addClass("invisible");
		$("#rcon").addClass("invisible");
		ajaxEvents();
        ajaxEvents2();
	});

	$(".openEvDetail").live("click", function() {	
		$("#floatDiv").removeClass("invisible");	
		$(".rdel").addClass("invisible");	
		$(".redit").addClass("invisible");	
		$(".rcal").removeClass("invisible");
		$(".rpost").addClass("invisible");	
	    $(".rcalinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');

		eventid = $(this).attr('attribute');
		eventcolor = $(this).attr('attribute2');
		del = 0;

		$(".rcal").css("background-color", eventcolor);

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/eventdetail.php",
	        data: "resid=" + eventid,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            $(".rcalinfo").html(data);
	        }
	    })

	    return false;
	});

	$(".editEvDetail").live("click", function() {	
		$("#floatDiv").removeClass("invisible");		
		$(".rcal").addClass("invisible");		
		$(".redit").removeClass("invisible");
		$(".rdel").addClass("invisible");
		$(".rpost").addClass("invisible");
	    $(".reditinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');	

		eventid = $(this).attr('attribute');
		eventcolor = $(this).attr('attribute2');
		edit = 1;

		$("#editEvId").val(eventid);		

		$(".redit").css("background-color", eventcolor);

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/eventdetail.php",
	        data: "resid=" + eventid + "&edit=" + edit,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            $(".reditinfo").html(data);
	        }
	    })

	    return false;
	});

	$(".delEvDetail").live("click", function() {
		$("#floatDiv").removeClass("invisible");			
		$(".rcal").addClass("invisible");
		$(".redit").addClass("invisible");		
		$(".rdel").removeClass("invisible");
		$(".rpost").addClass("invisible");	
	    $(".rdelinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');

		eventid = $(this).attr('attribute');
		eventcolor = $(this).attr('attribute2');
		del = 1;

		$("#delEvId").val(eventid);		

		$(".rdel").css("background-color", eventcolor);

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/eventdetail.php",
	        data: "resid=" + eventid + "&delete=" + del,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            $(".rdelinfo").html(data);
	        }
	    })

	    return false;
	});

	$("#editEvent").live("click", function() {	
		$("#floatDiv").removeClass("invisible");		
		$(".redit").addClass("invisible");	
		$(".rcon").removeClass("invisible");	
        $(".rconinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');

		eventid = $("#editEvId").val();		
		room = $("#reserve_roomid option:selected").val();	
		eventname = $("#reserve_eventname").val();
		datein = $("#reserve_datein").val();	
		timein = $("#reserve_timein").val();			
		timeout = $("#reserve_timeout").val();	
		person = $("#reserve_person option:selected").val();	
		notes = $("#reserve_notes").val();
		reason = $("#reserve_reason").val();
		fullname = $("#user_fullname").val();		
		email = $("#user_email").val();		

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/eventedit.php",
	        data: "reserve_id=" + eventid + "&reserve_roomid=" + room + "&reserve_eventname=" + eventname + "&reserve_datein=" + datein + "&reserve_timein=" + timein + "&reserve_timeout=" + timeout + "&reserve_person=" + person + "&reserve_notes=" + notes + "&reserve_reason=" + reason + "&user_fullname=" + fullname + "&user_email=" + email,
	        type: "POST",
	        success: function(data) {
	            $(".rconinfo").html(data);
	        }
	    })

	    return false;
	});

	$("#delEvent").live("click", function() {
		$("#floatDiv").addClass("invisible");			
		$(".rdel").addClass("invisible");		

		eventid = $("#delEvId").val();		
		reason = $("#reserve_notes").val();
		fullname = $("#user_fullname").val();		
		email = $("#user_email").val();		

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/eventdelete.php",
	        data: "resid=" + eventid + "&reserve_reason=" + reason + "&user_fullname=" + fullname + "&user_email=" + email,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            ajaxEvents();
                ajaxEvents2();
	        }
	    })

	    return false;
	});

	$(".delRoom").live("click", function() {		

		roomid = $(this).attr('attribute');

		var r = confirm("Are you sure you want to delete");
		if (r == true)
		{
			$.ajax(
		    {
		        url: "<?php echo WEB; ?>/lib/requests/roomdelete.php",
		        data: "roomid=" + roomid,
		        type: "POST",
		        complete: function(){
		        	$("#loading").hide();
		    	},
		        success: function(data) {
		            window.location.href  =  window.location.href;
		        }
		    })

		    return false;
		}
		
	});

	$(".delUser").live("click", function() {		

		userid = $(this).attr('attribute');

		var r = confirm("Are you sure you want to delete");
		if (r == true)
		{
			$.ajax(
		    {
		        url: "<?php echo WEB; ?>/lib/requests/userdelete.php",
		        data: "userid=" + userid,
		        type: "POST",
		        complete: function(){
		        	$("#loading").hide();
		    	},
		        success: function(data) {
		            window.location.href  =  window.location.href;
		        }
		    })

		    return false;
		}
		
	});

	$(".delLoc").live("click", function() {		

		locid = $(this).attr('attribute');

		var r = confirm("Are you sure you want to delete");
		if (r == true)
		{
			$.ajax(
		    {
		        url: "<?php echo WEB; ?>/lib/requests/locdelete.php",
		        data: "locid=" + locid,
		        type: "POST",
		        complete: function(){
		        	$("#loading").hide();
		    	},
		        success: function(data) {
		            window.location.href  =  window.location.href;
		        }
		    })

		    return false;
		}
		
	});

    $(".approveRoom").live("click", function() {		

        roomid = $(this).attr('attribute');	
        roomstatus = $(this).attr('attribute2');		
        $(".rstatusDiv" + roomid).html('<i class="fa fa-refresh fa-spin"></i>');

        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/roomapprove.php",
	        data: "roomid=" + roomid + "&room_status=" + roomstatus,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            $(".rstatusDiv" + roomid).html(data);
	        }
        })

        return false;
    });

	$(".approveUser").live("click", function() {		

		userid = $(this).attr('attribute');	
		userstatus = $(this).attr('attribute2');		
        $(".ustatusDiv" + userid).html('<i class="fa fa-refresh fa-spin fa-lg"></i>');
		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/userapprove.php",
	        data: "userid=" + userid + "&user_status=" + userstatus,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            $(".ustatusDiv" + userid).html(data);
	        }
	    })

	    return false;
	});

	$(".postEvDetail").live("click", function() {		
		$(".rdel").addClass("invisible");		
		$(".rcal").addClass("invisible");		
		$(".rpost").removeClass("invisible");
	    $(".rpostinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');	

		eventid = $(this).attr('attribute');
		eventcolor = $(this).attr('attribute2');
		post = 1;

		$("#postEvId").val(eventid);		

		$(".rpost").css("background-color", eventcolor);

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/eventdetail.php",
	        data: "resid=" + eventid + "&post=" + post,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            $(".rpostinfo").html(data);
	        }
	    })

	    return false;
	});

	$("#postEvent").live("click", function() {		
		$(".rpost").addClass("invisible");		

		eventid = $("#postEvId").val();		

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/eventpost.php",
	        data: "resid=" + eventid,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            window.location.href  =  window.location.href;
	        }
	    })

	    return false;
	});

    // logs from
    $(".fromlogs").datepicker({ 
        dateFormat: 'yy-mm-dd',
        minDate: "2014-01-01",
        maxDate: "0D",
        changeMonth: true,
        onClose: function(selectedDate) {
            $(".tologs").datepicker("option", "minDate", selectedDate);
        }
    });

    // logs to
    $(".tologs").datepicker({ 
        dateFormat: 'yy-mm-dd',
        minDate: "2014-01-01",
        maxDate: "0D",
        changeMonth: true,
        onClose: function(selectedDate) {
            $(".fromlogs").datepicker("option", "maxDate", selectedDate);
        }
    });

    $(".checkindate").datepicker({ 
        dateFormat: 'yy-mm-dd',
        minDate: "0D",
        maxDate: "3M",
        changeMonth: true,
        beforeShowDay: function(date) {
            var day = date.getDay();
            return [(day != 0), ''];
        }
    });

    $('.timein').timepicker({ 
        timeFormat: 'h:mmtt',
        stepHour: 1,
        stepMinute: 30,
        hourMin: 6,
	    hourMax: 22
    });


    $(".txtcolor").ColorPicker({
		onChange: function (hsb, hex, rgb) {
			$('.txtcolor').val('#' + hex);
			$('.txtcolor').css("background-color", '#' + hex);
		}
	});

	$(".reserve_locid").change(function() {	
		locid = $("#reserve_locid option:selected").val();
	    $.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/roomsel.php",
            data: "locid=" + locid,
            type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            $(".reserve_roomid").html(data);
	        }
	    })
	});

    $(".caltab1").live("click", function() {		
		
        $(".caltab1").addClass("calsel");	
		$(".caltab2").removeClass("calsel");
        $(".calview1").removeClass("nodisplay");	
		$(".calview2").addClass("nodisplay");
        runCal();

	    return false;
	});

    $(".caltab2").live("click", function() {		
		
        $(".caltab2").addClass("calsel");	
		$(".caltab1").removeClass("calsel");
        $(".calview2").removeClass("nodisplay");	
		$(".calview1").addClass("nodisplay");

	    return false;
	});

	$("#username").live("keypress", function(e) {
        if (e.keyCode == 13) {
            username = $("#username").val();
			password = $("#password").val();
		    $.ajax(
		    {
		        url: "<?php echo WEB; ?>/lib/requests/login.php",
	            data: "username=" + username + "&password=" + password,
	            type: "POST",
		        complete: function(){
		        	$("#loading").hide();
		    	},
		        success: function(data) {
		        	if (data == 0) { 
		        		$('#errortd').html('<span class="redtext mediumtext2 bold">Access denied</span>'); 
		        		$('.lowerlogin').effect('shake', {times: 3, distance: 10}, 500); 
		        	}
		        	else { 
		        		window.location.href='<?php echo WEB; ?>';
		        	}
		        }
		    })
        }
	});

	$("#password").live("keypress", function(e) {
        if (e.keyCode == 13) {
            username = $("#username").val();
			password = $("#password").val();
		    $.ajax(
		    {
		        url: "<?php echo WEB; ?>/lib/requests/login.php",
	            data: "username=" + username + "&password=" + password,
	            type: "POST",
		        complete: function(){
		        	$("#loading").hide();
		    	},
		        success: function(data) {
		        	if (data == 0) { 
		        		$('#errortd').html('<span class="redtext mediumtext2 bold">Access denied</span>'); 
		        		$('.lowerlogin').effect('shake', {times: 3, distance: 10}, 500); 
		        	}
		        	else { 
		        		window.location.href='<?php echo WEB; ?>';
		        	}
		        }
		    })
        }
	});

	$("#btnlogin").live("click", function() {	
		username = $("#username").val();
		password = $("#password").val();
	    $.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/login.php",
            data: "username=" + username + "&password=" + password,
            type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	        	if (data == 0) { 
	        		$('#errortd').html('<span class="redtext mediumtext2 bold">Access denied</span>'); 
	        		$('.lowerlogin').effect('shake', {times: 3, distance: 10}, 500); 
	        	}
	        	else { 
	        		window.location.href='<?php echo WEB; ?>';
	        	}
	        }
	    })
	});

	$("#resroom").change(function() {	
		if ($(this).val() != '') {
			$('#quick_jump').attr('action', $(this).val());
			$('#quick_jump').submit();
		}
	});

	$(".room_sel").change(function() {	
		roomid = $(".room_sel option:selected").val();
		$("#reserve_roomid").val(roomid);
	});

    function runCal() {
        $('#rcalendar').fullCalendar('render');
    }

    function ajaxEvents() {

        $('#rcalendar').fullCalendar('refetchEvents');
        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/reservetable.php<?php 
                if ($_GET['roomid']) echo "?roomid=".$_GET['roomid'];
                elseif ($_GET['page']) echo "?page=".$_GET['page'];
                elseif ($_GET['roomid'] && $_GET['page']) echo "?roomid=".$_GET['roomid']."&page=".$_GET['page'];
                else echo "";  
            ?>",
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#rcaltable").html(data);
            }
        })
        
    }

    function ajaxEvents2() {

        $('#rcalendar').fullCalendar('refetchEvents');
        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/reservetable2.php<?php 
                if ($_GET['roomid']) echo "?roomid=".$_GET['roomid'];
                elseif ($_GET['page']) echo "?page=".$_GET['page'];
                elseif ($_GET['roomid'] && $_GET['page']) echo "?roomid=".$_GET['roomid']."&page=".$_GET['page'];
                else echo "";  
            ?>",
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#rcaltable2").html(data);
            }
        })
        
    }

});