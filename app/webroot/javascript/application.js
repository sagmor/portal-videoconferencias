var debug;
$(document).ready(function(){
  $(function() {   
    $('.attachments li a[rel]').overlay({
      onBeforeLoad: function() {
        var div = this.getContent();
      
        if (div.text() == ''){
          var url = this.getTrigger().attr('href');
          if (url.substr(url.lastIndexOf('.') + 1) in {'jpg':'','png':'','gif':''}){
            div.text('<img src="'+url+'" />');
          } else {
            div.load(url);
          };
        };
        
        this.getBackgroundImage().expose({color: '#fff'});
      },
      onClose: function(){
        $.expose.close();
      }
    });
  });
});