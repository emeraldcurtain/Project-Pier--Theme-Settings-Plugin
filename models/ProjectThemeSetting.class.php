<?php

  /**
  * ProjectThemeSetting class
  *
  * @http://www.activeingredient.com.au
  */
  class ProjectThemeSetting extends BaseProjectThemeSetting {
    
    function getProject() {
      if (is_null($this->project)) {
        $this->project = Projects::findById($this->getProjectId());
      } 
      return $this->project;
    } 
    
    function canAdd(User $user, Project $project) { 
		return $user->isAdministrator() || $user->isMemberOfOwnerCompany();    
	}

    function canEdit(User $user) {      			
		return $user->isAdministrator() || $user->isMemberOfOwnerCompany();    
	}
	
    function canDelete(User $user) {      			
		return $user->isAdministrator() || $user->isMemberOfOwnerCompany();    
	}
    
    function canView(User $user) {
      if ($user->isAdministrator() || $user->isMemberOfOwnerCompany()) return true;
      if ($user->isProjectUser($this->getProject())) return true;
      return false;
    } 
    
    function getEditUrl() { 
		return get_url('theme_settings', 'edit_theme_setting', array('id' => $this->getId(), 'active_project' => active_project()->getId()));    
	} 
	
    function getDeleteUrl() { 
		return get_url('theme_settings', 'delete_theme_setting', array('id' => $this->getId(), 'active_project' => active_project()->getId())); 
	} 
    
	
    function getObjectName() { 
		return $this->getTitle();  
	}
	
    function getObjectTypeName() { 
		return lang('theme settings'); 
	} 
    
	// ---
	//
	// ---
	function printThemeSettings () {
	
		if ($str = $this->getCss()) {
			// add_inline_css_to_page('body{color:#AAAAAA;}'.$str);
			echo '<style>'.$str.'</style>';
		}
	
		if ($str = $this->getFavicon()) {
			echo $str;
		}
	}
	// ---
	// SET option_value STRING USING SUBMITTED POST DATA
	//
	// Create an array using the $_POST fields, and then serialize that into option_string
	// This function assumes certain defaults from the parent theme EmeraldCurtain.
	//		-- title position is centered, title text is dark, title background is transparent
	//		-- navigation image is default dark blue, text is white
	// ---
	function setTableFieldsFromPostData() {
	
		$options = $_POST['raw_settings'];
		$this->setOptions( serialize ($options) );
		
		$css = '';
		
		// ---
		// FAVICON
		// ---
		if ($options['favicon']) {
			$this->setFavicon(  '<link rel="shortcut icon" href="'.$options['favicon'].'" type="image/x-icon" />' );
		}
		
		
		// ---
		// USERBOX
		// ---
		switch ($options['userbox']) {
			case 'image':
				$css .= '#userboxWrapper {background: url('.$options['userbox_image'].');}';
				break;
			case 'none':
				$css .= '#userboxWrapper {display:none;}';
				break;
		}
		switch ($options['userbox_text_color']) {
			case 'dark':
				$text_color = '#111;';
				$css .= '#account_more_menu > li > a {color: #111;}';
				
				break;
			case 'light':
				$text_color = '#fff;';
				$css .= '#account_more_menu > li > a {color: #fff;}';
				break;
			default:
				$text_color = '#fff;';							
		}	
			
		// ---
		// NAVIGATION
		// ---
		if ('image'==$options['navigation']) {
			$css .= '#tabs {background: url('.$options['navigation_image'].');}';
		}
		switch ($options['navigation_text_color']) {
			case 'dark':
				$css .= '#tabs ul li a {color:#111}';
				break;
			case 'light':
				$css .= '#tabs ul li a {color:#fff}';
				break;	
				
		}		
		
		// ---
		// TITLE
		// ---
		switch ($options['title_position']) {
			case 'none':
				$css .= '#header { text-align:left;}
					#header h1, #header h2 { display:none;}';
				break;
			case 'top_left':
				$css .= '#header   { text-align:left;}
					#header h1, #header h2 { width:auto; color:'.$text_color.';z-index:9999;border: 0;margin: 0; float:left; padding: 0 0 0 7px;max-width: 540px; position:relative;font-size: 18px; line-height:32px; text-align:left;}
					#header h1 a,#header h1 a:first-child ,#header h2 a {color:'.$text_color.';text-shadow:none; font: normal 18px/18px  myriad_pro_bold_condensed, Geneva, Arial, Helvetica, sans-serif;font-variant:normal; display:inline; text-transform:none;  letter-spacing:normal; }
					#header h2:before{content:" | ";}';

				break;
			case 'centered':
				if ('light'==$options['title_text_color']) {
					$css .= '#header h1 a,#header h1 a:first-child,#header h2 a  {color:#FFF;text-shadow: 0 0 2px #000;}';
					$css .= '#header h1 { background-color: rgba(0, 0, 0, '.$options['title_background_opacity'].');}';
					$css .= '#header h2 { background-color: rgba(0, 0, 0, '.$options['title_background_opacity'].');}';
				} else if ($options['title_background_opacity']) {
					$css .= '#header h1 { background-color: rgba(255, 255, 255, '.$options['title_background_opacity'].');text-shadow: 0 0 4px #fff;;}';
					$css .= '#header h2 { background-color: rgba(255, 255, 255, '.$options['title_background_opacity'].');text-shadow: 0 0 4px #fff;;}';
				}
				break;
		}		
		
				
		// ---
		// BODY
		// ---
		$css .= 'body  {';
		
		switch ($options['body']) {
			case 'plugin_image':
				$css .=  'background:url('.$options['body_plugin_image'].') top center fixed repeat-x ;';
				break;
			case 'gradient':
				$c1 = $options['body_color_top'];
				$c2 = $options['body_color_bottom'];
				$css .= 'background: #'.$c1.'; 
				background: -moz-linear-gradient(top, #'.$c1.' 0%, #'.$c2.' 100%); 
				background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#'.$c1.'), color-stop(100%,#'.$c2.')); 
				background: -webkit-linear-gradient(top, #'.$c1.' 0%,#'.$c2.' 100%); 
				background: -o-linear-gradient(top, #'.$c1.' 0%,#'.$c2.' 100%); 
				background: -ms-linear-gradient(top, #'.$c1.' 0%,#'.$c2.' 100%); 
				background: linear-gradient(top, #'.$c1.',#'.$c2.' 100%); 
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#'.$c1.'", endColorstr="#'.$c2.'",GradientType=0 );';
				break;
			case 'custom_image':
				$css .=  'background:url('.$options['body_custom_image'].') top center repeat-x fixed;';
				break;
			case 'none':
				break;
	 	}
		
		$css .= '}';
		
		if ('none'==$options['body']) {
			$css .= '#wrapper{background:none;}
			#header,#userboxWrapper,#tabs,#crumbsBlock,#page_actionsBlock,#innerContentWrapper{width:100%;}
			body {margin:0;padding:0;border:0;width:100%;background:none;min-width:600px;}
			#outerContentWrapper {position:relative;clear:both;float:left;width:100%;overflow:hidden;background:#fff; margin:0;}
			#innerContentWrapper {float:left;width:100%;position:relative;right:25%;background:#fff; margin:0;}
			#content {width:71%;left:27%;float:left;position:relative;padding:0 0 1em 0;overflow:hidden; margin:0;}
			#sidebar {width:21%;left:31%;float:left;position:relative;padding:0 0 1em 0;overflow:hidden; margin:0;}
			#footer,div.projectLog table,.timeLogs,#systemNotices,table.applicationLogs,#innerContentWrapper #success, #innerContentWrapper #error { width:100%;}
			.logProjectHeader { right:0; margin-left:auto; }
			#account_more_menu ul { auto; }
			#pageTitle{width: 71%;left: 27%;float: left;position: relative;}
			';
		}
		?>
        <?php
		
		
		// ---
		// HEADER
		// ---
		$css .= '#header { ';
		$header_height = $options['header_height'];

		switch ($options['header']) {
			case 'plugin_image':
				$css .=  'background:url('.$options['header_plugin_image'].') no-repeat top center;';
				break;
			case 'gradient':
				$c1 = $options['header_color_top'];
				$c2 = $options['header_color_bottom'];
				$css .= '
				background: #'.$c1.'; /* Old browsers */
				background: -moz-linear-gradient(top, #'.$c1.' 0%, #'.$c2.' 100%); 
				background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#'.$c1.'), color-stop(100%,#'.$c2.')); 
				background: -webkit-linear-gradient(top, #'.$c1.' 0%,#'.$c2.' 100%);
				background: -o-linear-gradient(top, #'.$c1.' 0%,#'.$c2.' 100%);
				background: -ms-linear-gradient(top, #'.$c1.' 0%,#'.$c2.' 100%); 
				background: linear-gradient(top, #'.$c1.',#'.$c2.' 100%);
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#'.$c1.'", endColorstr="#'.$c2.'",GradientType=0 );';
				break;
			case 'custom_image':
				$css .= 'background:url('.$options['header_custom_image'].') 0 32px no-repeat;';
				break;
			case 'none':
				$css .=  'background:none;';
				break;
		}
		$css .=  '}';
		
		if ($header_height) $css .= '#header { height: '.($header_height+32).'px; }';
		
		
		$navigation = $options['navigation'];
		if ('light'==$navigation) { 
			$css .= '#header{ border-top:40px solid #fff;}#header h1 { color:#aaa;}#header h1 a { color:#888;}#header h1 a:hover { color:#333;}
			#account_more_menu > li {background: #fff;}#account_more_menu > li > a {color: #000;}
#tabs ul li a { background:#fff; color:#777; }#tabs ul li.active a { background:#ddd; }#tabs ul li a:hover{background-color:#bbb; }#crumbsBlock { background:#ddd; }';
		}
		
		if ('yes'==$options['custom_css']) { 
			$css .= $options['custom_css_content'];
		}
		
		
		$this->setCss( $css );
		return true;
	}
	
	
  
	// ---
	//
	// ---
  	function print_preview() {
	
		$options = unserialize ($this->getOptions());
		
		?>
        <div id="themeoptions">
        
        	<?php if ($str = $options['favicon']) { // Using = instead of == to initialize $str ?>        
	        	<div class="option_field">
                	<label><?php echo lang('favicon'); ?>:</label>
                    <img src="<?php echo $str; ?>" width="16" /><br />
    	        </div>
        	<?php } ?>
            
        	<?php if ($options['title_position']) { ?>   
	        	<div class="option_field">
                	<label><?php echo lang('title position'); ?>:</label>
                    <?php echo $options['title_position']; ?>
    	        </div>
        	<?php } ?>
             
        	<?php if ('image' == $options['navigation']) { ?>  
	        	<div class="option_field">
               		<label><?php echo lang('navigation'); ?>:</label>
	           		<img src="<?php echo $options['navigation_image']; ?>" width="160" height="32" />
    	   		</div>
            <?php } ?>
            
        	<?php if ($options['header_height']) { ?>   
	        	<div class="option_field">
                	<label><?php echo lang('header height'); ?>:</label>
                    <?php echo $options['header_height']; ?>
    	        </div>
        	<?php } ?>
             
        	<div class="option_field">
           		<label><?php echo lang('header'); ?>:</label>
				<?php 
					switch ($options['header']) { 
	                	case 'plugin_image': 
							?><img src="<?php echo $options['header_plugin_image'];?>"  width="160" height="50" /><?php 
							break;
						case 'gradient':
							$c1 = $options['header_color_top'];
							$c2 = $options['header_color_bottom'];
							?><div style="border:1px solid #777; height:50px; width:160px;" class="header-preview"></div><style>
								.header-preview {display:inline-block;
								background: #<?php echo $c1; ?>; 
								background: -moz-linear-gradient(top, #<?php echo $c1; ?> 0%, #<?php echo $c2; ?> 100%); 
								background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#<?php echo $c1; ?>), color-stop(100%,#<?php echo $c2; ?>)); 
								background: -webkit-linear-gradient(top, #<?php echo $c1; ?> 0%,#<?php echo $c2; ?> 100%); 
								background: -o-linear-gradient(top, #<?php echo $c1; ?> 0%,#<?php echo $c2; ?> 100%); 
								background: -ms-linear-gradient(top, #<?php echo $c1; ?> 0%,#<?php echo $c2; ?> 100%); 
								background: linear-gradient(top, #<?php echo $c1; ?>,#<?php echo $c2; ?> 100%); 
								filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $c1; ?>', endColorstr='#<?php echo $c2; ?>',GradientType=0 ); 
								}</style><?php
							break;
						case 'custom_image':
							echo '<img src="'.$options['header_custom_image'].'" width="160"  height="50"/>';
							break;
						case 'none':
							echo lang('none');
							break;
						default:
							echo lang('default');

                	} 
				?>
   	   		</div>
            
        	<div class="option_field">
           		<label><?php echo lang('body'); ?>:</label>
				<?php 
					switch ($options['body']) {
						case 'plugin_image':
							echo '<img src="'.$options['body_plugin_image'].'" width="160" height="50"  />';
							break;
						case 'gradient':
							$c1 = $options['body_color_top'];
							$c2 = $options['body_color_bottom'];
							?><div style="border:1px solid #777; height:50px; width:160px;" class="body-preview"></div><style>
							.body-preview { display:inline-block;
							background: #<?php echo $c1; ?>; 
							background: -moz-linear-gradient(top, #<?php echo $c1; ?> 0%, #<?php echo $c2; ?> 100%); 
							background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#<?php echo $c1; ?>), color-stop(100%,#<?php echo $c2; ?>)); 
							background: -webkit-linear-gradient(top, #<?php echo $c1; ?> 0%,#<?php echo $c2; ?> 100%); 
							background: -o-linear-gradient(top, #<?php echo $c1; ?> 0%,#<?php echo $c2; ?> 100%); 
							background: -ms-linear-gradient(top, #<?php echo $c1; ?> 0%,#<?php echo $c2; ?> 100%); 
							background: linear-gradient(top, #<?php echo $c1; ?>,#<?php echo $c2; ?> 100%); 
							filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#<?php echo $c1; ?>', endColorstr='#<?php echo $c2; ?>',GradientType=0 ); 
							}</style><?php
							break;
						case 'custom_image':
							echo '<img src="'.$options['body_custom_image'].'" width="160" height="50"  />';
							break;
						case 'none':
							echo lang('none');
							break;
						default:
							echo lang('default');
				 	}
				?>
   	   		</div>
            
        	<?php if ($options['custom_css']) { ?>   
	        	<div class="option_field">
                	<label><?php echo lang('custom css'); ?>:</label>
                    <?php echo $options['custom_css']; ?>
    	        </div>
        	<?php } ?>
            
			<?php if ($this->getCreatedBy() instanceof User) { ?>
        		<div class="option_field">
        	    	<label><?php echo lang('created by') ?>:</label> 
        	        <a href="<?php echo $this->getCreatedBy()->getCardUrl() ?>"><?php echo clean($this->getCreatedBy()->getDisplayName()) ?></a> 
				</div>
			<?php } ?>
   	   		
                
        </div>
        <?php 
	}
  
  } // ProjectThemeSetting 

?>
