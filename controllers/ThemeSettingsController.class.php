<?php

  /**
  * ThemeSettings Controller
  *
  * @http://www.activeingredient.com.au
  */
  class ThemeSettingsController extends ApplicationController {
  
    /**
    * Construct the ThemeSettingsController
    *
    * @access public
    * @param void
    * @return ThemeSettingsController
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'project_website');
    } // __construct
    
    /**
    * Show theme_settings for project
    *
    * @access public
    * @param void
    * @return null
    */
    function dashboard() {
    //  trace(__FILE__,'index()');
     // $this->addHelper('textile');
     // $theme_settings = ProjectThemeSettings::getAllProjectThemeSettings(active_project());
    // tpl_assign('theme_settings', $theme_settings);
    } // index
	
    function index() {
      trace(__FILE__,'index()');
      $this->addHelper('textile');
      $theme_settings = ProjectThemeSettings::getAllProjectThemeSettings(active_project());
      tpl_assign('theme_settings', $theme_settings);
    } // index
    
    function add_theme_setting() {
      
      $this->setTemplate('edit_theme_setting');
      
      if (!ProjectThemeSetting::canAdd(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('theme_settings','index');
      } // if
      
      $project_theme_setting = new ProjectThemeSetting();
      $project_theme_setting_data = array_var($_POST, 'project_theme_setting');
      
      if (is_array(array_var($_POST, 'project_theme_setting'))) {
        $project_theme_setting->setFromAttributes($project_theme_setting_data);
        $project_theme_setting->setCreatedById(logged_user()->getId());
        $project_theme_setting->setProjectId(active_project()->getId());
		$project_theme_setting->setTableFieldsFromPostData();
        
        try {
          DB::beginWork();
          $project_theme_setting->save();
          ApplicationLogs::createLog($project_theme_setting, active_project(), ApplicationLogs::ACTION_ADD);
          DB::commit();
          
          flash_success(lang('success add theme settings'));
          $this->redirectTo('theme_settings');
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      }
      
      tpl_assign('project_theme_setting', $project_theme_setting);
      tpl_assign('project_theme_setting_data', $project_theme_setting_data);
    
    } // add_theme_setting
    
    /**
    * Edit project theme_setting
    *
    * @param void
    * @return null
    */
    function edit_theme_setting() {
      
      $this->setTemplate('edit_theme_setting');
      $project_theme_setting = ProjectThemeSettings::findById(get_id());
      
      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('theme_settings','index');
      } // if
      
      if (!($project_theme_setting instanceof ProjectThemeSetting)) {
        flash_error(lang('project theme settings dnx'));
        $this->redirectTo('theme_settings');
      } // if
      
      $project_theme_setting_data = array_var($_POST, 'project_theme_setting');
      
      if (!is_array($project_theme_setting_data)) {
        $project_theme_setting_data = array(
          'title'  			=> $project_theme_setting->getTitle(),
          'options'    		=> $project_theme_setting->getOptions(),
          'css'    			=> $project_theme_setting->getCSS(),
          'favicon'    		=> $project_theme_setting->getFavicon(),
        ); // array
		//var_dump($project_theme_setting_data);echo'<hr>';exit;
      } // if
      
      tpl_assign('project_theme_setting_data', $project_theme_setting_data);
      tpl_assign('project_theme_setting', $project_theme_setting);
      
      if (is_array(array_var($_POST, 'project_theme_setting'))) {
        $project_theme_setting->setFromAttributes($project_theme_setting_data);
        $project_theme_setting->setProjectId(active_project()->getId());
		$project_theme_setting->setTableFieldsFromPostData();
		
	
		//$project_theme_setting->setOptionValueFromFormData();
        
        try {
          DB::beginWork();
          $project_theme_setting->save();
          ApplicationLogs::createLog($project_theme_setting, active_project(), ApplicationLogs::ACTION_EDIT);
          DB::commit();
          
          flash_success(lang('success edit theme settings'));
          $this->redirectTo('theme_settings');
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      }
      tpl_assign('project_theme_setting', $project_theme_setting);
      tpl_assign('project_theme_setting_data', $project_theme_setting_data);
    } // edit_theme_setting
    
    /**
    * Delete project theme_setting
    *
    * @param void
    * @return null
    */
    function delete_theme_setting() {
      
      $project_theme_setting = ProjectThemeSettings::findById(get_id());
      
      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('theme_settings','index');
      } // if
      
      if (!($project_theme_setting instanceof ProjectThemeSetting)) {
        flash_error(lang('project theme settings dnx'));
        $this->redirectTo('theme_settings');
      } // if
      
      try {
        DB::beginWork();
        $project_theme_setting->delete();
        ApplicationLogs::createLog($project_theme_setting, active_project(), ApplicationLogs::ACTION_DELETE);
        DB::commit();
        
        flash_success(lang('success delete theme settings', $project_theme_setting->getTitle()));
        $this->redirectTo('theme_settings');
      } catch(Exception $e) {
        DB::rollback();
        tpl_assign('error', $e);
      } // try
      
    } // delete_theme_setting
    
  } // ThemeSettingsController

?>
