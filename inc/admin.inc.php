<?php

class PVNAuthPopupAdmin {
	
	function __construct() {
		
	}
	function manage_options(){
		global $pvnwp_helper; 
		$options = get_option($pvnwp_helper->plugin_alias); 

?>

		<div class="pvnwp-wrap setting">
			<div class="pvnwp-header-wrap">
				<img src="<?php echo plugins_url( 'assets/images/logo_128.png', dirname(__FILE__) );?>">
				<h2>Setting - <?php echo $pvnwp_helper->title;?></h2>
				<div class="clear"></div>
			</div>
			<div class="pvnwp-content-wrap">
				<div class="pvnwp-content">
					<?php 
								
						if (isset($_POST[$pvnwp_helper->plugin_alias_mini.'_save'])) {
							update_option($pvnwp_helper->plugin_alias_mini.'_settings', $_POST[$pvnwp_helper->plugin_alias_mini]);
							echo '<div class="updated pvnwp-success-messages"><p><strong>'. __("Settings saved.", $pvnwp_helper->plugin_alias).'</strong></p></div>';
						}
						$setting = get_option($pvnwp_helper->plugin_alias_mini.'_settings') ;  
					
					?>
				
					<div class="pvnwp-inner">
						
						<form method="post" id="mainform" action="">
							
						
						
							<table class="pvnwp-plugin widefat">
								<thead>
									<tr>
										<th scope="col" colspan="2">Title Settings</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="titledesc"><label for="login_title">Login text<label></td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[login_title]" id="login_title" value="<?php if(isset($setting['login_title'])){ echo $setting['login_title']; } ?>" type="text" class="required" placeholder="eg: &quot;Login&quot;">
										</td>
									</tr><tr>
										<td class="titledesc"><label for="register_title">Register text<label></td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[register_title]" id="register_title"  value="<?php if(isset($setting['register_title'])){ echo $setting['register_title']; } ?>" type="text" placeholder="eg: &quot;Create an Account!&quot;">
										</td>
									</tr>
									<tr>
										<td class="titledesc"><label for="forgot_password_title">Forgot password text<label></td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[forgot_password_title]" id="forgot_password_title" value="<?php if(isset($setting['forgot_password_title'])){ echo $setting['forgot_password_title']; } ?>" type="text" class="required" placeholder="eg: &quot;Forgot Password?&quot;">
										</td>
									</tr>
									
								</tbody>
							</table>
							
							
							<table class="pvnwp-plugin widefat" style="margin-top:25px;">
								<thead>
									<tr>
										<th scope="col" colspan="2">Popup Handling Settings</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="titledesc"><label for="login_handle">Login Handle<label></td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[login_handle]" id="login_handle" value="<?php if(isset($setting['login_handle'])){ echo $setting['login_handle']; } ?>" class="required"  type="text" placeholder="eg: .login-link">
											<p class="description">Type the class name or ID of the element you want to launch the dialog box when clicked, example <code>.login-link</code></p>
										</td>
									</tr>
									<tr>
										<td class="titledesc"><label for="register_handle">Register Handle<label></td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[register_handle]" id="register_handle" value="<?php if(isset($setting['register_handle'])){ echo $setting['register_handle']; } ?>"   class="required" type="text" placeholder="eg: .register-link">
											<p class="description">Type the class name or ID of the element you want to launch the dialog box when clicked, example <code>.register-link</code></p>
										</td>
									</tr>
									<tr>
										<td class="titledesc"><label for="hide_overlay">Hide Overlay</td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[hide_overlay]" id="hide_overlay"  value="yes"  type="checkbox" class="" <?php if(isset($setting['hide_overlay']) && $setting['hide_overlay'] == 'yes'){ echo  'checked="checked" '; } ?> >
										</td>
									</tr>
								</tbody>
							</table>
							
							
							<table class="pvnwp-plugin widefat" style="margin-top:25px;">
								<thead>
									<tr>
										<th scope="col" colspan="2">Button Settings</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="titledesc"><label for="button_login_text">Login Button Text<label></td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[button_login_text]" id="button_login_text" value="<?php if(isset($setting['button_login_text'])){ echo $setting['button_login_text']; } ?>" type="text" class="required" placeholder="eg: &quot;Login&quot;">
										</td>
									</tr>
									<tr>
										<td class="titledesc"><label for="button_register_text">Register Button Text<label></td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[button_register_text]" id="button_register_text"  value="<?php if(isset($setting['button_register_text'])){ echo $setting['button_register_text']; } ?>" type="text" class="required" placeholder="eg: &quot;Register Now&quot;">
										</td>
									</tr>
									<tr>
										<td class="titledesc"><label for="button_forgot_password_text">Forgot Password Text<label></td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[button_forgot_password_text]" id="button_forgot_password_text"  value="<?php if(isset($setting['button_forgot_password_text'])){ echo $setting['button_forgot_password_text']; } ?>" type="text" class="required" placeholder="eg: &quot;Get Password&quot;">
										</td>
									</tr>
									<tr>
										<td class="titledesc"><label for="button_logout_text">Logout Text<label></td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[button_logout_text]" id="button_logout_text"  value="<?php if(isset($setting['button_logout_text'])){ echo $setting['button_logout_text']; } ?>" type="text" class="required" placeholder="eg: &quot;LogOut&quot;">
										</td>
									</tr>
									<tr>
										<td class="titledesc"><label for="button_class">Button class<label></td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[button_class]" id="button_class"  value="<?php if(isset($setting['button_class'])){ echo $setting['button_class']; } ?>" type="text" class="required" placeholder="eg: &quot;button&quot; or &quot;button big red&quot;">
										</td>
									</tr>
								</tbody>
							</table>
							<table class="pvnwp-plugin widefat" style="margin-top:25px;">
								<thead>
									<tr>
										<th scope="col" colspan="2">Redirect URL Settings</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="titledesc"><label for="login_redirect">Login Redirect URL</label></td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[login_redirect]" id="login_redirect"  value="<?php if(isset($setting['login_redirect'])){ echo $setting['login_redirect']; } ?>" type="text" class="required" placeholder="current or home or http://someurl">
											<p class="description">Type url where redirect after successfull login, example <code>current</code> for current page <code>home</code> for home page and <code>http://someurl</code> for custom url. Default is <code>current</code></p>
										</td>
									</tr><tr>
										<td class="titledesc"><label for="register_redirect">Register Redirect URL</label></td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[register_redirect]" id="register_redirect"  value="<?php if(isset($setting['register_redirect'])){ echo $setting['register_redirect']; } ?>" type="text" class="required" placeholder="current or home or http://someurl">
											<p class="description">Type url where redirect after successfull registration, example <code>current</code> for current page <code>home</code> for home page and <code>http://someurl</code> for custom url. Default is <code>current</code></p>
										</td>
									</tr>
								</tbody>
							</table>
							<table class="pvnwp-plugin widefat" style="margin-top:25px;">
								<thead>
									<tr>
										<th scope="col">Google reCaptcha</th>
										<th scope="col"><a target="_blank" href="https://www.google.com/recaptcha/intro/index.html">More information</a></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="titledesc"><label for="enable_grc">Enable ReCaptcha</label></td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[enable_grc]" id="enable_grc"  value="yes"  type="checkbox" class="" <?php if(isset($setting['enable_grc']) && $setting['enable_grc'] == 'yes'){ echo  'checked="checked" '; } ?> >
										</td>
									</tr>
									<tr>
										<td class="titledesc"><label for="grc_site_key">Google Site Key</label></td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[grc_site_key]" id="grc_site_key" value="<?php if(isset($setting['grc_site_key'])){ echo $setting['grc_site_key']; } ?>" type="text" class="required" placeholder="eg &quot;6Lf75gIT02AFBH8KfqlV0PV_t6J2vEB-1tbbCDG&quot;">
										</td>
									</tr>
									<tr>
										<td class="titledesc"><label for="grc_secret_key">Google Secret Key</label></td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[grc_secret_key]" id="grc_secret_key" value="<?php if(isset($setting['grc_secret_key'])){ echo $setting['grc_secret_key']; } ?>" type="text" class="required" placeholder="eg &quot;6Lf75gIT02AFBH8KfqlV0PV_t6J2vEB-1tbbCDG&quot;">
										</td>
									</tr>
								</tbody>
							</table>
							
							<table class="pvnwp-plugin widefat" style="margin-top:25px;">
								<thead>
									<tr>
										<th scope="col" colspan="2">Login Form Setting</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="titledesc"><label for="hide_create_acc_link">Hide Create Account Link</td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[hide_create_acc_link]" id="hide_create_acc_link"  value="yes"  type="checkbox" class="" <?php if(isset($setting['hide_create_acc_link']) && $setting['hide_create_acc_link'] == 'yes'){ echo  'checked="checked" '; } ?> >
										</td>
									</tr>
									<tr>
										<td class="titledesc"><label for="hide_forget_pwd_link">Hide Forget Password Link</td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[hide_forget_pwd_link]" id="hide_forget_pwd_link"  value="yes"  type="checkbox" class="" <?php if(isset($setting['hide_forget_pwd_link']) && $setting['hide_forget_pwd_link'] == 'yes'){ echo  'checked="checked" '; } ?> >
										</td>
									</tr>
									<tr>
										<td class="titledesc"><label for="hide_forget_pwd_link">Hide Remember Me</td>
										<td class="forminp">
											<input name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[hide_remember]" id="hide_remember"  value="yes"  type="checkbox" class="" <?php if(isset($setting['hide_remember']) && $setting['hide_remember'] == 'yes'){ echo  'checked="checked" '; } ?> >
										</td>
									</tr>
								</tbody>
							</table>
							
							
							
							<table class="pvnwp-plugin widefat" style="margin-top:25px;">
								<thead>
									<tr>
										<th scope="col" colspan="2">Custom CSS </th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="2" class="forminp">
											<textarea style="width:100%;height:100px;" name="<?php echo $pvnwp_helper->plugin_alias_mini;?>[custom_css]"><?php if(isset($setting['custom_css'])){ echo $setting['custom_css']; } ?> </textarea>
											
										</td>
									</tr>
									
								</tbody>
							</table>
							
							
							<p class="submit"><input type="submit" name="<?php echo $pvnwp_helper->plugin_alias_mini.'_save'; ?>" id="submit" class="button button-primary" value="Save Changes"/></p>
						</form>
					</div>
				</div>
				<div class="pvnwp-other">
					<div class="pvnwp-inner">
							<div class="donation-wrap">
								<?php $this->paypal_donation();?>
							</div>
							<h4><strong>Add Link to Menu:</strong></h4>
							<ul>
							<li>go through 'appearance > menus'. make sure 'CSS Classes' option in 'screen options' (top right corner) is checked.</li>
							<li>add custom links in menu and put # in url field. and put desired class name in CSS Classes field. These class name should be configured in plugin's admin page as a handler</li> 
							<li>save menu and go to front end to test</li>
							</ul>

							<h4><strong>Shortcode:</strong></h4>
							<ul>
								<li>
									<code>[pvnap_register]</code> - show registration popup link.<br /><strong><i>Parameters:</i></strong><br /> 
									<code><i>text</i></code> for link text<br /><code><i>class</i></code> for additional link class.<br />
									<strong>Example:</strong><br /><code>[pvnap_register text="Create an Account!" class="smart_link"]</code>
								</li>
								<li>
									<code>[pvnapp_login]</code> - show login popup link.<br /><strong><i>Parameters:</i></strong><br /> 
									<code><i>text</i></code> for link text<br /><code><i>class</i></code> for additional link class.<br />
									<strong>Example:</strong><br /><code>[pvnapp_login text="Create an Account!" class="smart_link"]</code>
								</li>
								<li>
									<code>[pvnapp]</code> - show login & registration (both) popup link together.<br /><strong><i>Parameters:</i></strong><br /> 
									<code><i>login_text</i></code> for text of login link<br /><code><i>login_class</i></code> for additional slasses of login link<br />
									<code><i>register_text</i></code> for text of register link<br /><code><i>register_class</i></code> for additional slasses of register link<br />
									<strong>Example:</strong><br /><code>[pvnapp login_text="Sign In" register_text="Sign Up" login_class="smart_link" register_class="smart_link"]</code>
								</li>
								
							</ul>
							
							<h5><strong>Features:</strong></h5>
							<ul>
								<li>Modal form with overlay or simple popup form.</li>
								<li>Shows a login or registration link for not logged in users that pops up on click.</li>
								<li>Provides shortcodes for use in posts and widgets</li>
								<li>If user logged in then login link will automatically converted to logout link and register link will be hide</li>
								<li>register link , forgot password link, remember me options can be managed (show/hide) from admin section</li>
								<li>Google recaptcha can be managed (show/hide) from admin section</li>
								<li>login registration popup liks can be managed by class name or id of link</li>
								<li>custom style can be set from admin section</li>
							</ul>
							
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
<?php
	}
	function paypal_donation(){
		if(isset($GET['pvnap_act']) && $GET['pvnap_act'] == 'thanks_donation'){
			echo '<div class="thanks_donation">Thank you so much for donation</div>';
		} else {
?>
			<img src="<?php echo plugins_url( 'assets/images/buy_me_a_beer.jpg', dirname(__FILE__) );?>">
			<form name="_xclick" action="https://www.paypal.com/yt/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="pawan.developers@gmail.com">
				<input type="hidden" name="item_name" value="Donation for pvn auth wp plugin">
				<input type="hidden" name="currency_code" value="USD">
				<input type="hidden" name="return" value="<?php echo  admin_url( 'admin.php?page=pvn_auth_popup&pvnap_act=thanks_donation', '' );?>">
				<!--input type="hidden" name="amount" value="10.00"-->
				<select name="amount">
					<option value="5.00"> $5 USD</option>
					<option value="10.00" selected="selected"> $10 USD</option>
					<option value="15.00"> $15 USD</option>
					<option value="20.00"> $20 USD</option>
					<option value="25.00"> $25 USD</option>
					<option value="35.00"> $35 USD</option>
					<option value="50.00"> $50 USD</option>
					<option value="75.00"> $75 USD</option>
					<option value="100.00"> $100 USD</option>
					<option value="150.00"> $150 USD</option>
					<option value="200.00"> $200 USD</option>
				</select>
				<input type="image" src="http://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" name="submit" alt="Donate with PayPal - it's fast, free and secure!">
			</form>
			
			<div class="or">OR</div>
			<img style="width:60%;" src="<?php echo plugins_url( 'assets/images/bitcoin-logo.png', dirname(__FILE__) );?>" />
			<div class="btc-wrap">
				Send bitcoins : 3F5bVN69ktoHeKJrgF7cRfDhgefw9RcdnR
			</div>
			<hr />
<?php
		}
	}
}