// http://www.designchemical.com/lab/jquery-vertical-accordion-menu-plugin/getting-started/
jQuery(document).ready(function($){
	$('ul.accordion').dcAccordion({
		eventType: 'click',
		disableLink: false,
		hoverDelay: 300,
		speed: 'slow'
	});
});