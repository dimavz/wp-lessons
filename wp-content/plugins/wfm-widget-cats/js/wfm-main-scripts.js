// http://www.designchemical.com/lab/jquery-vertical-accordion-menu-plugin/getting-started/
jQuery(document).ready(function($){
	// alert(111);
	$('ul.accordion').dcAccordion({
		eventType: 'click',
		disableLink: true,
		hoverDelay: 300,
		speed: 'slow'
	});
});