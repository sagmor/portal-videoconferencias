<div id="calendarbox">
</div>

<script type="text/javascript" charset="utf-8">
  $('#calendarbox').load("<?php echo $html->url(array(
	        'controller' => 'calendar', 
	        'action' => 'table',
	        'type' => 'mini',
	        'year' => date('Y'),
	        'month' => date('m'))); ?>");
</script>