<?php echo $html->link(__('view_calendar', true), '/calendar', array('class'=>'button')); ?>
	<div id="calendarbox">
	</div>
<script type="text/javascript" charset="utf-8">
  $('#calendarbox').load("<?php echo $html->url(array(
	        'controller' => 'calendar', 
	        'action' => 'table',
	        'type' => 'mini',
	        'year' => date('Y'),
	        'month' => date('m'))); ?>",null,
	        function() {
	          $.getJSON("<?php echo $html->url(array(
                  	        'controller' => 'speeches', 
                  	        'action' => 'index_json',
                  	        'year' => date('Y'),
                  	        'month' => date('m'))); ?>", 
               function (data) {
                 $.each(data, function(i,e) {
                   s = e.Speech;
                   day = parseInt(s.date.substring(8,10));
                   $('#day'+day+ ' .daynumber').css('color', 'green');


                 });
               });
	        });
</script>