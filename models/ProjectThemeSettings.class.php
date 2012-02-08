<?php

  /**
  * ProjectThemeSettings
  *
  * @http://www.activeingredient.com.au
  */
  class ProjectThemeSettings extends BaseProjectThemeSettings {
  
    /**
    * Return array of all theme_settings for project
    *
    * @param Project
    * @return ProjectThemeSettings
    */
    static function getAllProjectThemeSettings(Project $project) {
      trace(__FILE__,'getAllProjectThemeSettings():begin');
      
      $conditions = array('`project_id` = ?', $project->getId());
      
      return self::findAll(array(
        'conditions' => $conditions,
         // 'order' => '`created_on` DESC',
      )); // findAll
      trace(__FILE__,'getAllProjectThemeSettings():end');
    } // getAllProjectThemeSettings

  } // ProjectThemeSettings 

?>
