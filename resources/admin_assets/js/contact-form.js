function uniqId() {
  return "name"+Math.round(new Date().getTime() + (Math.random() * 100));
}
$(function() {
      
    //add new block
    $('.newField').click(function(){
      var html_code = $(".fields_html").html().replace(/random/g , function() {
                              return uniqId();
                            });
       $(".fields_list").append(html_code);
       
      return false;
    }); 
    
    //Remove block
      $( ".fields_list" ).delegate( ".delete_field", "click", function(){
        $(this).parent().parent().remove();
        return false;
      });
    
});    