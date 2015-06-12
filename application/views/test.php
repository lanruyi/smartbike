<!DOCTYPE html>
<html>
<head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script> 
$(document).ready(function(){
  $("button").click(function(){
    var div=$("div");
    div.animate({width:'<?= $b?>',opacity:'1'},"slow");
  });
});
</script> 
</head>
 
<body>
<style type="text/css">
    .box{width:200px}
    .frame{width:200px; height:18px; padding:5px 0px}
    .value{background:#98bf21; height:18px; width:0px; float:left}
   
</style>
<div class="box"><button>start</button></div>
<div class="box">
<div class="frame"><div id="value-a" class ="value"> </div></div>
<div class="frame"><div id="value-b" class ="value"> </div></div>
</div>
</body>
</html>
