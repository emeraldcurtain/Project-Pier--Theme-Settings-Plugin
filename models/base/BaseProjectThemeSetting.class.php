<?php

  /**
  * BaseProjectThemeSetting class
  *
  * @http://www.activeingredient.com.au
  */
  abstract class BaseProjectThemeSetting extends ProjectDataObject {
  
    /**
    * Return value of 'id' field
    *
    * @access public
    * @param void
    * @return integer 
    */
    function getObjectId() {
      return $this->getColumnValue('id');
    } // getObjectId()
    
    // -----------------------------------------------------
    //  Magic access method
    //  NB: this replaces the need for other setters/getters
    // -----------------------------------------------------
    function __call($method, $args) {
      if( preg_match('/(set|get)(_)?/', $method) ) {
        if(substr($method, 0, 3) == "get") {
          $col = substr(strtolower(preg_replace('([A-Z])', '_$0', $method)), 4);
          if( $col ) {
            return $this->getColumnValue($col);
          }
        } elseif(substr($method, 0, 3) == "set" && count($args)) {
          $col = substr(strtolower(preg_replace('([A-Z])', '_$0', $method)), 4);
          if( $col ) {
            return $this->setColumnValue($col, $args[0]);
          }
        }
      }
      // me no understand!
      return false;
    }
    
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return ProjectThemeSettings 
    */
    function manager() {
      if (!($this->manager instanceof ProjectThemeSettings)) {
        $this->manager = ProjectThemeSettings::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseProjectThemeSetting 

?>
