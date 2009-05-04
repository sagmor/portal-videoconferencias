function loadCalendar(year,month) {
	$('#calendar').hide();
	$('#loading').show();
	
	
}

$(document).ready(function() {
	var d = new Date();
	loadCalendar(d.getFullYear(), d.getMonth());
});