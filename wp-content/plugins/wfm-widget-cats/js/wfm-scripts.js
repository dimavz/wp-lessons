// http://www.designchemical.com/lab/jquery-vertical-accordion-menu-plugin/getting-started/
jQuery(document).ready(function($){
	$('ul.accordion').dcAccordion({
		eventType: wfm_obj.eventType,
		disableLink: false,
		hoverDelay: wfm_obj.hoverDelay,
		speed: wfm_obj.speed
	});
});