<section class="map" id="map"></section>
<script>
  mapboxgl.accessToken = '<?php echo($token); ?>';
  const map = new mapboxgl.Map({
    container: 'map', // container ID
    style: 'mapbox://styles/confident-zebra/cl42fs55c001u14me2oe72pc6', // style URL
    center: [7.6, 47.56], // starting position [lng, lat]
    zoom: 13 // starting zoom
  });

  // create markers for the parklots
  <?php
    $i = 0;
    while ($i < $arrayLength) {
      ?>
      const popup<?php echo($i); ?> = new mapboxgl.Popup({ offset: 25 })
        .setHTML('<p class="text-center"><strong><?php echo($array['lots'][$i]['name']); ?></strong></p><p class="text-center"><?php echo($freeLots); ?> <br> / <span class="small"><?php echo($totalLots); ?></span></p>');

      const marker<?php echo($i); ?> = new mapboxgl.Marker({
        draggable: false,
      })
      .setLngLat([<?php echo($array['lots'][$i]['coords']['lng']); ?>, <?php echo($array['lots'][$i]['coords']['lat']); ?>])
      .setPopup(popup<?php echo($i); ?>)
      .addTo(map)

      <?php
      $i++;
    }
    ?>
</script>