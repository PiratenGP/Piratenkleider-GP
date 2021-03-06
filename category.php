<?php get_header();    
  global $options;  
  
   
   if ($options['category-startpageview']) {
        global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCatName =  get_cat_name($thisCat);
	  
	    if ( $options['slider-aktiv'] == "1" ){ ?>  
	    <div class="section teaser">
		<div class="row">
		    <?php get_sidebar( 'teaser' ); ?>
		</div>  
	    </div>
	<?php } ?>
	
	<div class="section content" id="main-content">
  <div class="row">
    <div class="content-primary">
      <div class="skin">

          <h1 class="skip"><?php _e("Aktuelle Artikel", 'piratenkleider'); ?></h1>
          
      <?php
      $i = 0; 
      $col = 0; 
      $numentries = $options['num-article-startpage-fullwidth'] + $options['num-article-startpage-halfwidth']; 
      $col_count = 3; 
      $cols = array();
     
      global $query_string;
      query_posts( $query_string . '&cat=$thisCat' );
 
      while (have_posts() && $i<$numentries) : the_post();
      $i++;
      ob_start();
	  $num_comments = get_comments_number();
      ?>

      <div <?php post_class(); ?> id="post-<?php the_ID(); ?>" >
        <div class="post-title">
          <h2>
            <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>">
              <?php the_title(); ?>
            </a>
          </h2>
        </div>
		<?php if ($options['aktiv-calendericon-instead-text'] == 0) { ?>
				<div class="cal-datum">
				<?php
				$infostring = translate("Vom")." ".get_the_time('j. F Y').", ".get_the_time('H:i')." ".translate("Uhr");
				if ($options['aktiv-startseite-comments'] == 1) {
					if ($num_comments>1) { 
						$infostring .= ", <a href=\"".get_comments_link()."\">".$num_comments." ".translate("Kommentare")."</a>";
					} elseif ($num_comments==1) {
						$infostring .= ", <a href=\"".get_comments_link()."\">1 ".translate("Kommentar")."</a>";
					} elseif (($num_comments==0) && ($options['zeige_commentbubble_null'] == 1)) {
						$infostring .= ", <a href=\"".get_comments_link()."\">".translate("keine Kommentare")."</a>";
					}
				}
				echo $infostring;
				?>
				</div>
		<?php } ?>
        <div class="post-info">
		<?php $firstpic = get_piratenkleider_firstpicture(); ?>
		<?php if ($options['aktiv-startseite-comments'] == 1) { ?>
			<?php if ($options['aktiv-calendericon-instead-text'] == 1) { ?>
			  <?php if (($num_comments>0) || ( $options['zeige_commentbubble_null'])) { ?>
				 <div class="commentbubble"> 
					<?php 
						if ($num_comments>0) {
						   comments_popup_link( '0<span class="skip"> Kommentar</span>', '1<span class="skip"> Kommentar</span>', '%<span class="skip"> Kommentare</span>', 'comments-link', '%<span class="skip"> Kommentare</span>');           
						} else {
							// Wenn der Zeitraum abgelaufen ist UND keine Kommentare gegeben waren, dann
							// liefert die Funktion keinen Link, sondern nur den Text . Daher dieser
							// Woraround:
							$link = get_comments_link();
							echo '<a href="'.$link.'">0<span class="skip"> Kommentar</span></a>';
					  }
					?>
				  </div> 
			  <?php } ?>
			<?php } ?>
		<?php } ?>
		<?php
          if ($options['aktiv-images-instead-date'] && !empty($firstpic)) {                                                    
			?>
			<div class="infoimage">                    
					<?php echo $firstpic ?>
			</div>                    
			<?php
          } elseif ($options['aktiv-calendericon-instead-text'] == 1) { ?>
			 <div class="cal-icon">
                    <span class="day"><?php the_time('j.'); ?></span>
                    <span class="month"><?php the_time('m.'); ?></span>
                    <span class="year"><?php the_time('Y'); ?></span>
             </div>
		  <?php } ?>
          </div>
        <div class="post-entry">
        <?php echo get_piratenkleider_custom_excerpt(); ?>         
        </div>
      </div>

      <?php 
      $output = ob_get_contents();
      ob_end_clean();
      if (isset($output)) {
        $cols[$col++] = $output;
      }
      endwhile;
      ?>
      <div class="columns">
        <?php
        $z=1;
        foreach($cols as $key => $col) {
            if (( isset($options['num-article-startpage-fullwidth']))
                && ($options['num-article-startpage-fullwidth']>$key )) {
                    echo '<div class="column0">' . $col . '<hr></div>';                              
                } else {                                        
                    echo '<div class="column'.$z.'">' . $col . '</div>';                            
                    $z++;
                    if ($z>2) {
                        $z=1;
                        echo '<hr style="clear: both;">';
                    }
                }            
        }
        ?>     
      </div>

      
      <?php if ( ! have_posts() ) : ?>
       <h2><?php _e("Nichts gefunden", 'piratenkleider'); ?></h2>
        <p>
            <?php _e("Es konnten keine Artikel gefunden werden. Bitte versuchen Sie es nochmal mit einer Suche.", 'piratenkleider'); ?>
        </p>
        <?php get_search_form(); ?>
        <hr>
      <?php endif; ?>                  
      
      <div class="startpage-widget-area">

        <h2 class="skip"><?php _e("Weitere Artikel", 'piratenkleider'); ?></h2>
        <div class="first-startpage-widget-area">
          <div class="skin">
            <?php if ( is_active_sidebar( 'first-startpage-widget-area' ) ) { ?>
                <?php dynamic_sidebar( 'first-startpage-widget-area' ); ?>
            <?php } else { 

                 $numold = $options['aktiv-startseite-alteartikel-num'];
                 
                 if ($options['aktiv-startseite-alteartikel']==1) {                  
                    $postslist = get_posts("numberposts=$numold&order=DESC&offset=$numentries&cat=$thisCat"); 
                    if ((isset($postslist)) && (count($postslist)>0)) { ?>
                        <div class="widget">
                            <h3><?php _e("&Auml;ltere Artikel", 'piratenkleider'); ?></h3>
                            <ul>
                            <?php foreach ($postslist as $post) : setup_postdata($post); ?>
                                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                <span class="date"><?php the_time('d.m.Y') ?></span></li>
                            <?php endforeach; ?>
                            </ul>
                        </div>              
                    <?php 
                      }
                  }
                  if ($options['aktiv-startseite-kategorien']==1) { 
               ?>
                <div class="widget">
                    <h3><?php _e("Kategorien", 'piratenkleider'); ?></h3>
                    <ul>
                        <?php wp_list_categories('title_li='); ?>
                    </ul>
                </div>
             <?php } } ?>
          </div>
        </div>

        <div class="second-startpage-widget-area">
        <div class="skin">
            <?php if ( is_active_sidebar( 'second-startpage-widget-area' ) ) { ?>
                <?php dynamic_sidebar( 'second-startpage-widget-area' ); ?>
            <?php } else { 
                
                if ($options['aktiv-startseite-tags']==1) {
                ?>    
                <div  class="widget">
                    <?php 
		     $tags = get_tags();
                     if ((isset($tags)) && (count($tags)>0)) { ?>
                            <h3><?php _e("Schlagworte", 'piratenkleider'); ?></h3>

                            <div class="tagcloud">            
                                <?php wp_tag_cloud(array('smallest'  => 14, 'largest'   => 28)); ?>
                            </div>
                              
                    <?php  }  ?>
                     
                </div>
            <?php } } ?>
        </div>
      </div>
      </div>

      </div>
    </div>


	<?php 
   } else {
?> 
<div class="section content" id="main-content">
  <div class="row">
    <div class="content-primary">

	  
	  
	<?php
	    $image_url = '';	  
	    if (($options['aktiv-platzhalterbilder-indexseiten']==1) && (isset($options['src-default-symbolbild-category']))) {  
		    $image_url = $options['src-default-symbolbild-category'];		    
	    }	    
	    
	    if (isset($image_url) && (strlen($image_url)>4)) { 
		if ($options['indexseitenbild-size']==1) {
		    echo '<div class="content-header-big">';
		} else {
		    echo '<div class="content-header">';
		}
		?>    		    		    		        
		   <h1 class="post-title"><span><?php printf( __( 'Kategorie %s', 'piratenkleider' ), '' . single_cat_title( '', false ) . '' ); ?></span></h1>
		   <div class="symbolbild"><img src="<?php echo $image_url ?>" alt=""></div>
		</div>  	
	    <?php } ?>
	
      <div class="skin">
	  
	  <?php if (!(isset($image_url) && (strlen($image_url)>4))) { ?>
	    <h1 class="post-title"><span><?php printf( __( 'Kategorie %s', 'piratenkleider' ), '' . single_cat_title( '', false ) . '' ); ?></span></h1>
	<?php } 
	
          get_template_part( 'loop', 'category' ); ?>       
          <div class="widget">               
                <ul>
                     <?php wp_list_categories('title_li='); ?> 
                </ul>                                             
            </div>
        </div>
    </div>
<?php } ?>
    <div class="content-aside">
      <div class="skin">  
          <h1 class="skip"><?php _e( 'Weitere Informationen', 'piratenkleider' ); ?></h1>
         <?php get_sidebar(); ?>
      </div>
    </div>
  </div>
   <?php get_piratenkleider_socialmediaicons(2); ?>
</div>

<?php get_footer(); ?>
