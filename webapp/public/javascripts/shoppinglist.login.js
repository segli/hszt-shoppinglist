$(document).ready(function () {
   $.ajax({
       'url' : 'test.php',
       'type' : 'post',
       'dataType' : 'json',
       'success' : function (data) {
           console.info(data);
       }

   });
});