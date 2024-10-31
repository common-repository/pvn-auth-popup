=== PVN Auth Popup ===
Contributors: pawandev (Ravendra Patel)
Tags: popup, cutom login, pvn auth popup, authentication popup, ajax authentication,  auth popup, ajax auth,  ajax login, ajax register, login popup, register popup, login, register, lost, password, popup, modal, overlay, shortcode, captcha, recaptcha
Requires at least: 3.5
Tested up to:  4.7.2

Wordpress custom authentication plugin. It Shows login, register and lost password form inn modal popup and process with ajax.

== Description ==

** wordpress login, register and lost password form in modal popup and process with ajax.**

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

== Installation ==

1. Upload 'pvn-auth-popup' folder to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to post or page, then insert shortcode.

== Screenshots ==

1. Login form.
2. Registration form.
3. Forgot password form.
4. All fields required.
5. Error form.
6. settings on WP Dashboard.
7. settings on WP Dashboard.

== Changelog ==

= 1.0 =
* First release.
