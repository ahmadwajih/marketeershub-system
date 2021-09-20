$(document).ready(function(){
  $("#promoted").on('change', function(){

    $('.promoted-container').removeClass("d-none");
    $('.promoted-container').toggle("slow");

  });
});
