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
<script>

    $.getJSON('https://ow-api.com/v1/stats/<?=$platform?>/<?=$region?>/<?=$username?>-<?=$id?>/complete', function(data) {
        
       var header = 
            `   
            <div class="row" style="padding-top:25px">
              <div class="col-lg-1">
              <img src="${data.icon}" class="round" width="100%">
              </div>
              <div class="col-lg-6">
                <h1 class="mediumtitle">${data.name}</h1>
              </div>
              <div class="col-lg-5">
                <div class="row" style="text-align:right">
                  <div class="col-lg-2" style="padding-top:14px">
                    <h5 class="tinytitlelight">${data.gamesWon}</h5>
                    <h6 class="tinytitledark">Wins</h6>
                  </div>
                  <div class="col-lg-3" style="padding-top:14px">
                    <h5 class="tinytitlelight"><img src="${data.ratingIcon}" width="30px"> ${data.rating}</h5>
                    <h6 class="tinytitledark">Skill Rating</h6>
                  </div>
                  <div class="col-lg-4" style="padding-top:14px">
                    <h5 class="tinytitlelight">${data.quickPlayStats.careerStats.allHeroes.game.timePlayed}</h5>
                    <h6 class="tinytitledark">Time Played</h6>
                  </div>
                  <div class="col-lg-3" style="padding-top:14px">
                    <h5 class="tinytitlelight">${data.prestige}${data.level}</h5>
                    <h6 class="tinytitledark">Total Level</h6>
                  </div>
                </div>
              </div>          
            `

          var quickplay = 
            `   
            <div class="row" style="padding-top:25px">
              <div class="col-md-4">
                <div class="square" align="center">
                  <i class="fas fa-fire fa-2x icon"></i>
                  <h3 class="tinytitlelight">${data.quickPlayStats.careerStats.allHeroes.combat.timeSpentOnFire}</h3>
                  <h4 class="tinytitledarker">Time Spent Fire</h4>
                </div>
              </div>  
              <div class="col-md-4">
                <div class="square" align="center">
                  <i class="fas fa-skull fa-2x icon"></i>
                  <h3 class="tinytitlelight">${data.quickPlayStats.careerStats.allHeroes.best.eliminationsMostInGame}</h3>
                  <h4 class="tinytitledarker">Most Eliminations</h4>
                </div>
              </div>
              <div class="col-md-4">
                <div class="square" align="center">
                  <i class="fas fa-plus fa-2x icon"></i>
                  <h3 class="tinytitlelight">${data.quickPlayStats.careerStats.allHeroes.best.healingDoneMostInGame}</h3>
                  <h4 class="tinytitledarker">Most Healing</h4>
                </div>
              </div>
            </div>          
            `

          var comp = 
            `   
            <div class="row" style="padding-top:25px">
              <div class="col-md-4">
                <div class="square" align="center">
                  <i class="fas fa-fire fa-2x icon"></i>
                  <h3 class="tinytitlelight">${data.competitiveStats.careerStats.allHeroes.combat.timeSpentOnFire}</h3>
                  <h4 class="tinytitledarker">Time Spent Fire</h4>
                </div>
              </div>  
              <div class="col-md-4">
                <div class="square" align="center">
                  <i class="fas fa-skull fa-2x icon"></i>
                  <h3 class="tinytitlelight">${data.competitiveStats.careerStats.allHeroes.best.eliminationsMostInGame}</h3>
                  <h4 class="tinytitledarker">Most Eliminations</h4>
                </div>
              </div>
              <div class="col-md-4">
                <div class="square" align="center">
                  <i class="fas fa-plus fa-2x icon"></i>
                  <h3 class="tinytitlelight">${data.competitiveStats.careerStats.allHeroes.best.healingDoneMostInGame}</h3>
                  <h4 class="tinytitledarker">Most Healing</h4>
                </div>
              </div>
            </div>          
            `  

        $(".header").html(header);
        $(".quickplay").html(quickplay);
        $(".comp").html(comp);
    });
    
    </script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>

  <div class="container">
      <div class="row" style="padding: 25px 0px 35px 0px">
        <div class="col-lg-4">
          <h1 class="smalltitle"><a href="index.php">Over<span style="color:#FA9C1D">Square</span></a></h1>
        </div>
        <div class="col-lg-8" align="right" style="padding-top: 11px">
          <form method="get" action="profile.php">
            <input type="text" name="username" placeholder="Username" class="form-style">
            <input type="text" name="id" placeholder="Battle.Net #" class="form-style">
            <select name="platform" class="form-style">
                <option value="pc">PC</option>
                <option value="xbox">Xbox</option>
                <option value="ps4">PS4</option>
                <option value="switch">Switch</option>
             </select>
             <select name="region" class="form-style">
                <option value="us">US</option>
                <option value="eu">EU</option>
                <option value="asia">Asia</option>
             </select>
             <button type="submit" class="form-button"><span class="fas fa-search"></span></button>
          </form>
        </div>
      </div>
      <div class="break"></div>
  <div class="header" style="padding-bottom: 35px"></div>
  <div class="row">
    <div class="col-lg-6">
      <h3 class="tinytitle">Quickplay Stats</h3>
      <div class="break"></div>
      <div class="quickplay"></div>
    </div>
    <div class="col-lg-6">
      <h3 class="tinytitle">Competitive Stats</h3>
      <div class="break"></div>
      <div class="comp"></div>
    </div>
  </div>


</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>