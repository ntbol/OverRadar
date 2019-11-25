<?php
	error_reporting(E_ERROR);
	$username = htmlspecialchars($_GET['username']);
	$id = htmlspecialchars($_GET['id']);
  $platform = htmlspecialchars($_GET['platform']);
  $region = htmlspecialchars($_GET['region']);

  $data = file_get_contents("https://ow-api.com/v1/stats/$platform/$region/$username-$id/complete");

  $player = json_decode($data);

  $playerKD = $player->quickPlayStats->careerStats->allHeroes->combat->eliminations / $player->quickPlayStats->careerStats->allHeroes->combat->deaths;

?>
<!DOCTYPE html>
<html>
<head>
  <link rel='icon' href='img/favicon.ico' type='image/x-icon'/ >
	<title><?=$username?>#<?=$id?> Overwatch Stats - OverRadar 1.0</title>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript"  src="js/tablesort.js"></script>
  <script type="text/javascript"  src="js/virtualpointer.class.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link href="css/datatables.min.css" rel="stylesheet">
    <script type="text/javascript" src="js/datatables.min.js"></script>
</head>
<body>

  <div class="container">
      <div class="row" style="padding: 25px 0px 35px 0px">
        <div class="col-lg-4">
          <h1 class="smalltitle"><a href="index.php">Over<span style="color:#FA9C1D">Radar</span></a></h1>
        </div>
        <div class="col-lg-8" align="right" style="padding-top: 11px">
          <form method="get" action="profile.php">
            <input type="text" name="username" placeholder="Username" class="form-style">
            <input type="text" name="id" placeholder="Battle.Net #" class="form-style">
            <select name="platform" class="form-style">
                <option value="pc">PC</option>
                <option value="xbox">Xbox</option>
                <option value="psn">PS4</option>
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
  <div class="header" style="padding-bottom: 35px">
    <div class="row" style="padding-top:25px">
        <div class="col-lg-2" align="center">
          <img src="<?=$player->icon?>" class="round" width="100px">
        </div>
        <div class="col-lg-5" style="padding-top:15px">
          <h1 class="mediumtitle"><?=$player->name?></h1>
        </div>
        <div class="col-lg-5" style="padding-top:15px"> 
          <div class="row" style="text-align:right">
            <div class="col-lg-2" style="padding-top:14px">
              <h5 class="tinytitlelight"><?=$player->gamesWon?></h5>
              <h6 class="tinytitledark">Wins</h6>
            </div>
            <div class="col-lg-3" style="padding-top:14px">
              <h5 class="tinytitlelight"><img src="<?=$player->ratingIcon?>" width="30px"><?=$player->rating?></h5>
              <h6 class="tinytitledark">Skill Rating</h6>
            </div>
            <div class="col-lg-4" style="padding-top:14px">
              <h5 class="tinytitlelight">
                <?=$player->quickPlayStats->careerStats->allHeroes->game->timePlayed?></h5>
              <h6 class="tinytitledark">Time Played</h6>
            </div>
            <div class="col-lg-3" style="padding-top:14px">
              <h5 class="tinytitlelight"><?=$player->prestige?><?=$player->level?></h5>
              <h6 class="tinytitledark">Total Level</h6>
            </div>
          </div>
        </div>    
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <h3 class="tinytitle">Overall Stats</h3>
      <div class="break"></div>
    </div>
    <div class="col-lg-12">
      <div class="quickplay">
        <div class="row" style="padding-top:25px;padding-bottom:25px">
          <div class="col-md-2" style="padding-bottom:25px">
            <div class="square" align="center">
              <i class="fas fa-fire fa-2x icon middle"></i>
              <h3 class="tinytitlelight"><?=$player->quickPlayStats->careerStats->allHeroes->combat->timeSpentOnFire?></h3>
              <h4 class="tinytitledarker">Time Spent Fire</h4>
            </div>
          </div>  
          <div class="col-md-2" style="padding-bottom:25px">
            <div class="square" align="center">
              <i class="fas fa-skull fa-2x icon middle"></i>
              <h3 class="tinytitlelight"><?=$player->quickPlayStats->careerStats->allHeroes->best->eliminationsMostInGame?></h3>
              <h4 class="tinytitledarker">Most Eliminations</h4>
            </div>
          </div>
          <div class="col-md-2" style="padding-bottom:25px">
            <div class="square" align="center">
              <i class="fas fa-plus fa-2x icon middle"></i>
              <h3 class="tinytitlelight"><?=$player->quickPlayStats->careerStats->allHeroes->best->healingDoneMostInGame?></h3>
              <h4 class="tinytitledarker">Most Healing</h4>
            </div>
          </div>
          <div class="col-md-2" style="padding-bottom:25px">
            <div class="square" align="center">
              <i class="fas fa-crown fa-2x icon middle"></i>
              <h3 class="tinytitlelight"><?=round($playerKD, 2)?></h3>
              <h4 class="tinytitledarker">K/D Ratio</h4>
            </div>
          </div>  
          <div class="col-md-2" style="padding-bottom:25px">
            <div class="square" align="center">
              <i class="fas fa-user fa-2x icon middle"></i>
              <h3 class="tinytitlelight"><?=$player->quickPlayStats->careerStats->allHeroes->combat->soloKills?></h3>
              <h4 class="tinytitledarker">Solo Kills</h4>
            </div>
          </div>
          <div class="col-md-2" style="padding-bottom:25px">
            <div class="square" align="center">
              <i class="fas fa-radiation-alt fa-2x icon middle"></i>
              <h3 class="tinytitlelight"><?=$player->quickPlayStats->careerStats->allHeroes->combat->environmentalKills?></h3>
              <h4 class="tinytitledarker">Enviromental Kills</h4>
            </div>
          </div>
        </div> 
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-12" style="padding-bottom: 15px">
      <h3 class="tinytitle">Hero Stats</h3>
      <div class="break"></div>
    </div>
    <div class="col-lg-12" style="padding-bottom: 15px">
      <input class="form-control" type="text" id="myInput" placeholder="Search Hero Name...">
    </div>
    <div class="col-lg-12">     
    <table class="table-theme sortable"  id="bookName" showSortDirection="true">
      <thead>
        <tr>
          <th class="col-1"></th>
          <th style="width: 20%" scope="col" compareMethod="text" class="tinytitledark">Hero</th>
          <th style="width: 20%" scope="col" compareMethod="number" class="tinytitledark">Wins</th>
          <th style="width: 20%" scope="col" compareMethod="numeric" class="tinytitledark">K/D</th>
          <th style="width: 20%" scope="col" compareMethod="textual" class="tinytitledark">Accuracy</th>
          <th style="width: 20%" scope="col" compareMethod="time" class="tinytitledark">Time Played</th>
        </tr>
      </thead>
      <!-- KD Ratios -->
      <?php 
        $anaKD = $player->quickPlayStats->careerStats->ana->combat->eliminations / $player->quickPlayStats->careerStats->ana->combat->deaths;
        $asheKD = $player->quickPlayStats->careerStats->ashe->combat->eliminations / $player->quickPlayStats->careerStats->ashe->combat->deaths;
        $baptisteKD = $player->quickPlayStats->careerStats->baptiste->combat->eliminations / $player->quickPlayStats->careerStats->baptiste->combat->deaths;
        $bastionKD = $player->quickPlayStats->careerStats->bastion->combat->eliminations / $player->quickPlayStats->careerStats->bastion->combat->deaths;
        $dVaKD = $player->quickPlayStats->careerStats->dVa->combat->eliminations / $player->quickPlayStats->careerStats->dVa->combat->deaths;
        $doomfistKD = $player->quickPlayStats->careerStats->doomfist->combat->eliminations / $player->quickPlayStats->careerStats->doomfist->combat->deaths;
        $genjiKD = $player->quickPlayStats->careerStats->genji->combat->eliminations / $player->quickPlayStats->careerStats->genji->combat->deaths;
        $hanzoKD = $player->quickPlayStats->careerStats->hanzo->combat->eliminations / $player->quickPlayStats->careerStats->hanzo->combat->deaths;
        $junkratKD = $player->quickPlayStats->careerStats->junkrat->combat->eliminations / $player->quickPlayStats->careerStats->junkrat->combat->deaths;
        $lucioKD = $player->quickPlayStats->careerStats->lucio->combat->eliminations / $player->quickPlayStats->careerStats->lucio->combat->deaths;
        $mccreeKD = $player->quickPlayStats->careerStats->mccree->combat->eliminations / $player->quickPlayStats->careerStats->mccree->combat->deaths;
        $meiKD = $player->quickPlayStats->careerStats->mei->combat->eliminations / $player->quickPlayStats->careerStats->mei->combat->deaths;
        $mercyKD = $player->quickPlayStats->careerStats->mercy->combat->eliminations / $player->quickPlayStats->careerStats->mercy->combat->deaths;
        $moiraKD = $player->quickPlayStats->careerStats->moira->combat->eliminations / $player->quickPlayStats->careerStats->moira->combat->deaths;
        $orisaKD = $player->quickPlayStats->careerStats->orisa->combat->eliminations / $player->quickPlayStats->careerStats->orisa->combat->deaths;
        $dVaKD = $player->quickPlayStats->careerStats->dVa->combat->eliminations / $player->quickPlayStats->careerStats->dVa->combat->deaths;
        $pharahKD = $player->quickPlayStats->careerStats->pharah->combat->eliminations / $player->quickPlayStats->careerStats->pharah->combat->deaths;
        $reaperKD = $player->quickPlayStats->careerStats->reaper->combat->eliminations / $player->quickPlayStats->careerStats->reaper->combat->deaths;
        $reinhardtKD = $player->quickPlayStats->careerStats->reinhardt->combat->eliminations / $player->quickPlayStats->careerStats->reinhardt->combat->deaths;
        $roadhogKD = $player->quickPlayStats->careerStats->roadhog->combat->eliminations / $player->quickPlayStats->careerStats->roadhog->combat->deaths;
        $soldier76KD = $player->quickPlayStats->careerStats->soldier76->combat->eliminations / $player->quickPlayStats->careerStats->soldier76->combat->deaths;
        $sombraKD = $player->quickPlayStats->careerStats->sombra->combat->eliminations / $player->quickPlayStats->careerStats->sombra->combat->deaths;
        $symmetraKD = $player->quickPlayStats->careerStats->symmetra->combat->eliminations / $player->quickPlayStats->careerStats->symmetra->combat->deaths;
        $torbjornKD = $player->quickPlayStats->careerStats->torbjorn->combat->eliminations / $player->quickPlayStats->careerStats->torbjorn->combat->deaths;
        $tracerKD = $player->quickPlayStats->careerStats->tracer->combat->eliminations / $player->quickPlayStats->careerStats->tracer->combat->deaths;
        $widowmakerKD = $player->quickPlayStats->careerStats->widowmaker->combat->eliminations / $player->quickPlayStats->careerStats->widowmaker->combat->deaths;
        $winstonKD = $player->quickPlayStats->careerStats->roadhog->combat->eliminations / $player->quickPlayStats->careerStats->winston->combat->deaths;
        $wreckingBallKD = $player->quickPlayStats->careerStats->wreckingBall->combat->eliminations / $player->quickPlayStats->careerStats->wreckingBall->combat->deaths;
        $zaryaKD = $player->quickPlayStats->careerStats->zarya->combat->eliminations / $player->quickPlayStats->careerStats->zarya->combat->deaths;
        $zenyattaKD = $player->quickPlayStats->careerStats->zenyatta->combat->eliminations / $player->quickPlayStats->careerStats->zenyatta->combat->deaths;
      ?>
      <tbody>
          <tr>
            <td><img src="img/ana.png" class="heroImage"></td>
            <td>Ana</td>
            <td><?=$player->quickPlayStats->careerStats->ana->game->gamesWon?></td>
            <td><?=round($anaKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->ana->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->ana->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/ashe.png" class="heroImage"></td>
            <td>Ashe</td>
            <td><?=$player->quickPlayStats->careerStats->ashe->game->gamesWon?></td>
            <td><?=round($asheKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->ashe->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->ashe->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/baptiste.png" class="heroImage"></td>
            <td>Baptiste</td>
            <td><?=$player->quickPlayStats->careerStats->baptiste->game->gamesWon?></td>
            <td><?=round($baptisteKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->baptiste->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->baptiste->game->timePlayed?></td>
          </tr>  
          <tr>
            <td><img src="img/bastion.png" class="heroImage"></td>
            <td>Bastion</td>
            <td><?=$player->quickPlayStats->careerStats->bastion->game->gamesWon?></td>
            <td><?=round($bastionKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->bastion->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->bastion->game->timePlayed?></td>
          </tr> 
          <tr>
            <td><img src="img/dva.png" class="heroImage"></td>
            <td>dVa</td>
            <td><?=$player->quickPlayStats->careerStats->dVa->game->gamesWon?></td>
            <td><?=round($dVaKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->dVa->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->dVa->game->timePlayed?></td>
          </tr> 
          <tr>
            <td><img src="img/doomfist.png" class="heroImage"></td>
            <td>Doomfist</td>
            <td><?=$player->quickPlayStats->careerStats->doomfist->game->gamesWon?></td>
            <td><?=round($doomfistKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->doomfist->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->doomfist->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/genji.png" class="heroImage"></td>
            <td>Genji</td>
            <td><?=$player->quickPlayStats->careerStats->genji->game->gamesWon?></td>
            <td><?=round($genjiKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->genji->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->genji->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/hanzo.png" class="heroImage"></td>
            <td>Hanzo</td>
            <td><?=$player->quickPlayStats->careerStats->hanzo->game->gamesWon?></td>
            <td><?=round($hanzoKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->hanzo->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->hanzo->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/junkrat.png" class="heroImage"></td>
            <td>Junkrat</td>
            <td><?=$player->quickPlayStats->careerStats->junkrat->game->gamesWon?></td>
            <td><?=round($junkratKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->junkrat->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->junkrat->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/lucio.png" class="heroImage"></td>
            <td>Lucio</td>
            <td><?=$player->quickPlayStats->careerStats->lucio->game->gamesWon?></td>
            <td><?=round($lucioKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->lucio->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->lucio->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/mccree.png" class="heroImage"></td>
            <td>Mccree</td>
            <td><?=$player->quickPlayStats->careerStats->mccree->game->gamesWon?></td>
            <td><?=round($mccreeKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->mccree->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->mccree->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/mei.png" class="heroImage"></td>
            <td>Mei</td>
            <td><?=$player->quickPlayStats->careerStats->mei->game->gamesWon?></td>
            <td><?=round($meiKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->mei->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->mei->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/mercy.png" class="heroImage"></td>
            <td>Mercy</td>
            <td><?=$player->quickPlayStats->careerStats->mercy->game->gamesWon?></td>
            <td><?=round($mercyKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->mercy->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->mercy->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/moira.png" class="heroImage"></td>
            <td>Moira</td>
            <td><?=$player->quickPlayStats->careerStats->moira->game->gamesWon?></td>
            <td><?=round($moiraKD, 2)?></td>
            <td>No Data</td>
            <td><?=$player->quickPlayStats->careerStats->moira->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/orisa.png" class="heroImage"></td>
            <td>Orisa</td>
            <td><?=$player->quickPlayStats->careerStats->orisa->game->gamesWon?></td>
            <td><?=round($orisaKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->orisa->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->orisa->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/pharah.png" class="heroImage"></td>
            <td>Pharah</td>
            <td><?=$player->quickPlayStats->careerStats->pharah->game->gamesWon?></td>
            <td><?=round($pharahKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->pharah->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->pharah->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/reaper.png" class="heroImage"></td>
            <td>Reaper</td>
            <td><?=$player->quickPlayStats->careerStats->reaper->game->gamesWon?></td>
            <td><?=round($reaperKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->reaper->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->reaper->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/reinhardt.png" class="heroImage"></td>
            <td>Reinhardt</td>
            <td><?=$player->quickPlayStats->careerStats->reinhardt->game->gamesWon?></td>
            <td><?=round($reinhardtKD, 2)?></td>
            <td>No Data</td>
            <td><?=$player->quickPlayStats->careerStats->reinhardt->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/roadhog.png" class="heroImage"></td>
            <td>Roadhog</td>
            <td><?=$player->quickPlayStats->careerStats->roadhog->game->gamesWon?></td>
            <td><?=round($roadhogKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->roadhog->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->roadhog->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/soldier76.png" class="heroImage"></td>
            <td>Soldier76</td>
            <td><?=$player->quickPlayStats->careerStats->soldier76->game->gamesWon?></td>
            <td><?=round($mccreeKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->soldier76->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->soldier76->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/sombra.png" class="heroImage"></td>
            <td>Sombra</td>
            <td><?=$player->quickPlayStats->careerStats->sombra->game->gamesWon?></td>
            <td><?=round($sombraKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->sombra->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->sombra->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/symmetra.png" class="heroImage"></td>
            <td>Symmetra</td>
            <td><?=$player->quickPlayStats->careerStats->symmetra->game->gamesWon?></td>
            <td><?=round($symmetraKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->symmetra->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->symmetra->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/torbjorn.png" class="heroImage"></td>
            <td>Torbjorn</td>
            <td><?=$player->quickPlayStats->careerStats->torbjorn->game->gamesWon?></td>
            <td><?=round($torbjornKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->torbjorn->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->torbjorn->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/symmetra.png" class="heroImage"></td>
            <td>Symmetra</td>
            <td><?=$player->quickPlayStats->careerStats->symmetra->game->gamesWon?></td>
            <td><?=round($symmetraKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->symmetra->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->symmetra->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/tracer.png" class="heroImage"></td>
            <td>Tracer</td>
            <td><?=$player->quickPlayStats->careerStats->tracer->game->gamesWon?></td>
            <td><?=round($tracerKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->tracer->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->tracer->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/widowmaker.png" class="heroImage"></td>
            <td>Widowmaker</td>
            <td><?=$player->quickPlayStats->careerStats->widowmaker->game->gamesWon?></td>
            <td><?=round($widowmakerKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->widowmaker->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->widowmaker->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/winston.png" class="heroImage"></td>
            <td>Winston</td>
            <td><?=$player->quickPlayStats->careerStats->winston->game->gamesWon?></td>
            <td><?=round($winstonKD, 2)?></td>
            <td>No Data</td>
            <td><?=$player->quickPlayStats->careerStats->winston->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/wreckingBall.png" class="heroImage"></td>
            <td>Wrecking Ball</td>
            <td><?=$player->quickPlayStats->careerStats->wreckingBall->game->gamesWon?></td>
            <td><?=round($wreckingBallKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->wreckingBall->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->wreckingBall->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/zarya.png" class="heroImage"></td>
            <td>Zarya</td>
            <td><?=$player->quickPlayStats->careerStats->zarya->game->gamesWon?></td>
            <td><?=round($symmetraKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->zarya->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->zarya->game->timePlayed?></td>
          </tr>
          <tr>
            <td><img src="img/zenyatta.png" class="heroImage"></td>
            <td>Zenyatta</td>
            <td><?=$player->quickPlayStats->careerStats->zenyatta->game->gamesWon?></td>
            <td><?=round($zenyattaKD, 2)?></td>
            <td><?=$player->quickPlayStats->careerStats->zenyatta->combat->weaponAccuracy?></td>
            <td><?=$player->quickPlayStats->careerStats->zenyatta->game->timePlayed?></td>
          </tr>
      </tbody>
    </table>
    </div>
</div>
<div class="footer">
  <div class="row">
    <div class="col-md-6">
      <h1 class="smallertitle"><a href="index.php">Over<span style="color:#FA9C1D">Radar</span></a></h1>
    </div>
    <div class="col-md-6" align="right" style="padding-top: 10px;">
      <h5 class="footertext"><a href="https://twitter.com/ntbol" class="btn theme-button"><span class="fas fa-life-ring"></span> Need help or found a bug?</a></h5>
    </div>
  </div>
</div>
</div>
<div class="bar"></div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <script>
    function bookSearch(event) {
        var filter = event.target.value.toUpperCase();
        var rows = document.querySelector("#bookName tbody").rows;
        
        for (var i = 0; i < rows.length; i++) {
            var firstCol = rows[i].cells[0].textContent.toUpperCase();
            var secondCol = rows[i].cells[1].textContent.toUpperCase();
            if (firstCol.indexOf(filter) > -1 || secondCol.indexOf(filter) > -1) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }      
        }
    }
    document.querySelector('#myInput').addEventListener('keyup', bookSearch, false);
  
  </script>
</body>
</html>