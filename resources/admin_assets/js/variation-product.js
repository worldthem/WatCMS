  $(document).ready(function(){
      $(document.body).on('click keyup', ".wsugestion", function(event){ 
          var data_id= $(this).data("name");
          show_sugestion(this, data_id);
       });
 });
  
  // show the sugestion for the curent input
function show_sugestion(input, id_sugestion=""){ 
     // alert(id_sugestion);
    //var parren_element = eval(id_sugestion); 
    var obj = eval(id_sugestion);
    var filter = input.value.toUpperCase();
    var links = '' ;
    
     for (var i = 0; i < obj.length; i++) {
       // if (obj[i].toUpperCase().indexOf(filter) > -1) {
        if (obj[i].substr(0, filter.length).toUpperCase() == filter.toUpperCase()) {
            //new_array = obj[i];  
            links = links + '<a href="#">'+ obj[i] +'</a>'; 
        }
     }
     
     var parren_element = input.parentElement.querySelector(".sugestion_elements");
     parren_element.style.display = "block";
     parren_element.innerHTML = links;
      
     $(".sugestion_elements a").bind('click', function(event){
         input.value  = $(this).text();
         parren_element.style.display = "none";
         return false;
     });
      
}
 
 
 
 
 //hide all sugestion when click outside;
function hide_elements(hede_all=""){
    // Detect all clicks on the document
document.addEventListener("click", function(event) {

// If user clicks inside the element, do nothing
if (event.target.closest(".wsugestion") && hede_all == "") return;

// If user clicks outside the element, hide it!
  var allelem= document.querySelectorAll(".sugestion_elements");
   
  for(var i = 0; i<=allelem.length; i++ ){
    allelem[i].style.display = "none";
    }
 });
}
 hide_elements();
 
  // dublicate variation
 function dublicate(this_elem){
    var html=this_elem.parentElement;
    var cln = html.cloneNode(true);
    document.getElementById('variation_control').appendChild(cln);
 }
 //remove variation
 function  remove_element(this_elem){
    var result = confirm("Want to delete?");
    if (result) {
        this_elem.parentElement.remove(); 
        }
        return false;
     }
 // new variation line 
 function new_element_add(){
   var content_new = document.getElementById('new_element_is').querySelector(".inner_row").cloneNode(true);
    document.getElementById('variation_control').appendChild(content_new);
    return false;
 } 
 
  // go to first checked element in the category
 function go_to_element(){
     var divElem = document.getElementById('categories_right');
     var chElem = document.querySelectorAll(".anchor_scroll");
    if(chElem[0]){
        
          var hight_scroll = divElem.scrollHeight;
          var topPos = divElem.offsetTop;
          divElem.scrollTop =chElem[0].offsetTop - (topPos+20);
           
    }
 }
 
 go_to_element();