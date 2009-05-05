function loadCalendar(year,month) {
	$('#calendar').hide();
	$('#loading').show();
	
	$('#calendar').load("<?php echo $html->url(array(
	        'controller' => 'calendar', 
	        'action' => 'table')); ?>"+'/big/'+year+'/'+month);
  $.getJSON("<?php echo $html->url(array(
        	        'controller' => 'speeches', 
        	        'action' => 'index_json')); ?>"+'/'+year+'/'+month, 
     function (data) {
       $.each(data, function(i,e) {
         s = e.Speech;
         d = Date.parse(s.date);
         
         tags = "item";
         $.each(e.Tag, function(j, t) {
           tags += ' '+t.name;
         });
         
         day = parseInt(s.date.substring(8,10));
         $('#day'+day).append("<span class=\""+tags+"\"><a href=\""+s.url+"\">"+s.title+"</a></span>");
         
         
       });
     });
        	        
	$('#calendar').show();
  $('#loading').hide();
}
