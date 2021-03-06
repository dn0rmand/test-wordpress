<?php
/*
@package: File Manager Advanced
@Class: fma_admin_menus
*/
if(class_exists('class_fma_admin_menus')) {
	return;
}
class class_fma_admin_menus {
	var $langs;
	/**
	 * AFM - Languages
	 */
	 public function __construct() {
             include('class_fma_lang.php');
			$this->langs = new class_fma_adv_lang();
	  }
	/**
	 * Loading Menus
	 */
	public function load_menus() {
		 add_menu_page(
			__( 'File Manager', 'file-manager-advanced' ),
			__( 'File Manager', 'file-manager-advanced' ),
			'manage_options',
			'file_manager_advanced_ui',
			array($this, 'file_manager_advanced_ui'),
			plugins_url( 'assets/icon/fma.png', __FILE__ ),
			4
			);
	add_submenu_page( 'file_manager_advanced_ui', 'Settings', 'Settings', 'manage_options', 'file_manager_advanced_controls', array(&$this, 'file_manager_advanced_controls'));
	add_submenu_page( 'file_manager_advanced_ui', 'Shortcodes', 'Shortcodes', 'manage_options', 'file_manager_advanced_shortcodes', array(&$this, 'file_manager_advanced_shortcodes'));
	}
	/**
	* Diaplying AFM
    */
     public function file_manager_advanced_ui() {
		 if(current_user_can('manage_options')) {
		    include('pages/main.php');
		 }
	 }
	/**
	* Settings
    */
    public function file_manager_advanced_controls(){
		if(current_user_can('manage_options')) {
		    include('pages/controls.php');
		 }
	}
	/**
	* Shortcode
    */
    public function file_manager_advanced_shortcodes(){
		if(current_user_can('manage_options')) {
		    include('pages/buy_shortcode.php');
		 }
	}
   /**
	* Saving Options
    */
    public function save() {
	   if(isset($_POST['submit']) && wp_verify_nonce( $_POST['_fmaform'], 'fmaform' )) {
		    _e('Saving Options, Please Wait...','file-manager-advanced');
		   $save = array();
		   $save['fma_theme'] = isset($_POST['fma_theme']) ? sanitize_text_field($_POST['fma_theme']) : 'light';
		   $save['fma_locale'] = isset($_POST['fma_locale']) ? sanitize_text_field($_POST['fma_locale']) : 'en';
		   $save['public_path'] = isset($_POST['public_path']) ? sanitize_text_field($_POST['public_path']) : '';
           $save['public_url'] = isset($_POST['public_url']) ? sanitize_text_field($_POST['public_url']) : '';
           $save['hide_path'] = isset($_POST['hide_path']) ? sanitize_text_field($_POST['hide_path']) : 0;
		   $save['enable_trash'] = isset($_POST['enable_trash']) ? sanitize_text_field($_POST['enable_trash']) : 0;
		   $save['enable_htaccess'] = isset($_POST['enable_htaccess']) ? sanitize_text_field($_POST['enable_htaccess']) : 0;		   
		  $u = update_option('fmaoptions',$save);
		  if($u) {
			  $this->f('?page=file_manager_advanced_controls&status=1');
		  } else {
			  $this->f('?page=file_manager_advanced_controls&status=2');
		  }
	   }
   }
   /**
	* Getting Options
    */
   public function get() {
	   return get_option('fmaoptions');
   }
   /**
	* Diplay Notices
    */
   public function notice($type, $message) {
	    if(isset($type) && !empty($type)) {
	     $class = ($type == '1') ? 'updated' : 'error';
         return '<div class="'.$class.' notice">
		  <p>'.$message.'</p>
		  </div>';
		}
   }
   /**
	* Redirection
    */
    public function f($u) {
		echo '<script>';
		echo 'window.location.href="'.$u.'"';
		echo '</script>';
	}
}