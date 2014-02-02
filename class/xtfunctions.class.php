<?php
// $Id: xtfunctions.class.php 172 2012-12-13 06:17:41Z i.bitcero $
// --------------------------------------------------------------
// xThemes for XOOPS
// Module for manage themes by Red Mexico
// Author: Eduardo Cortés <i.bitcero@gmail.com>
// License: GPL v2
// --------------------------------------------------------------

class XtFunctions
{
    public function toolbar(){
        RMTemplate::get()->add_tool(__('Dashboard', 'xthemes'), 'index.php', 'images/dashboard.png', 'dashboard');
        RMTemplate::get()->add_tool(__('Available Themes', 'xthemes'), 'themes.php', 'images/themes.png', 'catalog');
        RMTemplate::get()->add_tool(__('Theme Settings', 'xthemes'), 'settings.php', 'images/settings.png', 'settings');
        RMTemplate::get()->add_tool(__('About', 'xthemes'), 'index.php?action=about', 'images/about.png', 'about');
        $events = RMEvents::get();
        $events->run_event('xthemes.toolbar');
    }
    
    /**
    * @deprecated
    */
    public function menu_options(){
        $this->toolbar();
    }
    
    /**
    * Get the current theme and all related information
    * return object
    */
    public function current_theme(){
        global $xoopsConfig;
        
        // Configured theme
        $ctheme = $xoopsConfig['theme_set'];
        
        // Check if theme is a valid xTheme or not
        $theme = $this->load_theme($ctheme); 
        
        return $theme;
        
    }
    
    /**
    * Load a specified theme
    * return object
    */
    public function load_theme($dir){
        
        if($dir=='') return false;
        
        $fulldir = XOOPS_THEME_PATH.'/'.$dir;
        if(!is_dir($fulldir)) return false;
        
        $theme_file = $fulldir.'/assemble/'.$dir.'.theme.php';
        
        if(is_file($theme_file)){
            include_once $theme_file;
            $class = ucfirst($dir);
            $theme = new $class();
            return $theme;
        }
        
        $theme = new StandardTheme();
        $theme->set_dir($dir);
        return $theme;
        
    }
    
    /**
    * Insert configuration options
    * @param array with sections and options
    * @return bool
    */
    public function insertOptions($theme, $set = null){
        
        if($theme==null) return false;
        $options = $theme->options();
        
        if(empty($options)) return true;
        
        $db = XoopsDatabaseFactory::getDatabaseConnection();
        // Current settings
        $current = $theme->settings();
        $count = count($current);
        
        $sql = "INSERT INTO ".$db->prefix("xt_options")." (`theme`,`name`,`value`,`type`) VALUES ";
        $sqlu = "UPDATE ".$db->prefix("xt_options")." SET `value`=";
        
        foreach($options['options'] as $name => $option){
            if($count<=0){
                $value = isset($set[$name]) ? $set[$name] : $option['default'];
                $value = $option['type']=='array' ? serialize($value) : TextCleaner::getInstance()->addslashes($value);
                $values[] = "(".$theme->id().",'$name','$value','$option[content]')";
            }else {
                if($set && isset($current[$name]) && isset($set[$name])){
                    // Update single option
                    $value = $option['content']=='array' ? serialize($set[$name]) : TextCleaner::getInstance()->addslashes($set[$name]);
                    $sqlt = $sqlu . "'$value', `type`='$option[content]' WHERE name='$name' AND theme='".$theme->id()."'";
                    $db->queryF($sqlt);
                }else{
                    $value = isset($set[$name]) ? $set[$name] : $option['content'];
                    $value = $option['type']=='array' ? serialize($value) : TextCleaner::getInstance()->addslashes($value);
                    $values[] = "(".$theme->id().",'$name','$value','$option[content]')";
                }
            }

        }
        
        if(!empty($values))
            $sql .= implode(",",$values); 
        else
            return true;

        return $db->queryF($sql);
        
    }
    
    /**
    * Remove all theme data from database
    */
    public function purge_theme($theme){
        
        if(!$theme) return false;
        if(is_a($theme, 'StandardTheme')) return true;
        
        // Delete options
        $db = XoopsDatabaseFactory::getDatabaseConnection();
        $sql = "DELETE FROM ".$db->prefix("xt_options")." WHERE theme=".$theme->id();
        if(!$db->queryF($sql))
            return false;
        
        $sql = "DELETE FROM ".$db->prefix("xt_menus")." WHERE theme=".$theme->id();
        if(!$db->queryF($sql))
            return false;
        
        return $theme->delete();
        
    }
    
    /**
    * Forms the menu in menu manager based on <li>s
    * @param 
    */
    public function formAdminMenu($menu){
        if(empty($menu)) return false;
        
        $tpl = RMTemplate::get();

        foreach($menu as $m){
            include $tpl->get_template('xt_menu_manager.php', 'module', 'xthemes');
        }
    }
    
}
