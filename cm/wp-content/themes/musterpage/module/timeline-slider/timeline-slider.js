jQuery(document).ready(function($) {
	"use strict";
	var timelines = $('#res-timeline-slider');
	var timelinestext = $('.timelineContent');
	// Handle Css and Design from dots, icons, and bars.
	if(timelines.length < 1){ return; }
	
		timelines.each(function(){
			var timeline = $(this),
				timelineWrapper = timeline.find('.timeline-horizontal'),
				itemWrapper = timelineWrapper.children('.timeline-item');
			if(!itemWrapper.first().hasClass('is_lower_selected is_selected')){
				itemWrapper.first().addClass('is_lower_selected is_selected');
			}
			
			itemWrapper.on('click', function(event){
				event.preventDefault();
				itemWrapper.prev().removeClass('is_selected ');
				$(this).addClass('is_lower_selected is_selected');
				$(this).nextAll().removeClass('is_lower_selected is_selected');
			});			
		});
			
		timelinestext.each(function(){
			var timelinetext = $(this),
				textContent = timelinetext.find('.timeline-text'),
				dataIndex = 0;
			
			textContent.css('display','none');
			textContent.first().css('display','block');
			
			$('.timeline-item').on('click',function(event){
				event.preventDefault();	
				dataIndex = parseInt($(this).attr('data-index'));
					$('.timeline-text').each(function(){
					if(parseInt($(this).attr('data-index')) === dataIndex){
						$(this).fadeIn(1000);
					} else {
						$(this).css('display','none');
					}
				}); 
				
			});
			
		});

});