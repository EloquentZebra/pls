<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Parkleitsystem</title>
  <link rel="stylesheet" type="text/css" href="css/base.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="shortcut icon" href="favicon/favicon.ico">
</head>
<body class="enable-dm">

  <section class="container">

  <?php

    if(isset($_GET['city'])) {
      $choosenCity = htmlspecialchars($_GET["city"]);
      if ($choosenCity == "Zürich") {
        $apiUrl = "https://api.parkendd.de/Zuerich";
      } elseif ($choosenCity == "Basel") {
        $apiUrl = "https://api.parkendd.de/Basel";
      } else {
        $apiUrl = "https://api.parkendd.de/Basel";
      }
    } else {
      $apiUrl = "https://api.parkendd.de/Basel";
    }
    
    

    $json = file_get_contents($apiUrl);
    $array = json_decode($json, true);
    
    $arrayLength = count($array['lots']);

    $i = 0;
    while ($i < $arrayLength) {
      $totalLots = $array['lots'][$i]['total'];
      $freeLots = $array['lots'][$i]['free'];

      if ($totalLots == 0) {
        $totalLots = 1;
      }

      if ($freeLots / $totalLots < 0.15) {
        $almostFull = 'pls-danger';
      } else {
        $almostFull = '';
      }

      echo '<article class="pls-box">';
        echo '<header class="pls-header-wrapper"><h1>' . $array['lots'][$i]['name'] . '</h1><div class="pls-header-links"><a class="pls-icon pls-directions-icon" href="https://www.google.com/maps/dir//' . $array['lots'][$i]['lot_type'] . ' ' . $array['lots'][$i]['name'] . '+Basel" target="_blank"><img src="img/directions.svg" alt="Google Maps-Navigation nach Parkhaus ' . $array['lots'][$i]['name'] . ' aufrufen">   <a class="pls-icon pls-map-icon" href="https://www.google.com/maps/search/' . $array['lots'][$i]['lot_type'] . ' ' . $array['lots'][$i]['name'] . '+Basel" target="_blank"><img src="img/map.svg" alt="Google Maps-Suche nach Parkhaus ' . $array['lots'][$i]['name'] . '"></a></div></header>';
        echo '<main class="pls-main-wrapper">';
          echo '<p class="pls-free ' . $almostFull . '">' . $freeLots . '</p>';
          echo '<p class="pls-total">/ ' . $totalLots . '</p>';
        echo '</main>';
      echo '</article>';
      $i++;  
    }

  ?>

</section>

<footer class="text-center text-small">
  <a href="index.php?city=Basel"><button>Basel</button></a>
  <a href="index.php?city=Zürich"><button>Zürich</button></a>
  <?php
    $date = $array['last_updated'];
    $fixedDate = date('H:i, d.m.Y', strtotime($date) + 60*60 );
  ?>
  <p><a href="."><?php echo $fixedDate; ?></p>
  <!-- <p><a href="https://api.parkendd.de/Basel" target="_blank">API</a> &middot; <a href="https://parkendd.de/map.html#Basel" target="_blank">Karte</a></p> -->
</footer>

</body>
</html>