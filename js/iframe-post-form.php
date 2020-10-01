<?php include("../config.php"); ?>
// JavaScript Document

$(function ()
{
    var pagenum = $('#pagenum').val();
    
    /* RESERVATION */
    
    $('#reserve form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var radd_msg;  
			
			if (!$('.radd_msg').length)
			{
				$('#ltitle').after('<div class="radd_msg" style="display:none; padding:10px; text-align:center" />');
			}
            
            $('.radd_msg')
            .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Room processing&hellip;')
            .css({
                color : '#006100',
                background : '#c6efce',
                border : '2px solid #006100',
                height : 'auto'
            })
            .slideDown();                    
            
		},
		complete : function (response)
		{
			var style,
				width,
				html = '';
			
			
			if (!response.success)
			{
				$('.radd_msg').slideUp(function ()
				{
					$(this)
						.html(response.error)
						.css({
							color : '#9c0006',
							background : '#ffc7ce',
							borderColor : '#9c0006',
                            height : 'auto'
						})
						.slideDown();
				});
			}
			
			else
			{
				
				$('.radd_msg').slideUp();
                alert('Room has been successfully reserved.');
                window.location.href='<?php echo WEB; ?>';
                
			}
		}
	});

    /* FORGOT PASSWORD */

    $('#forgot form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var forgot_msg;
			
			if (!$('.forgot_msg').length)
			{
				$('#forgot_title').after('<div class="forgot_msg" style="display:none; margin-top:10px; padding:10px; text-align:center" />');
			}
            
            if ($('#empidnum').val().length)
            {
                $('.forgot_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.forgot_msg')
                    .html('Employee ID is required.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420); 
                
                return false;
            }           
			
		},
		complete : function (response)
		{
			var style,
				width,
				html = '';
			
			
			if (!response.success)
			{
				$('.forgot_msg').slideUp(function ()
				{
					$(this)
						.html(response.error)
						.css({
							'color' : '#9c0006',
							'background' : '#ffc7ce',
							'borderColor' : '#9c0006',
                            'margin-top' : '10px',
                            'height' : 'auto'
						})
						.slideDown();
				});
			}
			
			else
			{
				html += '<p>Your password has been successfully reset and sent you your email.</p>';				
				
				$('.forgot_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							'color' : '#006100',
							'background' : '#c6efce',
							'borderColor' : '#006100',
                            'margin-top' : '10px',
                            'height' : 'auto'
						})
						.slideDown();
				});
			}
		}
	});

    /* CHANGE PASSWORD */

    $('#fpass form').iframePostForm
	({
		json : true,
		post : function ()
		{
			var fpass_msg;
			
			if (!$('.fpass_msg').length)
			{
				$('#fpass_title').after('<div class="fpass_msg" style="display:none; padding:10px; margin-top:10px; margin-bottom:10px; text-align:center" />');
			}
            
            if ($('#opassword').val().length && $('#npassword').val().length && $('#cpassword').val().length)
            {
                $('.fpass_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.fpass_msg')
                    .html('All fields are required.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420); 
                
                return false;
            }           
			
		},
		complete : function (response)
		{
			var style,
				width,
				html = '';
			
			
			if (!response.success)
			{
				$('.fpass_msg').slideUp(function ()
				{
					$(this)
						.html(response.error)
						.css({
							'color' : '#9c0006',
							'background' : '#ffc7ce',
							'borderColor' : '#9c0006',
                            'margin-top' : '10px',
                            'height' : 'auto'
						})
						.slideDown();
				});
			}
			
			else
			{
				html += '<p>Your password has been successfully changed.</p>';				
                                             
                alert('Your password has been successfully changed.');
                
                
                window.location.href='<?php echo WEB; ?>';                    
				
				/*$('.fpass_msg').slideUp(function ()
				{
					$(this)
						.html(html)
						.css({
							'color' : '#006100',
							'background' : '#c6efce',
							'borderColor' : '#006100',
                            'margin-top' : '10px',
                            'height' : 'auto'
						})
						.slideDown();
				});*/
			}
		}
	});

/*                                   *
 * - Add-ons Performance Appraisal - *
 *                                   */

     /* PERFORMANCE APPRAISAL  */

    /* ^evaluate */
    $('#pafevaluate form').iframePostForm
    ({
        json : true,
        post : function ()
        {
            var paf_msg;
            
            $('.paf_msg').html('');
            
            if (!$('.paf_msg').length)
            {
                $('#alert').after('<div class="paf_msg" style="display:none; padding:3px; margin-top:5px; text-align:center" />');
            }
            
            //var btn = $(this).find("input[type=submit]:focus" );
            //var btn = $("input[type=submit][clicked=true]").val();

            
            if ($('.boxRem').val().length)
            {
                $('.paf_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.paf_msg')
                    .html('Competency Assessment Form must be filled in, kindly contact the hr if the form is unavailable.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420); 
                
                return false;
            }   

            if ($('.boxPom').val().length)
            {
                $('.paf_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.paf_msg')
                    .html('Generated Score from HR must be available, kindly contact the hr if the Conduct and Attendance Score is unavailable.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420); 
                
                return false;
            } 
            
        },
        complete : function (response)
        {
            var style,
                width,
                html = '';
            
            
            if (!response.success)
            {
                $('.paf_msg').slideUp(function ()
                {
                    $(this)
                        .html(response.error)
                        .css({
                            'color' : '#9c0006',
                            'background' : '#ffc7ce',
                            'borderColor' : '#9c0006',
                            'margin-top' : '10px',
                            'height' : 'auto'
                        })
                        .slideDown();
                });
            }
            else
            {
                
                if (response.type == 1) {

                    html += '<p>Appraisal rating is successfully initiated.</p>';              
                
                    $('.paf_msg').slideUp(function ()
                    {
                        $(this)
                            .html(html)
                            .css({
                                'color' : '#006100',
                                'background' : '#c6efce',
                                'borderColor' : '#006100',
                                'height' : 'auto'
                            })
                            .slideDown();
                    });

                    $('.subapp').attr('disabled',true);
                    $('.subapp').html('Submitted');
                    $('.subapp').hide('slow');
                    $('#saveapp').hide('slow');
                    $('#viewapp').show('fast');

                }
                else if (response.type == 2) {

                    html += '<p>Appraisal rating is successfully saved.</p>';              
                
                    $('.paf_msg').slideUp(function ()
                    {
                        $(this)
                            .html(html)
                            .css({
                                'color' : '#006100',
                                'background' : '#c6efce',
                                'borderColor' : '#006100',
                                'height' : 'auto'
                            })
                            .slideDown();
                    });

                    $('#saveapp').hide('slow');
                    $('.subapp').hide('slow');
                    $('.relapp').show('fast');
                    $('#saveapp').attr('disabled',true);
                    $('#saveapp').html('Saved');

                }
            }
        }
    });

    /* ^global evaluate */
    $('#pafevaluateglobal form').iframePostForm
    ({
        json : true,
        post : function ()
        {
            var paf_msg;
            
            $('.paf_msg').html('');
            
            if (!$('.paf_msg').length)
            {
                $('#alert').after('<div class="paf_msg" style="display:none; padding:3px; margin-top:5px; text-align:center" />');
            }
            
            //var btn = $(this).find("input[type=submit]:focus" );
            //var btn = $("input[type=submit][clicked=true]").val();

            
            if ($('#globalpart3').val().length)
            {
                $('.paf_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.paf_msg')
                    .html('Work Results Form must be filled in, kindly contact the hr if the form is unavailable.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420); 
                
                return false;
            }  

            
            if ($('#globalpart4').val().length)
            {
                $('.paf_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.paf_msg')
                    .html('Personal Core Competencies Form must be filled in, kindly contact the hr if the form is unavailable.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420); 
                
                return false;
            }   
            
            if ($('#globalhr').val().length)
            {
                $('.paf_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.paf_msg')
                    .html('Generated Score from HR must be available, kindly contact the hr if the Conduct and Attendance Score is unavailable.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420); 
                
                return false;
            } 
            
        },
        complete : function (response)
        {
            var style,
                width,
                html = '';
            
            
            if (!response.success)
            {
                $('.paf_msg').slideUp(function ()
                {
                    $(this)
                        .html(response.error)
                        .css({
                            'color' : '#9c0006',
                            'background' : '#ffc7ce',
                            'borderColor' : '#9c0006',
                            'margin-top' : '10px',
                            'height' : 'auto'
                        })
                        .slideDown();
                });
            }
            else
            {
                
                if (response.type == 1) {

                    html += '<p>Appraisal rating is successfully initiated.</p>';              
                
                    $('.paf_msg').slideUp(function ()
                    {
                        $(this)
                            .html(html)
                            .css({
                                'color' : '#006100',
                                'background' : '#c6efce',
                                'borderColor' : '#006100',
                                'height' : 'auto'
                            })
                            .slideDown();
                    });

                    $('.subapp').attr('disabled',true);
                    $('.subapp').html('Submitted');
                    $('.subapp').hide('slow');
                    $('#saveapp').hide('slow');
                    $('#viewapp').show('fast');

                }
                else if (response.type == 2) {

                    html += '<p>Appraisal rating is successfully saved.</p>';              
                
                    $('.paf_msg').slideUp(function ()
                    {
                        $(this)
                            .html(html)
                            .css({
                                'color' : '#006100',
                                'background' : '#c6efce',
                                'borderColor' : '#006100',
                                'height' : 'auto'
                            })
                            .slideDown();
                    });

                    $('#saveapp').hide('slow');
                    $('.subapp').hide('slow');
                    $('.relapp').show('fast');
                    $('#saveapp').attr('disabled',true);
                    $('#saveapp').html('Saved');

                }
            }
        }
    });

    /* ^pafupdater */
    $('#paf .formx').iframePostForm
    ({
        json : true,
        post : function ()
        {
            var pafup_msg;
            
            if (!$('.pafup_msg').length)
            {
                $('#alert').after('<div class="pafup_msg" style="display:none; padding:3px; margin-top:5px; margin-bottom:5px; text-align:center" />');
            }
            
            if ($('.remarks').val().length)
            {
                $('.pafup_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.pafup_msg')
                    .html('Your comment must not be empty.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420); 
                
                return false;
            }           
            
        },
        complete : function (response)
        {
            var style,
                width,
                html = '';
            
            
            if (!response.success)
            {
                $('.pafup_msg').slideUp(function ()
                {
                    $(this)
                        .html(response.error)
                        .css({
                            'color' : '#9c0006',
                            'background' : '#ffc7ce',
                            'borderColor' : '#9c0006',
                            'margin-top' : '10px',
                            'height' : 'auto'
                        })
                        .slideDown();
                });
            }
            
            else
            {
                html += '<p>You successfully sent your comment and approved the rating result.</p>';              
                
                $('.pafup_msg').slideUp(function ()
                {
                    $(this)
                        .html(html)
                        .css({
                            'color' : '#006100',
                            'background' : '#c6efce',
                            'borderColor' : '#006100',
                            'height' : 'auto'
                        })
                        .slideDown();
                });

                //$('.approveapp').attr('disabled',true);
                //$('.approveapp').val('Submitted');
                //$('.subapp').hide('slow');
                //$('#saveapp').hide('slow');
                $('#approveapp').hide('slow');
                $('#viewapp').show('fast');

                $('#pow1').slideUp(function ()
                {
                    $(this)
                        .html(html)
                        .slideDown();
                });

            }
        }
    });

    /* ^uploader */
    $('#paf .formg').iframePostForm
    ({
        json : true,
        post : function ()
        {
            var pafup_msg;
            
            if (!$('.pafup_msg').length)
            {
                $('#alert').after('<div class="pafup_msg" style="display:none; padding:2px; margin-top:3px; text-align:center" />');
            }
            
            if ($('.remarks').val().length)
            {
                $('.pafup_msg')
                .html('<i class="fa fa-refresh fa-spin fa-lg"></i> Processing&hellip;')
                .css({
                    color : '#006100',
                    background : '#c6efce',
                    border : '2px solid #006100',
                    height : 'auto'
                })
                .slideDown();
            }
            else
            {
                $('.pafup_msg')
                    .html('Comment must not be empty.')
                    .css({
                        color : '#9c0006',
                        background : '#ffc7ce',
                        border : '2px solid #9c0006',
                        height : 'auto'
                    })
                    .slideDown()
                    .effect('shake', {times: 3, distance: 5}, 420); 
                
                return false;
            }           
            
        },
        complete : function (response)
        {
            var style,
                width,
                html = '';
            
            
            if (!response.success)
            {
                $('.pafup_msg').slideUp(function ()
                {
                    $(this)
                        .html(response.error)
                        .css({
                            'color' : '#9c0006',
                            'background' : '#ffc7ce',
                            'borderColor' : '#9c0006',
                            'margin-top' : '10px',
                            'height' : 'auto'
                        })
                        .slideDown();
                });
            }
            
            else
            {
                html += '<p>You successfully sent your comment and accept the appraisal rating result.</p>';              
                
                $('.pafup_msg').slideUp(function ()
                {
                    $(this)
                        .html(html)
                        .css({
                            'color' : '#006100',
                            'background' : '#c6efce',
                            'borderColor' : '#006100',
                            'height' : 'auto'
                        })
                        .slideDown();
                });

                $('#pow1').slideUp(function ()
                {
                    $(this)
                        .html(html)
                        .slideDown();
                });
            }
        }
    });
    /* end of pafupdater */
});

