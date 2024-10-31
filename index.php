<?php 
/*
Plugin Name: PVN Auth Popup
Plugin URI: http://freebiesdownload.com/
Description: Wordpress custom authentication plugin. It Shows login, register and lost password form inn modal popup and process with ajax.
Author: Ravendra Patel
Version: 1.0.0
Author URI: http://freebiesdownload.com/
*/

include_once dirname(__FILE__) . '/inc/helper.inc.php';




global $pvnwp_helper;
$pvnwp_helper = new PVNWPHelper();
$pvnwp_helper->plugins_url = plugins_url();
class PVNAuthPopup{
	private $site;
	/**
	 * Register hooks with WP Core
	 */
	function __construct() {
		
		//call hook to add admin menu to admin sidebar
		add_action( 'admin_menu', array( &$this, 'add_menu' ) );
		//enqueue admin css & js
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_script' ) );
		
		//enqueue frontend css & js
		add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_script' ) );
		
		add_action( 'admin_init', array($this, 'admin_init' ));
		add_action( 'init', array($this, 'init' ));
		
		// Enable the user with no privileges to run ajax_login() in AJAX
		
		add_action("wp_footer",  array($this,"site_render_forms"));
		
	}
	
	function admin_init(){
		global $pvnwp_helper;
		//register_setting( $pvnwp_helper->plugin_alias_mini.'-settings-group', $pvnwp_helper->plugin_alias_mini.'_settings' );
	}
	function init(){
		global $pvnwp_helper;
		include_once dirname(__FILE__) . '/inc/site.inc.php';
		$this->site = new PVNAuthPopupSite();
	}
	
	/**
	 * Adds link to admin menu to sidebar, registers admin_panel as output callback
	 */
	function add_menu() {
		global $pvnwp_helper;
		add_menu_page( 
						__( 'Dashboard - ' . $pvnwp_helper->title, $pvnwp_helper->plugin_alias ),
						__( $pvnwp_helper->title, $pvnwp_helper->plugin_alias ), 
						'manage_options', 
						$pvnwp_helper->plugin_alias, 
						array($this, 'dasbhoard_panel'),
						plugins_url( 'assets/images/logo_16.png',__FILE__ )
				);
	}
	function dasbhoard_panel(){
		include_once dirname(__FILE__) . '/inc/admin.inc.php';
		$admin_panel = new PVNAuthPopupAdmin();
		$admin_panel->manage_options();
	}
	function site_render_forms(){
		$this->site->render_forms();
	}
	function admin_enqueue_script(){
		global $pvnwp_helper;
		wp_enqueue_style( $pvnwp_helper->plugin_alias2.'-admin-style', plugins_url( 'assets/css/'.$pvnwp_helper->plugin_alias.'_admin.css', __FILE__ ) );
		wp_enqueue_script( $pvnwp_helper->plugin_alias2.'-admin-script',plugins_url( 'assets/js/'.$pvnwp_helper->plugin_alias.'_admin.js', __FILE__ ));
	}
	function enqueue_script(){
		global $pvnwp_helper; 
		$current_user = wp_get_current_user();
		$setting = get_option($pvnwp_helper->plugin_alias_mini.'_settings') ;  
		
		wp_enqueue_style( $pvnwp_helper->plugin_alias2.'-style', plugins_url( 'assets/css/'.$pvnwp_helper->plugin_alias.'.css', __FILE__ ) );
		wp_enqueue_script( $pvnwp_helper->plugin_alias2.'-jqv-script',plugins_url( 'assets/js/jquery.validate.js', __FILE__ ), array('jquery'));
		if(isset($setting['enable_grc']) && $setting['enable_grc'] == 'yes'){
			wp_enqueue_script( $pvnwp_helper->plugin_alias2.'-grc-script','https://www.google.com/recaptcha/api.js');
		}
		wp_enqueue_script( $pvnwp_helper->plugin_alias2.'-script',plugins_url( 'assets/js/'.$pvnwp_helper->plugin_alias.'.js', __FILE__ ));
		
		wp_localize_script( $pvnwp_helper->plugin_alias2.'-script',$pvnwp_helper->plugin_alias_mini, array(
			'ajaxurl'			=> admin_url( 'admin-ajax.php' ),
			'login_handler'		=> isset($setting['login_handle']) && $setting['login_handle'] ? $setting['login_handle'] : '.login-link',
			'register_handler'	=> isset($setting['register_handle']) && $setting['register_handle'] ? $setting['register_handle'] : '.register-link',
			'hide_overlay'		=> isset($setting['hide_overlay']) && $setting['hide_overlay'] ? $setting['hide_overlay'] : 'no',
			'home_url' 			=> home_url(),
			'user_loggein' 		=> ($current_user->ID)?'1':'',
			'logout_text'		=> isset($setting['button_logout_text']) && $setting['button_logout_text'] ? $setting['button_logout_text'] : 'LogOut',
			'loadingmessage'	=> __('Sending user info, please wait...')
		));
		
	}
	
	

}

new PVNAuthPopup();


