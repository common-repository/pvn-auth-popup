<?php
class PVNAuthPopupSite {
	private $setting;
	function __construct() {
		global $pvnwp_helper;
		
		$this->setting = get_option($pvnwp_helper->plugin_alias_mini.'_settings') ; 
		
		add_action( 'wp_ajax_nopriv_ajaxlogin', array($this,'ajax_login') );
		add_action( 'wp_ajax_ajaxlogin', array($this,'ajax_login') );


		add_action( 'wp_ajax_nopriv_ajaxregister', array($this,'ajax_register') );
		add_action( 'wp_ajax_ajaxregister', array($this,'ajax_register') );
		
		add_action( 'wp_ajax_nopriv_ajaxforgotpassword', array($this,'ajax_forgotPassword') );
		add_action( 'wp_ajax_ajaxforgotpassword', array($this,'ajax_forgotPassword') );
		
		add_action( 'wp_ajax_nopriv_pvnaplogout', array($this,'ajax_logout') );
		add_action( 'wp_ajax_pvnaplogout', array($this,'ajax_logout') );
		
		add_shortcode('pvnap_login', array($this,'pvnap_login_shortcode_callback'));
		add_shortcode('pvnap_register', array($this,'pvnap_register_shortcode_callback'));
		add_shortcode('pvnap', array($this,'pvnap_shortcode_callback'));
	}
	function pvnap_shortcode_callback($atts){
		$pvnap_atts = shortcode_atts( array(
			'login_text' => 'LogIn',
			'login_class' => '',
			'register_text' => 'SignUp',
			'register_class' => '',
		), $atts );
		
		$str = $this->pvnap_login_shortcode_callback(array('text' => $pvnap_atts['login_text'],'class' => $pvnap_atts['login_class']));
		$str .= ' | ';
		$str = $this->pvnap_register_shortcode_callback(array('text' => $pvnap_atts['register_text'],'class' => $pvnap_atts['register_class']));
		return $str;
	}
	function pvnap_login_shortcode_callback($atts) {
		global $pvnwp_helper;
		
		$pvnap_log_atts = shortcode_atts( array(
			'text' => 'LogIn',
			'class' => '',
		), $atts );
		
		$login_handle = $this->setting['login_handle'];
		$handle_arr = $pvnwp_helper->getHandler($login_handle);
		if (!is_user_logged_in()){
			return '<a id="'.$handle_arr['id'].'" class="'.$handle_arr['class'].' ' . $pvnap_log_atts['class'] . '" style="cursor:pointer">' . $pvnap_log_atts['text'] . '</a>';
		} else {
			return '<a id="'.$handle_arr['id'].'" class="'.$handle_arr['class'].' pvnap_logout" style="cursor:pointer">LogOut</a>';
		}
	}

	function pvnap_register_shortcode_callback($atts) {
		global $pvnwp_helper;
		
		$pvnap_reg_atts = shortcode_atts( array(
			'text' => 'Create an Account?',
			'class' => '',
		), $atts );
		
		$register_handle = $this->setting['register_handle'];
		$handle_arr = $pvnwp_helper->getHandler($register_handle);
		if (!is_user_logged_in()){
			return '<a id="'.$handle_arr['id'].'" class="'.$handle_arr['class'].' ' . $pvnap_reg_atts['class'] .'" style="cursor:pointer">'.$pvnap_reg_atts['text'].'</a>';
		} else {
			return '';
		}
	} 

	function ajax_login(){
		check_ajax_referer( 'ajax-login-nonce', 'security' );
		$remember = isset($_POST['remember'])?true:false;
		$this->auth_user_login($_POST['username'], $_POST['password'], 'Login',$remember); 
		die();
	}

	function ajax_register(){
		global $pvnwp_helper;
		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'ajax-register-nonce', 'security' );
		
		if(!empty($_POST['g-recaptcha-response'])){
			$secret = $this->setting['grc_secret_key'];
			//echo 'https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response'];
			$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
			$responseData = json_decode($verifyResponse);
			
			if($responseData->success){
				echo json_encode(array('loggedin'=>false, 'message'=>__('reCAPTCHA invalid')));
				die();
			}
		}else{
			echo json_encode(array('loggedin'=>false, 'message'=>__('Please enter reCAPTCHA')));
			die();
		}
			
		// Nonce is checked, get the POST data and sign user on
		$info = array();
		$info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_user($_POST['username']) ;
		$info['user_pass'] = sanitize_text_field($_POST['password']);
		$info['user_email'] = sanitize_email( $_POST['email']);
		
