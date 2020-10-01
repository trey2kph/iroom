<?php include("../config.php"); ?>

//JavaScript Document

$(function() {

	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	
	$('#rcalendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek'
		},    
	    defaultView: 'month',
	    dayRender: function (date, cell) {
	        var today = new Date();
	        if (date.getTime() < today.getTime() - 86400000) {
	            cell.css("background-color", "#999");
	        }
	    },
        hiddenDays: [ 0 ],
        weekMode: 'variable',
        weekNumbers: true,
        minTime: '6:00am',
        maxTime: '10:00pm',
        allDaySlot: false,
        slotMinutes: 45,
		editable: false,
        viewDisplay   : function(view) {
            var now = new Date(); 
            var end = new Date();
            now.setMonth(now.getMonth() - 1);
            end.setMonth(now.getMonth() + 3);
            
            var cal_date_string = view.start.getMonth()+'/'+view.start.getFullYear();
            var cur_date_string = now.getMonth()+'/'+now.getFullYear();
            var end_date_string = end.getMonth()+'/'+end.getFullYear();
            
            if(cal_date_string == cur_date_string) { jQuery('.fc-button-prev').addClass("fc-state-disabled"); }
            else { jQuery('.fc-button-prev').removeClass("fc-state-disabled"); }
            
            if(end_date_string == cal_date_string) { jQuery('.fc-button-next').addClass("fc-state-disabled"); }
            else { jQuery('.fc-button-next').removeClass("fc-state-disabled"); }
        },
		events: {
            url: '<?php echo WEB; ?>/js/rcaldata.php<?php echo $_GET['roomid'] ? "?roomid=".$_GET['roomid'] : "";  ?>',
            type: 'POST'
        },
        eventRender: function(event, element) {                                          
            element.find('span.fc-event-title').html(element.find('span.fc-event-title').text());					  
        },
		eventClick: function(event) {
	        if (event.id) {
	                            
		        $("#floatDiv").removeClass("invisible");	
	            $(".redit").addClass("invisible");
	            $(".rpost").addClass("invisible");
	            $(".rdel").addClass("invisible");
	        	$(".rcal").removeClass("invisible");
	        	$(".rcal").css("background-color", event.backgroundColor);

	        	$.ajax(
			    {
			        url: "<?php echo WEB; ?>/lib/requests/eventdetail.php",
		            data: "resid=" + event.id + "&dark=" + event.dark,
		            type: "POST",
			        complete: function(){
			        	$("#loading").hide();
			    	},
			        success: function(data) {
			            $(".rcalinfo").html(data);
			        }
			    })

	            return false;
	        }
	    }
		
	});	

});

function updateEvents() {

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
setInterval("updateEvents()", 30000);