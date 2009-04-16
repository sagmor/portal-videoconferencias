$(document).ready(function() {
  var tags = ['tag1', 'tag2', 'tag3'];

  jQuery.each(tags, function(i) {
    var tag = tags[i];
    $('#'+tag).click(function() {
      if ($(this).is(":checked")) {
        $('.'+this.id).show("fast");
      } else {
        $('.'+this.id).hide("fast");
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

});