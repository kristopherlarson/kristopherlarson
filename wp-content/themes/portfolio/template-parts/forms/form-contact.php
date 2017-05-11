<?php
/* 
====================
CONTACT FORM
====================
*/
// Only process POST reqeusts.
if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {

	// Define email constants
	define('WEBSITE_NAME', get_bloginfo('name'));
	define('WEBSITE_DOMAIN', $_SERVER['HTTP_HOST']);

	// Define errors
	$errors = [];

	// Needed to correctly setup wp_mail
	add_filter('wp_mail_from', function($email)
	{
		return 'no-reply@' . WEBSITE_DOMAIN;
	});
	add_filter('wp_mail_from_name', function($name)
	{
		return WEBSITE_NAME;
	});
	function set_content_type($content_type)
	{
		return 'text/html';
	}
	add_filter('wp_mail_content_type', 'set_content_type');

	// Input Fields
	$emailFields = array(
		//  Input Name  =>  User Friendly Name
		'full_name' => 'Full Name',
		'email'     => 'Email',
		'phone'     => 'Phone',
		'notes'     => 'Comments'
	);

	// Required Fields
	$required_fields = array(
		'full_name' => 'Name',
		'email' => 'Email'
	);

	// Check required fields
	foreach ($required_fields as $field_name => $friendly_name) {

		if ( empty( $_POST[$field_name] ) ) {

			$errors[] = $friendly_name . ' is a required field.<br/>';

		}

	}

	// Check honeypot field
	if ( !empty($_POST['home_address']) ) {

		echo 'No spam please!';
		exit;

	}

	$full_name = $_POST['full_name'];
	if ( preg_match( '~[0-9]~', $full_name ) ) {

		echo 'No spam please!';
		exit;

	}

	// Email subject, headers and recipient

	$reply_to = $_POST['full_name'];
	$reply_to .= ' <' . $_POST['email'] . '>';

	$headers[] = "Reply-To: " . $reply_to;

	$subject = WEBSITE_NAME . ' Website Contact';

	$email_top  = WEBSITE_NAME . ' Website Contact Form Inquiry:';
	$email_html = $email_top . '<br><br>';
	$email_text = $email_top . "\n\n";


	// get ACF input to send emails to
    $email_username = get_field('smtp_receive_emails', 'option');

    $email_recipients = array(
		'' . $email_username . ''
	);

	// Build Email Output & Data Sanitize
	foreach ($emailFields as $field_name => $friendly_name) {

		if ($field_name == 'full_name') {
			$_POST[$field_name] = filter_var($_POST[$field_name], FILTER_SANITIZE_STRING);
		}
		if ($field_name == 'email') {
			$_POST[$field_name] = filter_var($_POST[$field_name], FILTER_SANITIZE_EMAIL);
		}
		if ($field_name == 'phone') {
			$regex              = '/([0-9]{3})\.?([0-9]{3})\.?([0-9]{4})/';
			$_POST[$field_name] = preg_replace($regex, '$1-$2-$3', $_POST[$field_name]); // http://php.net/manual/en/function.preg-match.php
		}
		if ($field_name == 'notes') {
			$_POST[$field_name] = stripslashes(filter_var( $_POST[$field_name], FILTER_SANITIZE_STRING));
		}
		$email_html .= '<b>' . $friendly_name . '</b>: ' . $_POST[$field_name] . '<br />';
		$email_text .= $friendly_name . ': ' . $_POST[$field_name] . "\n";

	}

	$message = $email_html;


	// Send the email.
	if ( empty( array_filter( $errors ) ) ) {
		if ( wp_mail($email_recipients, $subject, $message, $headers) ) {

			echo '<p class="callout">Thank you for taking the time to fill out our form! We will respond as quickly as we can!</p>';
			$_POST = array();

		} else {

			$errors = "Oops! Something went wrong and we couldn't send your message.";

		}

	} else { ?>

		<div class="alert-box alert">
			<?php
			foreach($errors as $error) {

				echo $error;

			}
			?>
		</div>
		<?php
	}

} ?>

<form id="standard-form" method="post">

	<p class="req"><span class="blue">*</span>Required</p>

	<input class="contact-full-name" name="full_name" type="text" placeholder="*Full Name" pattern="[a-zA-Z ]+" value="<?php
	echo isset( $_POST['standard-form'] ) ? $_POST['full_name'] : '';
	?>" required />

	<input class="contact-email" name="email" type="email" placeholder="*Email" pattern="[^ @]*@[^ @]*" value="<?php
	echo isset( $_POST['standard-form'] ) ? $_POST['email'] : '';
	?>" />

	<input class="contact-phone" name="phone" type="tel" placeholder="Phone" value="<?php
	echo isset( $_POST['standard-form'] ) ? $_POST['phone'] : '';
	?>"/>

    <textarea class="contact-notes" placeholder="Questions or Comments" name="notes"><?php
		echo isset( $_POST['standard-form']) ? $_POST['notes'] : '';
		?></textarea>

	<?php
	/* Phoney field post variable will need to be changed to something else if address is added to a different input */
	?>

	<p class="phoney-field">Address: <span>(required)</span>
		<input name="home_address" type="text" value="<?php
		echo isset($_POST['standard-form']) ? $_POST['home_address'] : '';
		?>" />
	</p>

	<input type="hidden" value="1" name="standard-form" />

	<button class="button form-submit">
		Send Message
	</button>


</form> <!-- /#standard-form -->