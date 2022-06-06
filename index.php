<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Parkleitsystem</title>
  <link rel="stylesheet" type="text/css" href="css/base.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">



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
<body class="enable-dm">

  <section class="container">

  <?php
    $json = file_get_contents("https://api.parkendd.de/Basel");
    $array = json_decode($json, true);
    
    $arrayLength = count($array['lots']);

    $i = 0;
    while ($i < $arrayLength) {

      if ($array['lots'][$i]['free'] / $array['lots'][$i]['total'] < 0.15) {
        $almostFull = 'pls-danger';
      } else {
        $almostFull = '';
      }

      echo '<article class="pls-box">';
        echo '<header class="pls-header-wrapper"><h1>' . $array['lots'][$i]['name'] . '</h1><div class="pls-header-links"><a class="pls-icon pls-directions-icon" href="https://www.google.com/maps/dir//' . $array['lots'][$i]['lot_type'] . ' ' . $array['lots'][$i]['name'] . '+Basel" target="_blank"><img src="img/directions.svg" alt="Google Maps-Navigation nach Parkhaus ' . $array['lots'][$i]['name'] . ' aufrufen">   <a class="pls-icon pls-map-icon" href="https://www.google.com/maps/search/' . $array['lots'][$i]['lot_type'] . ' ' . $array['lots'][$i]['name'] . '+Basel" target="_blank"><img src="img/map.svg" alt="Google Maps-Suche nach Parkhaus ' . $array['lots'][$i]['name'] . '"></a></div></header>';
        echo '<main class="pls-main-wrapper">';
          echo '<p class="pls-free ' . $almostFull . '">' . $array['lots'][$i]['free'] . '</p>';
          echo '<p class="pls-total">/ ' . $array['lots'][$i]['total'] . '</p>';
        echo '</main>';
      echo '</article>';
      $i++;  
    }

  ?>

</section>

<footer class="text-center text-small">
  <?php
    $date = $array['last_updated'];
    $fixedDate = date('H:i, d.m.Y', strtotime($date) + 60*60 );
  ?>
  <p><a href="."><?php echo $fixedDate; ?></p>
  <!-- <p><a href="https://api.parkendd.de/Basel" target="_blank">API</a> &middot; <a href="https://parkendd.de/map.html#Basel" target="_blank">Karte</a></p> -->
</footer>

</body>
</html>