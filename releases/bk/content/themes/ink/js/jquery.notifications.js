/**
 * 	Notifications
 *  =============
 *
 * 	Requires CSS styles
 *  Copyright (c) Dominic Whittle weekends.ws
 *  
 */

// @todo consider notification stacking and hideNotification() function

function notification( options ){
	
	// Default options
	var defaults = { 
		message: 			'', 	// Text/HTML content of message 
		stateClass:   		'',		// additional classl e.g., error, success, warning, welcome
		timeDisplayed: 		2000,  	// time displayed on screen before dissapearring
		selector: 			'body',  // element to which notifications are appended
		// ---
		animTime: 			300,
		defaultClass: 		'wknds-notification', // class
		defaultParentID:    'wknds-notifications' // ID
	}; 
	// combine options with default values
	var options = $.extend({}, defaults, options ); // If you're not using jQuery you need different function here
		
	// Show notification
	function newNotification(){
		
		// setup noticifactions container 
		if ( $('#wknds-notifications').length < 1 ){
			$( options.selector ).append( '<div id="' + options.defaultParentID + '"></div>' );
		}
		
		var el  = '<div class="' + options.defaultClass + '-wrapper">';
			el += 	'<div class="' + options.defaultClass + ' ' + options.stateClass + '">';
			el += 		'<div class="' + options.defaultClass + '-inner' + '">';
			el += 			options.message;
			el += 		'</div>';
			el += 	'</div>';	
			el += '</div>';	
			
		var $el = $( el );
			
		$el.css({ 
			//'bottom' : '-100px',
			//'opacity' : 0
		});
		
		$el.appendTo( '#' + options.defaultParentID )
		$el.animate({
			'height' : $el.children().height()
			//opacity: 1,
			//bottom: 0
		}, options.animTime, function(){
			// callback: run faux animation to delay
			$el.animate({ opacity: 1 }, options.timeDisplayed, function(){
				// callback: hide notification
				$el. animate({
					'height' : 0
					//'bottom': '-100px',
					//'opacity': 0
				}, options.animTime, function(){
					$el.remove();
				});
			});
		});
		
	}
	
	newNotification();

}




