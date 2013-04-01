<?php 
global $defaultoptions;
global $sfcounter;

if (!isset($sfcounter) || ($sfcounter == 0)) {
    $sfcounter = 1;
    $sfid = 'id="searchform"';
} else {
    $sfcounter++;
    $sfid = "";
}
$sfid2 = "s".$sfcounter;
?>
<h2 <?=$sfid;?> class="skip"><?php _e("Suche", 'piratenkleider'); ?></h2>

<form method="get" <?=$searchformid;?> class="searchform" action="<?php echo home_url(); ?>/">
	<label class="visuallyhidden" for="<?=$sfid2;?>"><?php _e("Suche nach", 'piratenkleider'); ?>:</label>
	<input type="text" value="<?php the_search_query(); ?>" name="s" class="s" id="<?=$sfid2;?>" placeholder="<?php _e("Suchbegriff eingeben", 'piratenkleider'); ?>"  
            onfocus="if(this.value=='<?php _e("Suchbegriff eingeben", 'piratenkleider'); ?>')this.value='';" onblur="if(this.value=='')this.value='<?php _e("Suchbegriff eingeben", 'piratenkleider'); ?>';" />
	<input type="submit" class="searchsubmit" value="<?php _e("Suchen", 'piratenkleider'); ?>" />
</form>
