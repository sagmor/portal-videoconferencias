function loadCalendar(year,month) {
	$('#calendar').hide();
	$('#loading').show();
	
	$('#calendar').load("<?php echo $html->url(array(
	        'controller' => 'calendar', 
	        'action' => 'table')); ?>"+'/big/'+year+'/'+month);
	$('#calendar').show();
  $('#loading').hide();
}

