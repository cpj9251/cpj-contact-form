<?php
/**
 * Plugin Name:       CPJ Contact Form
 * Plugin URI:        cpauljarvis.com
 * Description:       A e-mail contact form block plugin
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           2.0.0
 * Author:            Paul Jarvis
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       cpj-contact-form
 *
 * @package           cpj-contact-form
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */

 if(! defined ('WPINC')){
    die;
}


function cpj_contact_form_cpj_contact_form_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'cpj_contact_form_cpj_contact_form_block_init' );


function css_enqueue($hook){
	
	wp_enqueue_style( 'cpj-contact-form-css', plugins_url('/cpj-contact-form-css.css',__FILE__), false, '2.0.0','all' );

}//end fx

add_action('wp_enqueue_scripts', 'css_enqueue');
add_action('admin_enqueue_scripts','css_enqueue');

function js_enqueue($hook){
	
	$cpj_contact_form_nonce = wp_create_nonce( 'cpj-contact-form-nonce-cpj' );
	
	wp_enqueue_script('cpj-contact-form-js', plugins_url('/cpj-contact-form-js.js',__FILE__),array( 'jquery' ),'2.0.0',true);

	wp_localize_script(
	'cpj-contact-form-js',
	'cpj_ajax_obj',
	array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce'    => $cpj_contact_form_nonce,
		'ajax_loader_url' => plugins_url("assets/ajax-loader.gif",__FILE__) 
	)
	);

}//end fx

add_action('wp_enqueue_scripts', 'js_enqueue');


add_action('admin_menu','cpj_contact_form_options_page');

function cpj_contact_form_options_page(){
	
	add_menu_page(
			'CPJ Contact Form',
			'CPJ Contact Form Options',
			'manage_options',
			'cpj_contact_form',
			'cpj_contact_form_options_page_html');
}//end fx


register_activation_hook(__FILE__,'doDBStuffFirstTime');


function doDBStuffFirstTime(){
	 $admin_email = get_option("admin_email");

	 add_option("cpj_contact_form_admin_email", $admin_email);

	 $return_msg = "Thank you for submitting our contact form. We will respond to your request ASAP.";

	 add_option("cpj_contact_form_msg", $return_msg);

}//end fx

add_action('wp_ajax_cpj_contact_form', 'cpj_contact_form_handler');
add_action('wp_ajax_nopriv_cpj_contact_form', 'cpj_contact_form_handler');

function cpj_contact_form_handler(){
	
	
	check_ajax_referer( 'cpj-contact-form-nonce-cpj','cpj-contact-form-nonce' );
	
	
	$name = sanitize_text_field($_POST['name']);
	$email = sanitize_email($_POST['email']);
	$phone = sanitize_text_field($_POST['phone']);
	$prefer = sanitize_text_field($_POST['pref']);
	$msg = sanitize_textarea_field($_POST['message']);
	
	$emailSubject = "Contact Form has been Submitted";
	$emailMsg = "Name: ". $name . "\n Phone:". $phone . "\n Preferred Method of Contact: " . $prefer . "\n Message: \n" . $msg;
	
	$headers = 'From: ' . $email . "\r\n" .
    'Reply-To: ' .$email . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
	
	$email = get_option("cpj_contact_form_admin_email");
	
	wp_mail($email,$emailSubject,$emailMsg,$headers);
	
	
	echo "<div style=\"margin:10px;\">\n<p>Thank you " . esc_html($name) . "</p>\n";

	$resp = get_option("cpj_contact_form_msg");
	
	$htmlResponse = str_replace("\n","</p><p>",$resp);
	
	echo "<p>".esc_html($htmlResponse) . "</p>";

	
	wp_die();
}//end fx

function cpj_contact_form_options_page_html(){

$email = get_option("cpj_contact_form_admin_email");

$msg = get_option("cpj_contact_form_msg");

?>
	<div class="wrap">
		<h1><?php echo esc_html(get_admin_page_title()); ?></h1>

		<div id="cpj_contact_form_admin_email_success_box"></div>

		<div id="cpj_contact_form_admin_email_form_box" style="margin:20px;width:500px;text-align:center;border:1px solid #333333;border-radius:10px;float:left;">

			<div id="cpj_contact_form_admin_email_response_block" style="font-size:16px;font-weight:bold;text-align:center;width:100%;"></div>

			<div style="margin:10px;font-size:16px;">
				E-mail where you want the contact form sent to:
			</div>
			<div style="margin:10px;">
				<input style="width:350px; height:30px; border-radius:5px; font-size: 16px; line-height:20px; font-weight:bold;" type="text" name="cpj_contact_form_admin_email" id="cpj_contact_form_admin_email" value="<?php echo esc_attr($email);?>">
			</div>
			<div style="margin:10px;font-size:16px;">
			Response Text displayed after form is submitted:
			</div>
			<div style="margin:10px;">
				<textarea name="cpj_contact_form_response_text" id="cpj_contact_form_response_text" style="width:400px;height:150px;"><?php echo esc_textarea($msg);?>
				</textarea>
			</div>
			<div style="margin:10px;">
				<input style="width:135px;height:30px; font-size:16px;line-height:18px; font-weight:bold; border-radius:5px;" id="cpj_contact_form_admin_email_btn" type="button" value="Update Form">
			</div>

			<div id="cpj_contact_form_admin_email_response_block"></div>
		</div>
		<div style="margin:20px;width:500px;text-align:center;border:1px solid #333333;border-radius:10px;float:left">
			<h3>Instructions</h3>
			<p>
			To include form on a page or post, go to page editor, click + add block. Search for 'cpj', click on cpj-contact-form. Text, background color and spacing can be customized using side panel settings. 
			</p>
		
		</div>
		<div style="clear:both;"></div>
		
	</div>
<?php
	


}//end fx

add_action('wp_ajax_cpj_contact_form_admin', 'cpj_contact_form_admin_handler');

function cpj_contact_form_admin_handler(){

		check_ajax_referer( 'cpj-contact-form-nonce-cpj','cpj-contact-form-nonce' );

		update_option("cpj_contact_form_admin_email",sanitize_text_field($_POST['email']));
		
		update_option("cpj_contact_form_msg",sanitize_text_field($_POST['message']));

		echo "Success, Admin options have been updated";

wp_die();

}//end fx
