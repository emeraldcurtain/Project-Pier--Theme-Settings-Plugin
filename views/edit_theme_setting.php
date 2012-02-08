<?php
  set_page_title($project_theme_setting->isNew() ? lang('add theme settings') : lang('edit theme settings'));
  project_tabbed_navigation(PROJECT_TAB_THEME_SETTINGS);
  project_crumbs(array(
    array(lang('theme settings'), get_url('theme_settings')),
    array($project_theme_setting->isNew() ? lang('add theme settings') : lang('edit theme settings'))
  ));
  add_stylesheet_to_page('project/files.css');
  add_stylesheet_to_page('project/theme_settings.css'); 
?>
	
<?php if ($project_theme_setting->isNew()) { ?>
	<form action="<?php echo get_url('theme_settings', 'add_theme_setting') ?>" method="post" id="themeoptions">
<?php } else { ?>
	<form action="<?php echo $project_theme_setting->getEditUrl() ?>" method="post" id="themeoptions">
<?php } // if?>

<?php tpl_display(get_template_path('form_errors')) ?>

	<?php $options = unserialize( array_var($project_theme_setting_data, 'options') ); // var_dump($options);?>

	<input name="project_theme_setting[title]" id="projectFormTitle" type="hidden" value="<?php echo lang('theme_emeraldcurtain'); ?>"/>

	<!-- FAVICON -->
	<div class="option_field">
    	<label><?php echo lang('favicon'); ?>:</label>
        <input name="raw_settings[favicon]" type="text" value="<?php echo $options['favicon']; ?>" size="60" />
        <?php echo lang('url'); ?>
	</div>   
    
    <!-- PROJECT TITLE -->
    <div class="option_field trigger title_position" field_name="title_position">	 
    	<label><?php echo lang('title position'); ?>:</label>
         <ul>   
	    	<li field_value="top_left" class="<?php echo is_current( $options['title_position'], 'top_left' ) . '">' . lang('top left'); ?></li> 
	    	<li field_value="centered" class="<?php echo is_current( $options['title_position'], 'centered' ) . '">' . lang('centered'); ?></li>
	    	<li field_value="none" class="<?php echo is_current( $options['title_position'], 'none' ) . '">' . lang('none'); ?></li>
        </ul>
        <input name="raw_settings[title_position]" type="hidden" id="raw_title_position" value="<?php echo $options['title_position']; ?>" />
	</div>
    
    <!-- PROJECT TITLE:  TOP LEFT -->    
    <div class="triggered triggered_title_position_top_left  <?php echo is_current( $options['title_position'], 'top_left'); ?>">   
		<div class="option_field">
    		<p><?php echo lang('title top left description'); ?></p>
		</div>        
	</div> 
    
    <!-- PROJECT TITLE:  CENTERED IN HEADER -->    
    <div class="triggered triggered_title_position_centered  <?php echo is_current( $options['title_position'], 'centered'); ?>">    
    	<div class="option_field title_text_color" field_name="title_text_color">
    		<p><?php echo lang('title centered description'); ?></p>
            <label><?php echo lang('text color'); ?>:</label>
        	<ul>
        		<li field_value="dark" class="<?php echo is_current( $options['title_text_color'], 'dark'); ?>"><?php echo lang('dark'); ?></li>
            	<li field_value="light" class="<?php echo is_current( $options['title_text_color'], 'light'); ?>"><?php echo lang('light'); ?></li>        
			</ul>
       		<input name="raw_settings[title_text_color]" id="raw_title_text_color" type="hidden" value="<?php echo $options['title_text_color']; ?>" />    
		</div> 
        
        <div class="option_field">        
        	<label><?php echo lang('background opacity'); ?>:</label>
    		<input name="raw_settings[title_background_opacity]" type="title_background_opacity" value="<?php echo $options['title_background_opacity']; ?>" size="3" />
            <?php echo lang('opacity text'); ?>
		</div>        
	</div> 
    
    
    <!-- PROJECT TITLE:  NONE -->    
    <div class="triggered triggered_title_position_none  <?php echo is_current( $options['title_position'], 'none'); ?>">   
		<div class="option_field">
    		<p><?php echo lang('title none description'); ?></p>
		</div>        
	</div> 
    
    <!-- USERBOX -->
    <div class="option_field trigger userbox" field_name="userbox">	
    	<label><?php echo lang('userbox'); ?>:</label>
        <ul>
	    	<li field_value="default" class="<?php echo is_current( $options['userbox'], 'default'); ?>"><?php echo lang('default'); ?></li>
	    	<li field_value="image" class="<?php echo is_current( $options['userbox'], 'image'); ?>"><?php echo lang('image'); ?></li>
	    	<li field_value="none" class=" <?php echo is_current( $options['userbox'], 'none' ) . '">' . lang('none'); ?></li>
        </ul>
        <input name="raw_settings[userbox]" type="hidden" id="raw_userbox" value="<?php echo $options['userbox']; ?>" />
	</div>
    
    <!-- USERBOX:  PLUGIN IMAGE -->    
    <div class="triggered triggered_userbox_image  <?php echo is_current( $options['userbox'], 'image'); ?>">    
    	 <div class="option_field userbox_text_color" field_name="userbox_text_color">
            <label><?php echo lang('text color'); ?>:</label>
        	<ul>
        		<li field_value="dark" class="<?php echo is_current( $options['userbox_text_color'], 'dark'); ?>"><?php echo lang('dark'); ?></li>
            	<li field_value="light" class="<?php echo is_current( $options['userbox_text_color'], 'light'); ?>"><?php echo lang('light'); ?></li>        
			</ul>
       		<input name="raw_settings[userbox_text_color]" id="raw_userbox_text_color" type="hidden" value="<?php echo $options['userbox_text_color']; ?>" />    
		</div>      
        
        <div class="option_field userbox_image" field_name="userbox_image">
        	<?php print_image_choices ('application/plugins/theme_settings/images/bars/', $options['userbox_image']); ?>
        	
       		<input name="raw_settings[userbox_image]" id="raw_userbox_image" type="hidden" value="<?php echo $options['userbox_image']; ?>" />    
		</div>       
	</div> 
    <!-- USERBOX:  NONE -->    
    <div class="triggered triggered_userbox_none  <?php echo is_current( $options['userbox'], 'none'); ?>">   
		<div class="option_field">
    		<p><?php echo lang('userbox none description'); ?></p>
		</div>        
	</div> 
    
    <!-- HEADER -->
    <div class="option_field trigger header" field_name="header">	
    	<label><?php echo lang('header image'); ?>:</label>
        <ul>
	    	<li field_value="default" class="<?php echo is_current( $options['header'], 'default'); ?>"><?php echo lang('default'); ?></li>
	    	<li field_value="plugin_image" class="<?php echo is_current( $options['header'], 'plugin_image'); ?>"><?php echo lang('plugin image'); ?></li>
	    	<li field_value="gradient" class="<?php echo is_current( $options['header'], 'gradient'); ?>"><?php echo lang('gradient'); ?></li>
	    	<li field_value="custom_image" class="<?php echo is_current( $options['header'], 'custom_image'); ?>"><?php echo lang('custom image'); ?></li>
	    	<li field_value="none" class="<?php echo is_current( $options['header'], 'none'); ?>"><?php echo lang('none'); ?></li>
        </ul>
        <input name="raw_settings[header]" type="hidden" id="raw_header" value="<?php echo $options['header']; ?>" />
	</div>
    
    <!-- HEADER:  PLUGIN IMAGE -->    
    <div class="triggered triggered_header_plugin_image  <?php echo is_current( $options['header'], 'plugin_image'); ?>">    
    	<div class="option_field header_plugin_image" field_name="header_plugin_image">
        	<?php print_image_choices ('application/plugins/theme_settings/images/headers/', $options['header_plugin_image']); ?>
       		<input name="raw_settings[header_plugin_image]" id="raw_header_plugin_image" type="hidden" value="<?php echo $options['header_plugin_image']; ?>" />    
		</div> 
	</div> 
    
    <!-- HEADER:  GRADIENT -->    
    <div class="triggered triggered_header_gradient  <?php echo is_current( $options['header'], 'gradient'); ?>"> 
		<div class="option_field">
			<label><?php echo lang('top color'); ?></label> 
            #<input name="raw_settings[header_color_top]" type="text" size="8" value="<?php echo $options['header_color_top']; ?>" />; 
		</div>
                    
       	<div class="option_field">
			<label><?php echo lang('bottom color'); ?></label> 
            #<input name="raw_settings[header_color_bottom]" type="text" size="8" value="<?php echo $options['header_color_bottom']; ?>" />;    
		</div>            
	</div>
    
    <!-- HEADER:  CUSTOM IMAGE -->    
    <div class="triggered triggered_header_custom_image  <?php echo is_current( $options['header'], 'custom_image'); ?>"> 
		<div class="option_field">
    		<label><?php echo lang('custom image url'); ?>:</label>
            <input name="raw_settings[header_custom_image]" type="text" value="<?php echo $options['header_custom_image']; ?>" size="60" />
		</div>  
	</div> 
    
    <!-- HEADER:  NONE -->    
    <div class="triggered triggered_header_none <?php echo is_current( $options['header'], 'none'); ?>"> 
		<div class="option_field">
    		<p><?php echo lang('header none description'); ?></p>
		</div>  
	</div> 
    
    
    <!-- HEADER HEIGHT -->
	<div class="option_field">
    	<label><?php echo lang('header height'); ?>:</label>
        <input name="raw_settings[header_height]" type="text" value="<?php echo $options['header_height']; ?>" size="5" />
        <?php echo lang('header height pixels'); ?>
	</div>   
    
    
    <!-- NAVIGATION -->
    <div class="option_field trigger navigation" field_name="navigation">	
    	<label><?php echo lang('navigation'); ?>:</label>
        <ul>
	    	<li field_value="default" class="<?php echo is_current( $options['navigation'], 'default'); ?>"><?php echo lang('default'); ?></li>
	    	<li field_value="image" class="<?php echo is_current( $options['navigation'], 'image'); ?>"><?php echo lang('image'); ?></li>
        </ul>
        <input name="raw_settings[navigation]" type="hidden" id="raw_navigation" value="<?php echo $options['navigation']; ?>" />
	</div>
    
    <!-- NAVIGATION:  PLUGIN IMAGE -->    
    <div class="triggered triggered_navigation_image  <?php echo is_current( $options['navigation'], 'image'); ?>">    
    	 <div class="option_field navigation_text_color" field_name="navigation_text_color">
            <label><?php echo lang('text color'); ?>:</label>
        	<ul>
        		<li field_value="dark" class="<?php echo is_current( $options['navigation_text_color'], 'dark'); ?>"><?php echo lang('dark'); ?></li>
            	<li field_value="light" class="<?php echo is_current( $options['navigation_text_color'], 'light'); ?>"><?php echo lang('light'); ?></li>        
			</ul>
       		<input name="raw_settings[navigation_text_color]" id="raw_navigation_text_color" type="hidden" value="<?php echo $options['navigation_text_color']; ?>" />    
		</div>      
        
        <div class="option_field navigation_image" field_name="navigation_image">
        	<?php print_image_choices ('application/plugins/theme_settings/images/bars/', $options['navigation_image']); ?>
        	
       		<input name="raw_settings[navigation_image]" id="raw_navigation_image" type="hidden" value="<?php echo $options['navigation_image']; ?>" />    
		</div>       
	</div> 
    <!-- BODY -->
    <div class="option_field trigger body" field_name="body">	
    	<label><?php echo lang('body background'); ?>:</label>
        <ul>
	    	<li field_value="default" class="<?php echo is_current( $options['body'], 'default'); ?>"><?php echo lang('default'); ?></li>
	    	<li field_value="plugin_image" class="<?php echo is_current( $options['body'], 'plugin_image'); ?>"><?php echo lang('plugin image'); ?></li>
	    	<li field_value="gradient" class="<?php echo is_current( $options['body'], 'gradient'); ?>"><?php echo lang('gradient'); ?></li>
	    	<li field_value="custom_image" class="<?php echo is_current( $options['body'], 'custom_image'); ?>"><?php echo lang('custom image'); ?></li>
	    	<li field_value="none" class="<?php echo is_current( $options['body'], 'none'); ?>"><?php echo lang('none'); ?></li>
        </ul>
        <input name="raw_settings[body]" type="hidden" id="raw_body" value="<?php echo $options['body']; ?>" />
	</div>
    
    <!-- BODY:  PLUGIN IMAGE -->    
    <div class="triggered triggered_body_plugin_image  <?php echo is_current( $options['body'], 'plugin_image'); ?>">    
    	<div class="option_field body_plugin_image" field_name="body_plugin_image">
        	<?php print_image_choices ('application/plugins/theme_settings/images/backgrounds/', $options['body_plugin_image']); ?>
       		<input name="raw_settings[body_plugin_image]" id="raw_body_plugin_image" type="text" value="<?php echo $options['body_plugin_image']; ?>" />    
		</div> 
	</div> 
    
    <!-- BODY:  GRADIENT -->    
    <div class="triggered triggered_body_gradient  <?php echo is_current( $options['body'], 'gradient'); ?>"> 
		<div class="option_field">
			<label><?php echo lang('top color'); ?></label> 
            #<input name="raw_settings[body_color_top]" type="text" size="8" value="<?php echo $options['body_color_top']; ?>" />; 
		</div>
                    
       	<div class="option_field">
			<label><?php echo lang('bottom color'); ?></label> 
            #<input name="raw_settings[body_color_bottom]" type="text" size="8" value="<?php echo $options['body_color_bottom']; ?>" />;    
		</div>            
	</div>
    
    <!-- BODY:  CUSTOM IMAGE -->    
    <div class="triggered triggered_body_custom_image  <?php echo is_current( $options['body'], 'custom_image'); ?>"> 
		<div class="option_field">
    		<label><?php echo lang('custom image url'); ?>:</label>
            <input name="raw_settings[body_custom_image]" type="text" value="<?php echo $options['body_custom_image']; ?>" size="60" />
		</div>  
	</div> 
    
    <!-- BODY:  NONE -->    
    <div class="triggered triggered_body_none <?php echo is_current( $options['body'], 'none'); ?>"> 
		<div class="option_field">
    		<p><?php echo lang('body none description'); ?></p>
		</div>  
	</div> 
    
    <!-- CUSTOM CSS -->
    <div class="option_field trigger custom_css" field_name="custom_css">	
    	<label><?php echo lang('custom css'); ?>:</label>
        <ul>
	    	<li field_value="no" class="<?php echo is_current( $options['custom_css'], 'no'); ?>"><?php echo lang('no'); ?></li>
	    	<li field_value="yes" class="<?php echo is_current( $options['custom_css'], 'yes'); ?>"><?php echo lang('yes'); ?></li>
        </ul>
        <input name="raw_settings[custom_css]" type="hidden" id="raw_custom_css" value="<?php echo $options['custom_css']; ?>" />
	</div>
    
    <!-- CUSTOM CSS:  YES -->    
    <div class="triggered triggered_custom_css_yes  <?php echo is_current( $options['custom_css'], 'yes'); ?>">    
    	<p><?php echo lang('custom css warning'); ?></p>	           
        <textarea name="raw_settings[custom_css_content]" cols="80" rows="2"><?php echo $options['custom_css_content']; ?></textarea>       
	</div> 
    
    
    <!-- SUBMIT -->  
    <div class="option_field">
           <label>&nbsp;</label>                       
			<?php echo submit_button($project_theme_setting->isNew() ? lang('save theme settings') : lang('save theme settings')) ?>
	</div>
   
    
