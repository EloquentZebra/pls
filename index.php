<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>PPS</title>
  <link rel="stylesheet" type="text/css" href="css/normalize.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

  <h1>Parkleitsystem</h1>

  <section class="container">

  <?php
    $json = file_get_contents("https://api.parkendd.de/Basel");
    $array = json_decode($json, true);
    
    $i = 0;
    while ($i <= 14) {

      if ($array['lots'][$i]['free'] / $array['lots'][$i]['total'] < 0.1) {
        $almostFull = 'pps-danger';
      } else {
        $almostFull = '';
      }


      echo '<article class="pps-box">';
        echo '<div class="pps-header-wrapper"><h2>' . $array['lots'][$i]['name'] . '</h2></div>';
        echo '<div class="pps-main-wrapper">';
          echo '<p class="pps-free' . $almostFull . '">' . $array['lots'][$i]['free'] . '</p>';
          echo '<p class="pps-total">/ ' . $array['lots'][$i]['total'] . '</p>';
          echo '<a class="pps-map-icon" href="https://www.google.com/maps/search/Parkhaus+' . $array['lots'][$i]['name'] . '+Basel" target="_blank"><img src="img/map.svg"></a>';
        echo '</div>';
      echo '</article>';
      $i++;

      
    }

  ?>

</section>

<footer>
  <p><a href="."><img src="img/refresh.svg"></a>  <?php echo $array['last_updated']; ?></p>
</footer>
</body>
</html>