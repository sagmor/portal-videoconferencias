function loadCalendar(year,month) {
	$('#calendar').hide();
	$('#loading').show();
	
	$('#calendar').load("<?php echo $html->url(array(
	        'controller' => 'calendar', 
	        'action' => 'table')); ?>"+'/big/'+year+'/'+month,null,
	        function() {
	          $.getJSON("<?php echo $html->url(array(
                  	        'controller' => 'speeches', 
                  	        'action' => 'index_json')); ?>"+'/'+year+'/'+month, 
               function (data) {
                 $.each(data, function(i,e) {
                   s = e.Speech;

                   tags = "item";
                   $.each(e.Tag, function(j, t) {
                     tags += ' '+t.name.replace(" ", "-");
                   });

                   day = parseInt(s.date.substring(8,10));
                   $('#day'+day).append("<span class=\""+tags+"\"><a href=\""+s.url+"\">"+s.title+"</a></span><br />");


                 });

                 $('#calendar').show();
                 $('#loading').hide();
               });
	        });
	        

	
	$('input.tag').each(function(i,cb) {
	  $(cb).click(function() {
	    if ($(this).is(":checked")) {
        $('.'+this.name).show("fast");
      } else {
        $('.'+this.name).hide("fast");
      }
	  });
	});
  
  $('#filter h2').click(function() {
    if($('#filter form').is(':visible'))
    {
      $('#filter form').hide("fast");
    } else {
      $('#filter form').css('float', 'left')
      $('#filter form').css('display', 'block')
      $('#filter form').show("fast");
      
    }
  });
}
