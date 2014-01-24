<?php
/* 
 Template Name: Karte
 */
?>
<?php 
    get_header();
    global $options;  
     ?>

<div class="section content" id="main-content">
  <div class="row">
    <div class="content-primary">
	
	<?php if ( have_posts() ) while ( have_posts() ) : the_post();         
        $custom_fields = get_post_custom();
        ?>

	<?php
	    $image_url = '';
	    $image_alt = '';
	    if (has_post_thumbnail()) { 
		$thumbid = get_post_thumbnail_id(get_the_ID());
		 // array($options['bigslider-thumb-width'],$options['bigslider-thumb-height'])
		$image_url_data = wp_get_attachment_image_src( $thumbid, 'full');
		$image_url = $image_url_data[0];
		$image_alt = trim(strip_tags( get_post_meta($thumbid, '_wp_attachment_image_alt', true) ));
			
	    } else {
		if (($options['aktiv-platzhalterbilder-indexseiten']==1) && (isset($options['src-default-symbolbild']))) {  
		    $image_url = $options['src-default-symbolbild'];		    
		}
	    }
	    
	    if (isset($image_url) && (strlen($image_url)>4)) { 
		if ($options['indexseitenbild-size']==1) {
		    echo '<div class="content-header-big">';
		} else {
		    echo '<div class="content-header">';
		}
		?>    		    		    		        
		   <h1 class="post-title"><span><?php the_title(); ?></span></h1>
		   <div class="symbolbild"><img src="<?php echo $image_url ?>" alt="">
		   <?php if (isset($image_alt) && (strlen($image_alt)>1)) {
		     echo '<div class="caption">'.$image_alt.'</div>';  
		   }  ?>
		   </div>
		</div>  	
	    <?php } ?>

      <div class="skin">
        <?php if (!(isset($image_url) && (strlen($image_url)>4))) { ?>
	    <h1 class="post-title"><span><?php the_title(); ?></span></h1>
	<?php } ?>
	
	


        <?php the_content(); ?>

        <?php endwhile; ?>
        <?php

?>
 <link rel="stylesheet" href="/wp-content/leaflet/leaflet.css" /><script src="/wp-content/leaflet/leaflet.js"></script>
<style>
#map { width:100%;height:400px;}
</style>
<?php

$mapresults = $wpdb->get_results("SELECT * FROM mapdata",ARRAY_A);
$spots = array();
foreach($mapresults as $mapresult)
{
        $spots[$mapresult["keyvalue"]] = $mapresult;
}
$spotname="fruehlingsau";
if(isset($_GET["spotname"])) { $spotname = $_GET["spotname"]; }
$mapdata = $spots[$spotname];
?>
<h2><?php echo $mapdata["headline"]; ?></h2>
<p>Diesen Punkt auf <a href="http://www.bing.com/maps/?v=2&cp=<?=$mapdata["gpslong"]?>~<?=$mapdata["gpslat"]?>&amp;lvl=12&amp;sty=r&amp;where1=<?=$mapdata["gpslong"]?>%252C%2520<?=$mapdata["gpslat"]?>" target="_blank">Bing</a> oder <a href="https://maps.google.com/maps?q=<?=$mapdata["gpslong"]?>,+<?=$mapdata["gpslat"]?>&hl=de&z=16" target="_blank">Google Maps</a>  anzeigen</p>
<div id="map"></div>
<script>

      var map = L.map('map').setView([<?=$mapdata["gpslong"]?>, <?=$mapdata["gpslat"]?>], 15);
      L.tileLayer('/wp-content/tileproxy.php?s={s}&z={z}&x={x}&y={y}', {
        maxZoom: 18,
        attribution: 'CloudMade-Proxy for German Data Protection Act by <a href="http://mrbendig.com/?utm_source=osmmap" target="_blank">Rainer Bendig</a> <br /> Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>'
      }).addTo(map);



      L.marker([<?php echo $mapdata["gpslong"];?>, <?php echo $mapdata["gpslat"];?>]).addTo(map)
          .bindPopup("<b><?=$mapdata["headline"]?></b><?php if(isset($mapdata["text"])) { echo "<br />".$mapdata["text"];}?>").openPopup();
_paq.push(['trackPageView', 'Karte/<?=$spotname?>']);
  </script>
      </div>
    </div>

    <div class="content-aside">
      <div class="skin">

        <h1 class="skip"><?php _e( 'Weitere Informationen', 'piratenkleider' ); ?></h1>   
            <?php

            get_piratenkleider_seitenmenu($options['zeige_sidebarpagemenu'],$options['zeige_subpagesonly'],$options['seitenmenu_mode']);       
            get_sidebar(); ?>
      </div>
    </div>
  </div>
   <?php get_piratenkleider_socialmediaicons(2); ?>
</div>

<?php get_footer(); ?>
