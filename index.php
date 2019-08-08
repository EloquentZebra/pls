<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Parkleitsystem</title>
  <link rel="stylesheet" type="text/css" href="css/normalize.css">
  <link rel="stylesheet" type="text/css" href="css/style.css?v=1.2">



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
    
    $i = 0;
    while ($i <= 14) {

      if ($array['lots'][$i]['free'] / $array['lots'][$i]['total'] < 0.15) {
        $almostFull = 'pps-danger';
      } else {
        $almostFull = '';
      }

      echo '<article class="pps-box">';
        echo '<div class="pps-header-wrapper"><h2>' . $array['lots'][$i]['name'] . '</h2></div>';
        echo '<div class="pps-main-wrapper">';
          echo '<p class="pps-free ' . $almostFull . '">' . $array['lots'][$i]['free'] . '</p>';
          echo '<p class="pps-total">/ ' . $array['lots'][$i]['total'] . '</p>';
          echo '<a class="pps-map-icon" href="https://www.google.com/maps/search/Parkhaus+' . $array['lots'][$i]['name'] . '+Basel" target="_blank"><img src="img/map.svg" alt="Google Maps-Suche nach Parkhaus ' . $array['lots'][$i]['name'] . '"></a>';
        echo '</div>';
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
  

  <script>
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', function() {
        navigator.serviceWorker.register('js/sw.js').then(function(registration) {
          // Registration was successful
          console.log('ServiceWorker registration successful with scope: ', registration.scope);
        }, function(err) {
          // registration failed :(
          console.log('ServiceWorker registration failed: ', err);
        });
      });
    }
  </script>


  <script>
    let deferredPrompt;

    window.addEventListener('beforeinstallprompt', (e) => {
      e.preventDefault();
      deferredPrompt = e;
      // Update UI notify the user they can add to home screen
      btnAdd.style.display = 'block';
    });

    btnAdd.addEventListener('click', (e) => {
    // hide our user interface that shows our A2HS button
    btnAdd.style.display = 'none';
    // Show the prompt
    deferredPrompt.prompt();
    // Wait for the user to respond to the prompt
    deferredPrompt.userChoice
    .then((choiceResult) => {
      if (choiceResult.outcome === 'accepted') {
        console.log('User accepted the A2HS prompt');
      } else {
        console.log('User dismissed the A2HS prompt');
      }
        deferredPrompt = null;
      });
    });


  </script>

</body>
</html>