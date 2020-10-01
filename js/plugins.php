<?php include("../config.php"); ?>
// JavaScript Document

<?php 
    
    $dtomorrow = date("Y-m-d", strtotime("+1 day"));
    $dtomorrow2 = date("Y-m-d", strtotime("+2 day"));
    $dtomorrow3 = date("Y-m-d", strtotime("+3 day"));
    $holisun = $main->getholisun(strtotime($dtomorrow)); 
    $holisun2 = $main->getholisun(strtotime($dtomorrow2)); 
    $holisun3 = $main->getholisun(strtotime($dtomorrow3)); 

?>

function ajaxEvents() {
        
    var page = <?= $_GET['page'] ? $_GET['page'] : 1; ?>;
    var roomid = <?= $_GET['roomid'] ? $_GET['roomid'] : 0; ?>;

    if (page) { varval = "?page=" + page; }
    else if (roomid) { varval = "?roomid=" + roomid; }
    else if (roomid && page) { varval = "?roomid=" + roomid + "&page=" + page; }
    else { varval = ""; }

    $.ajax(
    {
        url: "<?php echo WEB; ?>/lib/requests/reservetable.php" + varval,
        type: "POST",
        complete: function(){
            $("#loading").hide();
        },
        success: function(data) {
            $("#rcaltable").html(data);
            $('#rcalendar').fullCalendar('refetchEvents');
        }
    })

}

function ajaxEvents2() {

    var page = <?= $_GET['page'] ? $_GET['page'] : 1; ?>;
    var roomid = <?= $_GET['roomid'] ? $_GET['roomid'] : 0; ?>;

    if (page) { varval = "?page=" + page; }
    else if (roomid) { varval = "?roomid=" + roomid; }
    else if (roomid && page) { varval = "?roomid=" + roomid + "&page=" + page; }
    else { varval = ""; }

    $.ajax(
    {
        url: "<?php echo WEB; ?>/lib/requests/reservetable2.php" + varval,
        type: "POST",
        complete: function(){
            $("#loading").hide();
        },
        success: function(data) {
            $("#rcaltable2").html(data);
            $('#rcalendar').fullCalendar('refetchEvents');
        }
    })

}
    
