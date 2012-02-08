<?php
  
  /**
  * All functions here are in the global scope so keep names unique by using
  *   the following pattern:
  *
  *   <name_of_plugin>_<pp_function_name>
  *   i.e. for the hook in 'add_dashboard_tab' use 'theme_settings_add_dashboard_tab'
  */
  
  // add project tab
	define('DASHBOARD_TAB_THEME_SETTINGS', 'theme_settings');
  define('PROJECT_TAB_THEME_SETTINGS', 'theme_settings');
  define('THEME_SETTINGS_EMERALD_CURTAIN', 'theme_emeraldcurtain');
  
	/**define ('OPTION_KEY_BODY', 'body');
	define ('OPTION_KEY_HEADER', 'header');
	define ('OPTION_KEY_CSS', 'css');
	
	define ('OPTION_VALUE_DEFAULT', 'default');
	define ('OPTION_VALUE_SELECTION', 'selection');
	define ('OPTION_VALUE_COLOR', 'color');
	define ('OPTION_VALUE_IMAGE', 'image'); */
 
  
 // add_action('add_dashboard_tab', 'theme_settings_add_dashboard_tab');
  function theme_settings_add_dashboard_tab() {
    	if (logged_user()->isAdministrator(owner_company())) { 
      		add_page_action(lang('theme settings'), get_url('theme_settings', 'dashboard'));
    	} // if 
    	//trace(__FILE__,'theme_settings_add_dashboard_tab()');
		//add_tabbed_navigation_item(new TabbedNavigationItem(
      	//DASHBOARD_TAB_THEME_SETTINGS,
      	//lang('my tickets'),
      	//get_url('tickets', 'my_tickets')
    	//));
  }
  // overview page  -- theme settings should be a project tab or in overview list, not both
  add_action('project_overview_page_actions','theme_settings_project_overview_page_actions');
  function theme_settings_project_overview_page_actions() {
	
    if (logged_user()->isAdministrator(owner_company())) { 
      	add_page_action(lang('theme settings'), get_url('theme_settings', 'index'));
    } // if 
  }

  // my tasks dropdown
  add_action('my_tasks_dropdown','theme_settings_my_tasks_dropdown');
  function theme_settings_my_tasks_dropdown() {
    if (logged_user()->isAdministrator(owner_company())) { 
	    echo '<li class="header"><a href="'.get_url('theme_settings', 'index').'">'.lang('theme settings').'</a></li>';
    } // if 
  }
  
  	//Filter
	add_filter('tabbed_navigation_items','theme_settings_tabbed_navigation_items');
 	function theme_settings_tabbed_navigation_items($str) {
		//echo 'active_project()='.active_project().'<br><br>'; 
		//var_dump(active_project());
		//exit;
		if (active_project()) {
			//echo '<br><br>'.active_project()->getName().'<br><br>';
			//var_dump(active_project());
			//exit;
	    	$theme_settings = ProjectThemeSettings::getAllProjectThemeSettings(active_project());
			
			if (isset($theme_settings) && is_array($theme_settings) && count($theme_settings)) { 
				global $has_printed_styles;
				if (!$has_printed_styles) {
					$has_printed_styles = true;
					$theme_setting = $theme_settings[0];
					$theme_setting->printThemeSettings();	
				}
	    	}
		}
		return $str;
  	}
  /**
  * If you need an activation routine run from the admin panel
  *   use the following pattern for the function:
  *
  *   <name_of_plugin>_activate
  *
  *  This is good for creation of database tables etc.
  */
  function theme_settings_activate() {
    $sql = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."project_theme_settings` (
        `id` int(10) unsigned NOT NULL auto_increment,
        `project_id` int(10) unsigned NOT NULL default '0',
        `title` varchar(100) default '',
  		`options` longtext NOT NULL,
  		`favicon` longtext NOT NULL,
  		`css` longtext NOT NULL,
        `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
        `created_by_id` int(10) unsigned default NULL,
        PRIMARY KEY  (`id`),
        KEY `created_on` (`created_on`),
        KEY `project_id` (`project_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=".DB_CHARSET."; ";
    // create table
    DB::execute($sql);
  }
  
  /**
  * If you need an de-activation routine run from the admin panel
  *   use the following pattern for the function:
  *
  *   <name_of_plugin>_deactivate
  *
  *  This is good for deletion of database tables etc.
  */
  function theme_settings_deactivate($purge=false) {
    // sample drop table
    if ($purge) {
      DB::execute("DROP TABLE IF EXISTS `".TABLE_PREFIX."project_theme_settings`");
    }
  }
