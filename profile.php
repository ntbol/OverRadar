<?php
	
	$username = $_GET['username'];
	$id = $_GET['id'];
    $platform = $_GET['platform'];
    $region = $_GET['region'];

?>
<!DOCTYPE html>
<html>
<head>
	<title>Test</title>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <style type="text/css">
          .fishes
    {
      position: relative;
      top: 0;
      left: 0;
    }
    .fish
    {
      position: absolute;
      top: 115px;
      left: 8px;
    }
    </style>
</head>
<body>

	<div class="mypanel" align="center"></div>

    <script>
    $.getJSON('https://ow-api.com/v1/stats/<?=$platform?>/<?=$region?>/<?=$username?>-<?=$id?>/complete', function(data) {
        
        var text = 
            `   
                <div>
                    <img src="${data.levelIcon}" class="fishes">
                    <img src="${data.prestigeIcon}" class="fish">
                </div>
                <div>
                    <h2>${data.name}</h2>
                    <h3>${data.prestige}${data.level}</h3>
                    <img src="${data.ratingIcon}">
                </div>
            
            `
                    
        
        $(".mypanel").html(text);
    });
    </script>

</body>
</html>