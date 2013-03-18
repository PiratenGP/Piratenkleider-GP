<?php 
global $defaultoptions;
global $notfirstsearchform;
?>
<h2 class="skip"><?php _e("Suche", 'piratenkleider'); ?></h2>
<?php
    if (!($notfirstsearchform == true)) {
        $searchformid = "id=\"searchform\"";
        $notfirstsearchform = true;
    } else {
        $searchformid = "";
    }
?>
<form method="get" <?=$searchformid;?> class="searchform" action="<?php echo home_url(); ?>/">
	<label class="visuallyhidden" for="s"><?php _e("Suche nach", 'piratenkleider'); ?>:</label>
	<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" placeholder="<?php _e("Suchbegriff eingeben", 'piratenkleider'); ?>"  
            onfocus="if(this.value=='<?php _e("Suchbegriff eingeben", 'piratenkleider'); ?>')this.value='';" onblur="if(this.value=='')this.value='<?php _e("Suchbegriff eingeben", 'piratenkleider'); ?>';" />
	<input type="submit" class="searchsubmit" value="<?php _e("Suchen", 'piratenkleider'); ?>" />
</form>