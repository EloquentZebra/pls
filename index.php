<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Parkleitsystem</title>
  <link rel="stylesheet" type="text/css" href="css/normalize.css">
  <link rel="stylesheet" type="text/css" href="css/style.css?v=1.4">



  <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
  <link rel="manifest" href="img/favicon/site.webmanifest">
  <link rel="mask-icon" href="img/favicon/safari-pinned-tab.svg" color="#204a87">
  <link rel="shortcut icon" href="img/favicon/favicon.ico">
  <meta name="msapplication-TileColor" content="#204a87">
  <meta name="msapplication-config" content="img/favicon/browserconfig.xml">
  <meta name="theme-color" content="#204a87">

</head>
<body>

  <section class="container">

  <?php
    $json = file_get_contents("https://api.parkendd.de/Basel");
    $array = json_decode($json, true);
    
    $arrayLength = count($array['lots']);

    $i = 0;
    while ($i < $arrayLength) {

      if ($array['lots'][$i]['free'] / $array['lots'][$i]['total'] < 0.15) {
        $almostFull = 'pps-danger';
      } else {
        $almostFull = '';
      }

      echo '<article class="pps-box">';
        echo '<header class="pps-header-wrapper"><h2>' . $array['lots'][$i]['name'] . '</h2></header>';
        echo '<main class="pps-main-wrapper">';
          echo '<p class="pps-free ' . $almostFull . '">' . $array['lots'][$i]['free'] . '</p>';
          echo '<p class="pps-total">/ ' . $array['lots'][$i]['total'] . '</p>';
          echo '<a class="pps-map-icon" href="https://www.google.com/maps/search/' . $array['lots'][$i]['lot_type'] . ' ' . $array['lots'][$i]['name'] . '+Basel" target="_blank"><img src="img/map.svg" alt="Google Maps-Suche nach Parkhaus ' . $array['lots'][$i]['name'] . '"></a>';
        echo '</main>';
      echo '</article>';
      $i++;  
    }

  ?>

</section>

<footer>
  <?php
    $date = $array['last_updated'];
    $fixedDate = date('H:i, d.m.Y', strtotime($date) + 60*60 );
  ?>
  <p><a href="."><img src="img/refresh.svg" alt="Seite neu laden"></a> <?php echo $fixedDate; ?></p>
  <!-- <p><a href="https://api.parkendd.de/Basel" target="_blank">API</a> &middot; <a href="https://parkendd.de/map.html#Basel" target="_blank">Karte</a></p> -->
</footer>

</body>
</html>