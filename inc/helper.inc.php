<?php

class PVNWPHelper{

	public $plugin_url;
	public $title = 'PVN Auth Popup';
	
	public $plugin_alias = 'pvn_auth_popup';
	public $plugin_alias2 = 'pvn-auth-popup';
	public $plugin_alias_mini = 'pvnap';
	
	function __construct() {
		
	}
	function url($url) {
		if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
			$url = "http://" . $url;
		}
		return $url;
	}
	function getHandler($handle){
		$login_handle_arr = explode("#", $handle);
		$id = '';
		$cls = '';
		
		if(isset($login_handle_arr[1])){
			$id = $login_handle_arr[1];
			$cls = '';
		} else {
			$login_handle_arr = explode(".", $handle);
			if(isset($login_handle_arr[1])){
				$id = '';
				$cls = $login_handle_arr[1];
			} else {
				$id = '';
				$cls = $handle;
			}
		}
		return array('id' => $id, 'class' => $cls);
	}
}