<?php
  trace(__FILE__,'begin');
  set_page_title(lang('project theme settings'));
  project_tabbed_navigation(PROJECT_TAB_THEME_SETTINGS);
  project_crumbs(array(
    array(lang('theme settings'), get_url('theme_settings', 'index'))
  ));
  add_stylesheet_to_page('project/theme_settings.css');
  $counter = 0;
?>


<?php if (isset($theme_settings) && is_array($theme_settings) && count($theme_settings)) { ?>
	<?php foreach ($theme_settings as $theme_setting) { ?>
    
    	<!--<fieldset><legend><?php echo $theme_setting->getTitle(); ?></legend> -->
    	    
			<?php $theme_setting->print_preview(); ?>
			<?php if (logged_user()->isAdministrator(owner_company())) {?>
	      		<div class="fileOptions">
        			<a href="<?php echo $theme_setting->getEditUrl(); ?>"><?php echo lang('edit'); ?></a>
                    <a href="<?php echo $theme_setting->getDeleteUrl(); ?>"><?php echo lang('delete'); ?></a>
                </div>
			<?php } ?>
		<!--</fieldset> -->
	<?php } // foreach ?>
    
<?php } else { ?>

	<p style="width:300px;"><?php echo lang('emeraldcurtain theme warning'); ?></p>
    
	<?php if (logged_user()->isAdministrator(owner_company())) { ?>
		<div class="fileOptions">
    		<a href="<?php echo get_url('theme_settings', 'add_theme_setting'); ?>"><?php echo lang('add theme settings'); ?></a>
        </div>
	<?php } ?>
<?php } // if ?>
</div>

<?php trace(__FILE__,'begin'); ?>
