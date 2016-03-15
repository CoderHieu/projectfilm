$(document).ready(function(){
	$('#myTabs a').click(function (e) {
	  	e.preventDefault()
	  	$(this).tab('show')
	})
	$('#myTabs a[href="#profile"]').tab('show')
	$('#myTabs a:first').tab('show')
	$('#myTabs a:last').tab('show')
});