</form>
<?php
     
    function is_current ( $field, $value ) {
    	if ($field == $value) return 'current';
    }

	function print_image_choices( $dir, $current='') {
		$images = glob($dir . "*-th.*");
		foreach($images as $image) {
			$fullsize = substr($image,0,strlen($image)-7).substr($image,-4);
			echo '<img src="'.$image.'" fullsize="'.$fullsize.'" '.($current==$fullsize ? ' class="current"' : '') . '/>';
		}
		echo '<br clear="both">';
	}

	
?>

    
<script language="javascript">

	// JAVASCRIPT 
	// 		cannot use add_inline_javascript_to_page because it needs a string, so the js loses readability 
	//		cannot use add_javascript_to_page because it uses a different path than the current plugin directory 
	
	jQuery(document).ready(function($) {
	
	// When a TRIGGER button is pressed, hide all triggered DIV's and show the indicated one
	$('form#themeoptions .trigger li').click(function(event) {
				
		var triggered = $('.triggered_' + $(this).parent().parent().attr('field_name') + '_' + $(this).attr('field_value'));
		if ( triggered.is(":visible") ) {
			triggered.slideUp('fast');
		} else {
			triggered.slideDown('fast');
		}
		
		$('.triggered').not(triggered).slideUp('fast');

	});		
			
	// When an OPTION is selected, set the linked field to its value and mark it current			
	$('form#themeoptions ul li').click(function(event) {
	
		var field_name = $(this).parent().parent().attr('field_name');
				
		$( '.'+field_name+' ul li').removeClass('current');
		$(this).addClass('current');
		$('#raw_'+field_name).val( $(this).attr('field_value') );
		
				
	});		

	// When an option IMAGE is selected, set the linked field to its value and mark it current 	
	$('form#themeoptions .option_field img').click(function(event) {
				
		var field_name = $(this).parent().attr('field_name');
		$('form#themeoptions  .'+field_name+' img').removeClass('current');
		$(this).addClass('current');
		$('#raw_'+field_name).val( $(this).attr('fullsize') );
		
				
	});		
		
});
</script>