		// Register the user
		$user_register = wp_insert_user( $info );
		if ( is_wp_error($user_register) ){	
			$error  = $user_register->get_error_codes()	;
			
			if(in_array('empty_user_login', $error))
				echo json_encode(array('loggedin'=>false, 'message'=>__($user_register->get_error_message('empty_user_login'))));
			elseif(in_array('existing_user_login',$error))
				echo json_encode(array('loggedin'=>false, 'message'=>__('This username is already registered.')));
			elseif(in_array('existing_user_email',$error))
			echo json_encode(array('loggedin'=>false, 'message'=>__('This email address is already registered.')));
		} else {
		  $this->auth_user_login($info['nickname'], $info['user_pass'], 'Registration');       
		}

		die();
	}

	function auth_user_login($user_login, $password, $login, $remember = false){
		global $pvnwp_helper;
		$info = array();
		$info['user_login'] = $user_login;
		$info['user_password'] = $password;
		$info['remember'] = $remember;
		
		$user_signon = wp_signon( $info, false );
		if ( is_wp_error($user_signon) ){
			echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
		} else {
			wp_set_current_user($user_signon->ID); 
			$redirect_url = '';
			if($login == 'Registration'){
				if(!isset($this->setting['register_redirect']) || !$this->setting['register_redirect']) {
					$redirect_url = 'current';
				}else if($this->setting['register_redirect'] == 'home'){
					$redirect_url =  home_url();
				} else {
					$redirect_url = $pvnwp_helper->url($this->setting['register_redirect']);
				}
			} else {
				if(!isset($this->setting['login_redirect']) || !$this->setting['login_redirect']) {
					$redirect_url = 'current';
				}else if($this->setting['login_redirect'] == 'home'){
					$redirect_url =  home_url();
				} else {
					$redirect_url = $pvnwp_helper->url($this->setting['login_redirect']);
				}
			}
			echo json_encode(array('loggedin'=>true, 'redirect' => $redirect_url, 'message'=>__($login.' successful, redirecting...')));
		}
		
		die();
	}
	function ajax_logout(){
		wp_logout();
		echo json_encode(array('logout'=>true));
		die();
	}
	function ajax_forgotPassword(){
		// First check the nonce, if it fails the function will break
		check_ajax_referer( 'ajax-forgot-nonce', 'security' );
		global $wpdb;
		$account = $_POST['user_login'];
		if( empty( $account ) ) {
			$error = 'Enter an username or e-mail address.';
		} else {
			if(is_email( $account )) {
				if( email_exists($account) ) 
					$get_by = 'email';
				else	
					$error = 'There is no user registered with that email address.';			
			}
			else if (validate_username( $account )) {
				if( username_exists($account) ) 
					$get_by = 'login';
				else	
					$error = 'There is no user registered with that username.';				
			}
			else
				$error = 'Invalid username or e-mail address.';		
		}	
		if(empty ($error)) {
			// lets generate our new password
			//$random_password = wp_generate_password( 12, false );
			$random_password = wp_generate_password();
			// Get user data by field and data, fields are id, slug, email and login
			$user = get_user_by( $get_by, $account );
			$update_user = wp_update_user( array ( 'ID' => $user->ID, 'user_pass' => $random_password ) );
			// if  update user return true then lets send user an email containing the new password
			if( $update_user ) {
				$from = get_option('admin_email'); // Set whatever you want like mail@yourdomain.com
				if(!(isset($from) && is_email($from))) {		
					$sitename = strtolower( $_SERVER['SERVER_NAME'] );
					if ( substr( $sitename, 0, 4 ) == 'www.' ) {
						$sitename = substr( $sitename, 4 );					
					}
					$from = 'do-not-reply@'.$sitename; 
				}
				$to = $user->user_email;
				$subject = 'Your new password';
				$sender = 'From: '.get_option('name').' <'.$from.'>' . "\r\n";
				$message = 'Your new password is: '.$random_password;	
				$headers[] = 'MIME-Version: 1.0' . "\r\n";
				$headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers[] = "X-Mailer: PHP \r\n";
				$headers[] = $sender;	
				$mail = wp_mail( $to, $subject, $message, $headers );
				if( $mail ) 
					$success = 'Check your email address for you new password.';
				else
					$error = 'System is unable to send you mail containg your new password.';						
			} else {
				$error = 'Oops! Something went wrong while updating your account.';
			}
		}
		if( ! empty( $error ) )
			//echo '<div class="error_login"><strong>ERROR:</strong> '. $error .'</div>';
			echo json_encode(array('loggedin'=>false, 'message'=>__($error)));
				
		if( ! empty( $success ) )
			//echo '<div class="updated"> '. $success .'</div>';
			echo json_encode(array('loggedin'=>false, 'message'=>__($success)));
					
		die();
	}
	function render_forms(){
			global $pvnwp_helper;
			$current_user = wp_get_current_user();
			if(!$current_user->ID){
?>
				<form id="pvnap_login" class="pvnap-ajax-auth" action="login" method="post">
				<input type="hidden" name="action" value="ajaxlogin" />
					<h1><?php if($this->setting['login_title']){echo $this->setting['login_title'];}else{echo'Login';}?></h1>
					<hr />
					<p class="status"></p>  
					<?php wp_nonce_field('ajax-login-nonce', 'security'); ?>  
					<div><label for="pvnap_username" class="label">Username or Email</label>
						
						<input id="pvnap_username" required type="text" class="" name="username" placeholder="Insert your username">
					</div>
					<div><label for="pvnap_password" class="label">Password</label>
						<input id="pvnap_password" required type="password" class="" name="password" placeholder="Insert your password">
					</div>
					<?php if(!(isset($this->setting['hide_remember']) && $this->setting['hide_remember'] == 'yes')) { ?>
						<div><br />
							<label  for="pvnap_remember"  class="label remember"> Remember Me </label>
							<input id="pvnap_remember" type="checkbox" value="1"  name="remember" >
						</div>
					<?php } ?>
					<input class="button <?php if($this->setting['button_class']){echo $this->setting['button_class'];}?>" type="submit" value="<?php if ($options['button_login']){echo $options['button_login'];}else{echo 'Login';};?>" name="login">
					<?php if(!(isset($this->setting['hide_forget_pwd_link']) && $this->setting['hide_forget_pwd_link'] == 'yes')) { ?>
						<br /><a id="pvnap_pop_forgot" class="text-link"  href="<?php echo wp_lostpassword_url(); ?>">Forgot Password?</a>
					<?php } ?>
					
					<?php if(!(isset($this->setting['hide_create_acc_link']) && $this->setting['hide_create_acc_link'] == 'yes')) { ?>
							<br /><a id="pvnap_pop_signup" style="cursor:pointer;color:#B4B2B2;">Create an Account!</a>
						<?php } ?>
					
					
					<a class="close" href="">[ x ]</a>    
				</form>

				<form id="pvnap_register" class="pvnap-ajax-auth"  action="register" method="post">
					<input type="hidden" name="action" value="ajaxregister" />
					<h1><?php if($this->setting['register_title']){echo $this->setting['register_title'];}else{echo'Create an Account!';}?></h1>
					<hr />
					<p class="status"></p>
					<?php wp_nonce_field('ajax-register-nonce', 'security'); ?>         
					<div><label  for="pvnap_signonname" class="label">Username</label>
						<input id="pvnap_signonname" required type="text" name="username" class="" placeholder="Your unique username">
					</div>
					<div><label  for="pvnap_email"  class="label">Email</label>
						<input id="pvnap_email" required type="text" class=" email" name="email" placeholder="Your valid email">
					</div>
					<div><label  for="pvnap_signonpassword" class="label">Password</label>
						<input id="pvnap_signonpassword" required type="password" class="" name="password" placeholder="Create secure password">
					</div>
					<div><label  for="pvnap_password2" class="label">Confirm Password</label>
						<input type="password" required id="pvnap_password2" class="" name="password2" placeholder="Confirm your secure password">
					</div>
					<?php if(isset($this->setting['enable_grc']) && $this->setting['enable_grc'] == 'yes'){ ?>
						<div><label  for="g-recaptch" class="label">Human Verification</label>
							<div class="g-recaptcha" data-sitekey="<?php echo $this->setting['grc_site_key']; ?>" style="display:block;"></div>
						</div>
					<?php } ?>
					<br />
					<input class="button <?php if($this->setting['button_class']){echo $this->setting['button_class'];}?>" type="submit" value="<?php if ($setting['button_register']){echo $setting['button_register'];}else{echo 'Register';};?>" name="register">
					
					<a id="pvnap_pop_login" class="text-link" style="cursor:pointer">Want to Login?</a>
					<a class="close" href="">[ x ]</a>
				</form>

				<form id="pvnap_forgot_password" class="pvnap-ajax-auth" action="forgot_password" method="post">
					<h1><?php if($this->setting['forgot_password_title']){echo $this->setting['forgot_password_title'];}else{echo'forgot password?';}?></h1>
					<hr />
					<p class="status"></p>
					<?php wp_nonce_field('ajax-forgot-nonce', 'security'); ?>  
					<div><label  for="pvnap_user_login" class="label">Username or Email</label>
						<input id="pvnap_user_login" required type="text" class="" name="user_login" placeholder="Insert your username or email here">
					</div>
					<input class="button <?php if($this->setting['button_class']){echo $this->setting['button_class'];};?>" type="submit" value="<?php if ($setting['button_forgot_password']){echo $setting['button_forgot_password'];}else{echo 'Get Password';};?>" name="forgot_password">
					<a class="close" style="cursor:pointer">[ x ]</a>    
				</form>
<?php 
			} else {
?>
				<div id="pvnap_logout_popup" class="pvnap-ajax-logout" >
					Logging you out, please wait . . .
				</div>
<?php
			}
	}
	
	
}