$(function() {	


	/* MAIN NAVIGATION */
	
	$("#nav1").on("click", function(){ parent.location='http://portal.megaworldcorp.com/papyrus.php'; return false; });
	$("#nav2").on("click", function(){ parent.location='http://portal.megaworldcorp.com/ihelp/'; return false; });
	$("#nav3").on("click", function(){ parent.location='http://portal.megaworldcorp.com/hr/'; return false; });
	$("#nav4").on("click", function(){ parent.location='http://portal.megaworldcorp.com/availability/'; return false; });
	$("#nav5").on("click", function(){ parent.location='http://portal.megaworldcorp.com/#'; return false; });

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

	$(".openEvCreate").on("click", function() {	
		$("#floatDiv").removeClass("invisible");
		$(".radd").removeClass("invisible");		
		$(".rdel").addClass("invisible");	
		$(".redit").addClass("invisible");	
		$(".rcal").addClass("invisible");
		$(".rpost").addClass("invisible");	
		$(".rcon").addClass("invisible");
        $(".radd_msg").remove();

	    return false;
	});

    $(".openEvCreate").one("click", function() {	

        $('.roompic').resizecrop({
            width: 150,
            height: 110,
            vertical: "top"
        }); 

	    return false;
	});

	$(".closebutton").on("click", function() {	
		ajaxEvents();
        ajaxEvents2();		
		$("#floatDiv").addClass("invisible");
		$("#radd").addClass("invisible");	
		$("#rcal").addClass("invisible");
		$("#redit").addClass("invisible");
		$("#rdel").addClass("invisible");
		$("#rpost").addClass("invisible");
		$(".rcon").addClass("invisible");
	});

    
    // CALENDAR BEGIN
    
	$(".openEvDetail").on("click", function() {	
		$("#floatDiv").removeClass("invisible");	
		$(".radd").addClass("invisible");	
		$(".rdel").addClass("invisible");	
		$(".redit").addClass("invisible");	
		$(".rcal").removeClass("invisible");
		$(".rpost").addClass("invisible");	
		$(".rcon").addClass("invisible");
		$(".rapp").addClass("invisible");
		$(".raapp").addClass("invisible"); 
		$(".rrej").addClass("invisible");    
	    $(".rcalinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');

		eventid = $(this).attr('attribute');
		eventcolor = $(this).attr('attribute2');
        dark = $(this).attr('attribute3');
		del = 0;		
        
		$(".rcal").css("background-color", eventcolor);

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/eventdetail.php",
	        data: "resid=" + eventid + "&dark=" + dark,
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

	$(".editEvDetail").on("click", function() {	
		$("#floatDiv").removeClass("invisible");
		$(".radd").addClass("invisible");			
		$(".rcal").addClass("invisible");		
		$(".redit").removeClass("invisible");
		$(".rdel").addClass("invisible");
		$(".rpost").addClass("invisible");
		$(".rcon").addClass("invisible");
		$(".rapp").addClass("invisible");
		$(".raapp").addClass("invisible");  
		$(".rrej").addClass("invisible");   
	    $(".reditinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');	

		eventid = $(this).attr('attribute');
		eventcolor = $(this).attr('attribute2');
        dark = $(this).attr('attribute3');
		edit = 1;

		$("#editEvId").val(eventid);		
        
		$(".redit").css("background-color", eventcolor);

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/eventdetail.php",
	        data: "resid=" + eventid + "&edit=" + edit + "&dark=" + dark,
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

	$(".editEvApp").on("click", function() {	
		$("#floatDiv").removeClass("invisible");
		$(".radd").addClass("invisible");			
		$(".rcal").addClass("invisible");		
		$(".redit").removeClass("invisible");
		$(".rdel").addClass("invisible");
		$(".rpost").addClass("invisible");
		$(".rcon").addClass("invisible");
		$(".rapp").addClass("invisible");
		$(".raapp").addClass("invisible");  
		$(".rrej").addClass("invisible");   
	    $(".reditinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');	

		eventid = $(this).attr('attribute');
		eventcolor = $(this).attr('attribute2');
        dark = $(this).attr('attribute3');
		edit = 1;

		$("#editEvId").val(eventid);	
		$(".redit").css("background-color", eventcolor);

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/eventapp.php",
	        data: "resid=" + eventid + "&edit=" + edit + "&dark=" + dark,
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

	$(".delEvDetail").on("click", function() {
		$("#floatDiv").removeClass("invisible");
		$(".radd").addClass("invisible");				
		$(".rcal").addClass("invisible");
		$(".redit").addClass("invisible");		
		$(".rdel").removeClass("invisible");
		$(".rpost").addClass("invisible");	
		$(".rcon").addClass("invisible");
		$(".rapp").addClass("invisible");
		$(".raapp").addClass("invisible");
		$(".rrej").addClass("invisible");     
	    $(".rdelinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');

		eventid = $(this).attr('attribute');
		eventcolor = $(this).attr('attribute2');
        dark = $(this).attr('attribute3');
		del = 1;

		$("#delEvId").val(eventid);	
		$(".rdel").css("background-color", eventcolor);

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/eventdetail.php",
	        data: "resid=" + eventid + "&delete=" + del + "&dark=" + dark,
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

	$("#editEvent").on('click', function() {	
		$("#floatDiv").removeClass("invisible");
		$(".radd").addClass("invisible");			
		$(".redit").addClass("invisible");	
		$(".rcon").removeClass("invisible");
		$(".rapp").addClass("invisible");
		$(".raapp").addClass("invisible"); 
		$(".rrej").addClass("invisible");          	
        $(".rconinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');

        //alert($(".reserve_roomid option:selected").val());
        
		eventid = $("#editEvId").val();		
        floor = $(".reserve_roomid option:selected").attr('attribute');	
		room = $(".reserve_roomid option:selected").val();	
		eventname = $("#reserve_eventname").val();
		datein = $("#reserve_datein").val();	
		timein = $("#reserve_timein").val();			
		timeout = $("#reserve_timeout").val();	
		person = $("#reserve_person option:selected").val();	
		notes = $("#reserve_notes").val();
		reason = $("#reserve_reason").val();
		fullname = $("#user_fullname").val();		
		email = $("#user_email").val();	
        ruser = $("#reserve_user").val();		

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/eventedit.php",
	        data: "reserve_id=" + eventid + "&reserve_floorid=" + floor + "&reserve_roomid=" + room + "&reserve_eventname=" + eventname + "&reserve_datein=" + datein + "&reserve_timein=" + timein + "&reserve_timeout=" + timeout + "&reserve_person=" + person + "&reserve_notes=" + notes + "&reserve_reason=" + reason + "&user_fullname=" + fullname + "&user_email=" + email,
	        type: "POST",
	        success: function(data) {
	            $(".rconinfo").html(data);
	        }
	    })

	    return false;
	});

	$("#delEvent").unbind('click').click(function() {

		eventid = $("#delEvId").val();		
		reason = $("#reserve_reason").val();
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
                if (data == 1) {
                    alert('Cancel Valid Reason is required.');
                }
                else {
                    $("#floatDiv").addClass("invisible");			
		            $(".rdel").addClass("invisible");	
	                ajaxEvents();
                    ajaxEvents2();
                }
	        }
	    })

	    return false;
	});

	$(".appEvDetail").on("click", function() {
		$("#floatDiv").removeClass("invisible");
		$(".radd").addClass("invisible");				
		$(".rcal").addClass("invisible");
		$(".redit").addClass("invisible");		
		$(".rdel").addClass("invisible");
		$(".rpost").addClass("invisible");	
		$(".rcon").addClass("invisible");
		$(".rapp").removeClass("invisible");
		$(".raapp").addClass("invisible");
		$(".rrej").addClass("invisible");           
	    $(".rappinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');

		eventid = $(this).attr('attribute');
		eventcolor = $(this).attr('attribute2');
        dark = $(this).attr('attribute3');
		app = 1;

		$("#appEvId").val(eventid);	
		$(".rapp").css("background-color", eventcolor);

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/eventdetail.php",
	        data: "resid=" + eventid + "&app=" + app + "&dark=" + dark,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            $(".rappinfo").html(data);
	        }
	    })

	    return false;
	});

	$("#appEvent").unbind('click').click(function() {

		eventid = $("#appEvId").val();		
		remark = $("#reserve_reason").val();	
		fullname = $("#user_fullname").val();		
		email = $("#user_email").val();		

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/eventapprove.php",
	        data: "resid=" + eventid + "&reserve_remark=" + remark + "&user_fullname=" + fullname + "&user_email=" + email,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
                if (data) {
                    alert(data);
                } else {
                    $("#floatDiv").addClass("invisible");			
                    $(".rapp").addClass("invisible");	
                    ajaxEvents();
                    ajaxEvents2();
                }
	        }
	    })

	    return false;
	});

	$(".aappEvDetail").on("click", function() {
		$("#floatDiv").removeClass("invisible");
		$(".radd").addClass("invisible");				
		$(".rcal").addClass("invisible");
		$(".redit").addClass("invisible");		
		$(".rdel").addClass("invisible");
		$(".rpost").addClass("invisible");	
		$(".rcon").addClass("invisible");
		$(".rapp").addClass("invisible");
		$(".raapp").removeClass("invisible");  
		$(".rrej").addClass("invisible");        
	    $(".raappinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');

		eventid = $(this).attr('attribute');
		eventcolor = $(this).attr('attribute2');
        dark = $(this).attr('attribute3');
		aapp = 1;

		$("#aappEvId").val(eventid);		        
		$(".raapp").css("background-color", eventcolor);

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/eventdetail.php",
	        data: "resid=" + eventid + "&aapp=" + aapp + "&dark=" + dark,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            $(".raappinfo").html(data);
	        }
	    })

	    return false;
	});

	$("#aappEvent").unbind('click').click(function() {

		eventid = $("#aappEvId").val();		
        roomid = $("#reserve_roomid option:selected").val();		
		remark = $("#reserve_reason").val();	
		fullname = $("#user_fullname").val();		
		email = $("#user_email").val();		

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/eventapprove.php",
	        data: "resid=" + eventid + "&roomid=" + roomid + "&reserve_remark=" + remark + "&user_fullname=" + fullname + "&user_email=" + email + "&admin=1",
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
                if (data) {
                    alert(data);
                } else {
                    $("#floatDiv").addClass("invisible");			
                    $(".raapp").addClass("invisible");	
                    ajaxEvents();
                    ajaxEvents2();
                }
	        }
	    })

	    return false;
	});

	$(".rejEvDetail").on("click", function() {
		$("#floatDiv").removeClass("invisible");
		$(".radd").addClass("invisible");				
		$(".rcal").addClass("invisible");
		$(".redit").addClass("invisible");		
		$(".rdel").addClass("invisible");
		$(".rpost").addClass("invisible");	
		$(".rcon").addClass("invisible");
		$(".rapp").addClass("invisible");
		$(".raapp").addClass("invisible");
		$(".rrej").removeClass("invisible");           
	    $(".rrejinfo").html('<i class="fa fa-refresh fa-spin"></i> loading...');

		eventid = $(this).attr('attribute');
		eventcolor = $(this).attr('attribute2');
        dark = $(this).attr('attribute3');
        admin = $(this).attr('attribute4');
		rej = 1;

		$("#rejEvId").val(eventid);		
		$(".rrej").css("background-color", eventcolor);

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/eventdetail.php",
	        data: "resid=" + eventid + "&rej=" + rej + "&dark=" + dark + "&admin=" + admin,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            $(".rrejinfo").html(data);
	        }
	    })

	    return false;
	});

	$("#rejEvent").unbind('click').click(function() {

		eventid = $("#rejEvId").val();		
		remark = $("#reserve_reason").val();	
		fullname = $("#user_fullname").val();		
		email = $("#user_email").val();		
        admin = $("#admin").val();		

		$.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/eventapprove.php",
	        data: "resid=" + eventid + "&reserve_remark=" + remark + "&user_fullname=" + fullname + "&user_email=" + email + "&reject=1" + "&admin=" + admin,
	        type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
                if (data) {
                    alert(data);
                } else {
                    $("#floatDiv").addClass("invisible");			
                    $(".rrej").addClass("invisible");	
                    ajaxEvents();
                    ajaxEvents2();
                }
	        }
	    })

	    return false;
	});
    
    
    //CALENDAR END
    
    // rooms
    
    $("#room_locid").change("click", function() {		
        
        locid = $("#room_locid option:selected").val();
	    $.ajax(
	    {
	        url: "<?php echo WEB; ?>/lib/requests/roomsel.php?sec=floor2",
            data: "locid=" + locid,
            type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            $("#room_floorid").html(data);
	        }
	    })
	});
    

	$(".delRoom").on("click", function() {		

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

	$(".delUser").on("click", function() {		

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

	$(".delLoc").on("click", function() {		

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

    $(".approveRoom").on("click", function() {		

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

	$(".approveUser").on("click", function() {		

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

	$(".postEvDetail").on("click", function() {		
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

	$("#postEvent").on("click", function() {		
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
    
    // floors
    
    $(".txtaddfloor").on("keypress", function(e) {
        if (e.keyCode == 13) {
            var floorname = $(this).val();
            var locid = $("#loc_id").val();
            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/floor.php?sec=add",
                data: "floorname=" + floorname + "&locid=" + locid,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/floor.php",
                        data: "locid=" + locid,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            $(".floordiv").html(data);
                        }   
                    })
                }
            })
            return false;
        }
    });

    $(".btneditfloor").on("click", function() {		
        var floorid = $(this).attr("attribute");	

        $(".floortxt").removeClass('invisible');
        $(".floortxt" + floorid).addClass('invisible');
        $(".txteditfloor").addClass('invisible');
        $(".txteditfloor" + floorid).removeClass('invisible');   
        $(".editfloortxt").addClass('invisible');               
        $(".editfloortxt" + floorid).removeClass('invisible');        

        return false;
    });

    $(".txteditfloor").blur(function() {		
        var floorid = $(this).attr("attribute");		

        $(".floortxt").removeClass('invisible');
        $(".txteditfloor").addClass('invisible');
        $(".txteditfloor" + floorid).addClass('invisible');       
        $(".editfloortxt").addClass('invisible');          

        return false;
    });

    $(".txteditfloor").on("keypress", function(e) {
        if (e.keyCode == 13) {
            var floorid = $(this).attr("attribute");
            var floorname = $(this).val();
            var locid = $("#loc_id").val();
            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/floor.php?sec=edit",
                data: "floorid=" + floorid + "&floorname=" + floorname,
                type: "POST",
                complete: function(){
                    $("#loading").hide();
                },
                success: function(data) {
                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/floor.php",
                        data: "locid=" + locid,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            $(".floordiv").html(data);
                        }   
                    })
                }
            })
            return false;
        }
    });

    $(".btndelfloor").on("click", function() {		

        var r = confirm("Are you sure you want to delete this floor?");
        floorid = $(this).attr("attribute");
        locid = $("#loc_id").val();

        if (r == true)
        {
            $.ajax(
            {
                url: "<?php echo WEB; ?>/lib/requests/floor.php?sec=delete",
                data: "floorid=" + floorid,
                type: "POST",
                success: function(data) {                        
                    $.ajax(
                    {
                        url: "<?php echo WEB; ?>/lib/requests/floor.php",
                        data: "locid=" + locid,
                        type: "POST",
                        complete: function(){
                            $("#loading").hide();
                        },
                        success: function(data) {
                            $(".floordiv").html(data);
                        }   
                    })
                }
            })

            return false;
        }

        return false;
    });

    // user

    $("#user_level").change("click", function() {		

        userlevel = $(this).val();	
        
        if (userlevel == 1) {
            $("#tdapp").removeClass("invisible");
            
        } else {
            $("#tdapp").addClass("invisible");
            $("#user_approver").val(0);
        }

        return false;
    });
    
    $("#user_dept").change("click", function() {		

        userdept = $(this).val();	
        
        $.ajax(
        {
            url: "<?php echo WEB; ?>/lib/requests/appsel.php",
            data: "dept=" + userdept,
            type: "POST",
            complete: function(){
                $("#loading").hide();
            },
            success: function(data) {
                $("#user_approver").html(data);
            }
        })

        return false;
    });

	$(".pwordUser").on("click", function() {		

		userid = $(this).attr('attribute');
        useremail = $(this).attr('attribute2');

		var r = confirm("Are you sure you want to send the password of this user");
		if (r == true)
		{
			$.ajax(
		    {
		        url: "<?php echo WEB; ?>/lib/requests/userpassword.php",
		        data: "userid=" + userid,
		        type: "POST",
		        complete: function(){
		        	$("#loading").hide();
		    	},
		        success: function(data) {
		            alert("Password has been successfully to " + useremail);
		        }
		    })

		    return false;
		}
		
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
        maxDate: "7D",
        changeMonth: true,
        beforeShowDay: function(date) {
            var day = date.getDay();
            return [(day != 0 && day != 6), ''];
        }
    });

    /*$(".checkindate").datepicker({ 
        dateFormat: 'yy-mm-dd',
        minDate: "0D",
        <?php if($holisun) : ?>
            <?php if($holisun2) : ?>
                <?php if($holisun3) : ?>
                    maxDate: "4D",
                <?php else : ?>
                    maxDate: "3D",
                <?php endif; ?>
            <?php else : ?>
                maxDate: "2D",
            <?php endif; ?>
        <?php else : ?>
            maxDate: "1D",
        <?php endif; ?>
        changeMonth: true,
        beforeShowDay: function(date) {
            var day = date.getDay();
            return [(day != 0), ''];
        }
    });*/

    $(".expiredate").datepicker({ 
        dateFormat: 'yy-mm-dd',
        minDate: "-1D",
        maxDate: "1Y",
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
	    hourMax: 20,
        maxTime: '8:00pm'
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
	        url: "<?php echo WEB; ?>/lib/requests/roomsel.php?sec=floor",
            data: "locid=" + locid,
            type: "POST",
	        complete: function(){
	        	$("#loading").hide();
	    	},
	        success: function(data) {
	            $(".reserve_floorid").html(data);
	        }
	    })
	});

    $(".caltab1").on("click", function() {		
		
        $(".caltab1").addClass("calsel");	
		$(".caltab2").removeClass("calsel");
        $(".calview1").removeClass("nodisplay");	
		$(".calview2").addClass("nodisplay");
        runCal();

	    return false;
	});

    $(".caltab2").on("click", function() {		
		
        $(".caltab2").addClass("calsel");	
		$(".caltab1").removeClass("calsel");
        $(".calview2").removeClass("nodisplay");	
		$(".calview1").addClass("nodisplay");

	    return false;
	});

    $("#username").change(function (e) {
        $("#username").val(($("#username").val()).toUpperCase());
    });

    $("#username").bind('keyup', function (e) {
        if (e.which >= 97 && e.which <= 122) {
            var newKey = e.which - 32;
            e.keyCode = newKey;
            e.charCode = newKey;
        }
    
        $("#username").val(($("#username").val()).toUpperCase());
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

	$("#btnlogin").on("click", function() {	
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

    // report from
    $(".rep_date_from").datepicker({ 
        dateFormat: 'yy-mm-dd',
        minDate: "2014-01-01",
        maxDate: "0D",
        changeMonth: true,
        numberOfMonths: 2,
        onSelect: function (dateText, inst) {
            $('#replink1').attr('href', "<?php echo WEB; ?>/reservation_report/summary/" + $(".rep_date_from").val() + "/" + $(".rep_date_to").val());
            $('#replink2').attr('href', "<?php echo WEB; ?>/reservation_report/list/" + $(".rep_date_from").val() + "/" + $(".rep_date_to").val());
        },
        onClose: function(selectedDate) {
            $(".rep_date_to").datepicker("option", "minDate", selectedDate);
        }
    });

    // report to
    $(".rep_date_to").datepicker({ 
        dateFormat: 'yy-mm-dd',
        minDate: "2014-01-01",
        maxDate: "0D",
        changeMonth: true,
        numberOfMonths: 2,
        onSelect: function (dateText, inst) {
            $('#replink1').attr('href', "<?php echo WEB; ?>/reservation_report/summary/" + $(".rep_date_from").val() + "/" + $(".rep_date_to").val());
            $('#replink2').attr('href', "<?php echo WEB; ?>/reservation_report/list/" + $(".rep_date_from").val() + "/" + $(".rep_date_to").val());
        },
        onClose: function(selectedDate) {
            $(".rep_date_from").datepicker("option", "maxDate", selectedDate);

        }
    });

    

});