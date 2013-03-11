<?php
   global $defaultoptions;
   global $defaultbilder_liste;
   $options = get_option( 'piratenkleider_theme_options' );
   $bilderoptions = get_option( 'piratenkleider_theme_defaultbilder' ); 
?>          
<div class="first-teaser-widget-area">
<?php if ( is_active_sidebar( 'first-teaser-widget-area' ) ) { ?>
        <?php dynamic_sidebar( 'first-teaser-widget-area' ); ?>
    <?php } else {        
   
    if (!isset($options['slider-modus'])) 
		$options['slider-modus'] = $defaultoptions['slider-modus'];       
    if (!isset($options['teaser-showpauseplay'])) 
		$options['teaser-showpauseplay'] = $defaultoptions['teaser-showpauseplay'];       	
    if (!isset($options['teaser-showpaging'])) 
		$options['teaser-showpaging'] = $defaultoptions['teaser-showpaging'];     
	
	$hideclasses = array();
	if ($options['teaser-showpauseplay'] == 0) $hideclasses[] = "flexslider-hidepauseplay";
	if ($options['teaser-showpaging'] == 0) $hideclasses[] = "flexslider-hidepaging";
	
	if ($options['slider-modus'] == 0) {
	
			 $defaultbildsrc = $bilderoptions['slider-defaultbildsrc'];                        
			 $defaultbildersrc = $bilderoptions['slider-defaultbildersrc'];
			 $defaultbildersrc_alt = $bilderoptions['slider-altadressen'];
			 $cat = $options['slider-catid'];
		 global $thisCat;
		 if (isset($thisCat)) {
			 $cat = $thisCat;
		 }
			 if (!isset($cat) ) $cat = 1;         
			 $numberarticle = $options['slider-numberarticle'];
			 if (!isset($numberarticle) )  $numberarticle =3;   

			 if (!isset($options['teaser-subtitle'])) 
				$options['teaser-subtitle'] = $defaultoptions['teaser-subtitle'];
		 
		 global $thisCatName;
		 
			  if (!isset($options['teaser-title-maxlength'])) 
				$options['teaser-title-maxlength'] = $defaultoptions['teaser-title-maxlength'];        
			  if (!isset($options['teaser-title-words'])) 
				$options['teaser-title-words'] = $defaultoptions['teaser-title-words'];
			   if (!isset($options['teaser-type'])) 
				$options['teaser-type'] = $defaultoptions['teaser-type'];
		   
		$subtitle =  $options['teaser-subtitle'];
			if (isset($thisCatName)) {
			$subtitle = $thisCatName;
		}

			query_posts( array( 'cat' => "$cat", 'posts_per_page' => $numberarticle) );
			?>
			<div class="flexslider <? echo implode(" ", $hideclasses); ?>">
				<h2 class="skip"><?php _e( 'Aktuelle Themen', 'piratenkleider' ); ?></h2>
				<ul class="slides">
			<?php 
			if ( have_posts() ) while ( have_posts() ) : the_post();
				echo "<li class='slide'>";
				if ($options['teaser-type'] == 'big') {
					 echo '<div class="bigslider">';
					if (has_post_thumbnail()) {           
					 the_post_thumbnail(array($defaultoptions['bigslider-thumb-width'],$defaultoptions['bigslider-thumb-height']));
					} else {
					
						if (isset($defaultbildersrc) || ((isset($defaultbildersrc_alt)) && (strlen( $defaultbildersrc_alt)>2))) {
							if ((isset($defaultbildersrc_alt)) && (strlen(trim($defaultbildersrc_alt)))) {                  
								$slider_alturls = preg_split("/[\n\r]+/", $defaultbildersrc_alt);
							}
							if ((is_array($slider_alturls)) && (is_array($defaultbildersrc))) {
								$slider_liste = array_merge($slider_alturls, $defaultbildersrc);
							} elseif (is_array($slider_alturls)) {
								$slider_liste = $slider_alturls;
							} else {
								$slider_liste = $defaultbildersrc;
							}	
							$randombild = array_rand($slider_liste,1);
							echo '<img src="'.$slider_liste[$randombild].'" width="'.$defaultoptions['bigslider-thumb-width'].'" height="'.$defaultoptions['bigslider-thumb-height'].'" alt="">'; 
						} else {
							$randombild = array_rand($defaultbilder_liste,2);
							echo '<img src="'.$defaultbilder_liste[$randombild[0]]['src'].'" width="'.$defaultoptions['bigslider-thumb-width'].'" height="'.$defaultoptions['bigslider-thumb-height'].'" alt="">'; 
						}
					}
					echo '<div class="caption"><p class="bebas">'.$subtitle.'</p>';
					echo "<h3><a href=";
					the_permalink();
					echo ">";
					echo short_title('&hellip;', $options['teaser-title-words'], $options['teaser-title-maxlength']);
					echo "</a></h3></div>";        
					echo "</div>";    
				} else {
					echo '<div class="textslider">';
					if (has_post_thumbnail()) {           
						the_post_thumbnail(array($defaultoptions['smallslider-thumb-width'],$defaultoptions['smallslider-thumb-height']));                
				   } else {
						if (isset($defaultbildersrc) || ((isset($defaultbildersrc_alt)) && (strlen( $defaultbildersrc_alt)>2))) {
							if ((isset($defaultbildersrc_alt)) && (strlen(trim($defaultbildersrc_alt)))) {                  
								$slider_alturls = preg_split("/[\n\r]+/", $defaultbildersrc_alt);
							}
							if ((is_array($slider_alturls)) && (is_array($defaultbildersrc))) {
								$slider_liste = array_merge($slider_alturls, $defaultbildersrc);
							} elseif (is_array($slider_alturls)) {
								$slider_liste = $slider_alturls;
							} else {
								$slider_liste = $defaultbildersrc;
							}	
							$randombild = array_rand($slider_liste,1);
							echo '<img src="'.$slider_liste[$randombild].'" width="'.$defaultoptions['smallslider-thumb-width'].'" height="'.$defaultoptions['smallslider-thumb-height'].'" alt="">';                
						} else {
							$randombild = array_rand($defaultbilder_liste,2);
							echo '<img src="'.$defaultbilder_liste[$randombild[0]]['src'].'" width="'.$defaultoptions['smallslider-thumb-width'].'" height="'.$defaultoptions['smallslider-thumb-height'].'" alt="">'; 
						}
					}              
					echo "<h3><a href=";
					the_permalink();
					echo ">";
					the_title();
					echo '</a></h3><div class="teaser-excerpt">';
					echo get_piratenkleider_custom_excerpt();
					echo "</div></div>";          
				}
				
				echo "</li>";
			endwhile;
			echo "</ul>";
			echo "</div>";
			wp_reset_query(); 
			
		} elseif ($options['slider-modus'] == 1) {
			?>
			<div class="flexslider <? echo implode(" ", $hideclasses); ?>">
				<h2 class="skip"><?php _e( 'Aktuelle Themen', 'piratenkleider' ); ?></h2>
				<ul class="slides">
			<?
			
		$gpteaser = get_option( 'piratenkleider_theme_defaultbilder'); 
			
		  if ((isset($gpteaser['gpmodus-altadressen'])) && (strlen(trim($gpteaser['gpmodus-altadressen']))>2)) {                  
				$alturls = preg_split("/[\n\r]+/", $gpteaser['gpmodus-altadressen']);
				if (is_array( $alturls )) {
					foreach ( $alturls  as $current) {
						list($thisurl,$thistitel,$thisweb) = explode("|", $current);
						$thisurl = esc_url( $thisurl );
						$thisweb = esc_url ($thisweb);
						
						echo "<li class='slide'>";
						echo '<div class="bigslider">';
						echo '<img src="'.$thisurl.'" width="'.$defaultoptions['bigslider-thumb-width'].'" height="'.$defaultoptions['bigslider-thumb-height'].'" alt="">'; 
						$subtitle =  $options['teaser-gpsubtitle'];
						echo '<div class="caption"><p class="bebas">'.do_shortcode(stripslashes($subtitle)).'</p>';
						echo "<h3><a href=\"{$options['teaser-gplink']}\">";
						echo do_shortcode(stripslashes($options['teaser-title']));
						echo "</a></h3></div>";        
						echo "</div>"; 
						echo "</li>";
					}
				}
			}
			?>
			</ul></div>
			<?
		}
    } ?>
