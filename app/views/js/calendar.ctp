function runFilter() {
  var tag = $('input[name="data[tag]"]:checked').attr('value');
  var location = $('input[name="data[location]"]:checked').attr('value');
  
  if (tag == "") {
    $('.item').show();
  } else {
    $('.item').hide();
    $('.tag'+tag).show();
  }
  
  if (location != "") {
    $('.item:visible').each(function(i,item) {
      var item_location = $(item).find('span.location').html();
      if (item_location != location) {
        $(item).hide();
      }
    });
  }
}

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
                     tags += ' tag'+t.id;
                   });

                   day = parseInt(s.date.substring(8,10));
                   $('#day'+day).append("<span class=\""+tags+"\"><a href=\""+s.url+"\">"+"-"+s.title+
                                        "</a><span class=\"location\">"+s.location+"</span></span><br />");


                 });

                 $('#calendar').show();
                 $('#loading').hide();
               });
	        });
	        

  $('input[type="radio"]').click(runFilter);
	
	$('input.tag').each(function(i,cb) {
	  $(cb).click(function() {
	    if ($(this).is(":checked")) {
        $('.'+this.name).show("fast");
      } else {
        $('.'+this.name).hide("fast");
      }
	  });
	});
}