</div>
<div class="second-teaser-widget-area">
<div class="skin">
    <?php if ( is_active_sidebar( 'second-teaser-widget-area' ) ) { ?>
        <?php dynamic_sidebar( 'second-teaser-widget-area' ); ?>
    <?php } else {
          if (!isset($options['teaserlink1-title'])) 
            $options['teaserlink1-title'] = $defaultoptions['teaserlink1-title'];   
        if (!isset($options['teaserlink1-untertitel'])) 
            $options['teaserlink1-untertitel'] = $defaultoptions['teaserlink1-untertitel'];   
        if (!isset($options['teaserlink1-url'])) 
            $options['teaserlink1-url'] = $defaultoptions['teaserlink1-url'];   
        if (!isset($options['teaserlink1-symbol'])) 
            $options['teaserlink1-symbol'] = $defaultoptions['teaserlink1-symbol'];   
        if (!isset($options['teaserlink2-title'])) 
            $options['teaserlink2-title'] = $defaultoptions['teaserlink2-title'];   
        if (!isset($options['teaserlink2-untertitel'])) 
            $options['teaserlink2-untertitel'] = $defaultoptions['teaserlink2-untertitel'];   
        if (!isset($options['teaserlink2-url'])) 
            $options['teaserlink2-url'] = $defaultoptions['teaserlink2-url'];   
        if (!isset($options['teaserlink2-symbol'])) 
            $options['teaserlink2-symbol'] = $defaultoptions['teaserlink2-symbol'];  

        if (!isset($options['teaserlink3-title'])) 
            $options['teaserlink3-title'] = $defaultoptions['teaserlink3-title'];   
        if (!isset($options['teaserlink3-untertitel'])) 
            $options['teaserlink3-untertitel'] = $defaultoptions['teaserlink3-untertitel'];   
        if (!isset($options['teaserlink3-url'])) 
            $options['teaserlink3-url'] = $defaultoptions['teaserlink3-url'];   
        if (!isset($options['teaserlink3-symbol'])) 
            $options['teaserlink3-symbol'] = $defaultoptions['teaserlink3-symbol'];  
     ?>
    
        <div class="teaserlinks">
            <ul>
                <li><a class="symbol symbol-<?php echo $options['teaserlink1-symbol'] ?>" href="<?php echo $options['teaserlink1-url'] ?>"><?php echo $options['teaserlink1-title'] ?> <span><?php echo $options['teaserlink1-untertitel'] ?></span></a></li>
                <li><a class="symbol symbol-<?php echo $options['teaserlink2-symbol'] ?>" href="<?php echo $options['teaserlink2-url'] ?>"><?php echo $options['teaserlink2-title'] ?> <span><?php echo $options['teaserlink2-untertitel'] ?></span></a></li>
                <li><a class="symbol symbol-<?php echo $options['teaserlink3-symbol'] ?>" href="<?php echo $options['teaserlink3-url'] ?>"><?php echo $options['teaserlink3-title'] ?> <span><?php echo $options['teaserlink3-untertitel'] ?></span></a></li>
            </ul>
        </div>

    <?php }  ?>
</div>
</div>
