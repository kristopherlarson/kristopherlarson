<?php
/*
====================
CONTACT FORM
====================
*/
// Only process POST reqeusts.
if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {

	$phone_regex = '/([0-9]{3})\.?([0-9]{3})\.?([0-9]{4})/';

	$postData = array(
		'business_id'                              => 'ENTER HERE', // this is different for each account
		'email'                                    => $_POST['email'],
		'first_name'                               => $_POST['first_name'],
		'last_name'                                => $_POST['last_name'],
		'identifier_type'                          => 'email',
		'notifications' 						   => 'auto_reply, email, sms',
		'phone'                                    => $_POST['phone'],
		'request_data[Email]'					   => $_POST['email'],
		'request_data[First Name]' 				   => $_POST['first_name'],
		'request_data[Last Name]' 				   => $_POST['last_name'],
		'request_data[Phone]' 					   => $_POST['phone'],
		'request_data[Tell Us About Your Project]' => filter_var( $_POST['notes'], FILTER_SANITIZE_STRING ),
		'request_title'                            => 'Contact Request',
		'source'                                   => 'Contact Form',
		'source_url'                               => 'FULL WEBSITE URL',
		'system_message'                           => 'New contact request from WEBSITE NAME'
	);


	// Define errors
	$errors = [ ];

	// Input Fields
	$emailFields = array(
		//  Input Name  =>  User Friendly Name
		'first_name' => 'First Name',
		'last_name'  => 'Last Name',
		'email'      => 'Email',
		'phone'      => 'Phone',
		'notes'      => 'Comments'
	);

	// Required Fields
	$required_fields = array(
		'first_name' => 'First Name',
		'last_name'  => 'Last Name',
		'email'      => 'Email'
	);

	// Check required fields
	foreach ( $required_fields as $field_name => $friendly_name ) {

		if ( empty( $_POST[ $field_name ] ) ) {

			$errors[] = $friendly_name . ' is a required field.<br/>';

		}

	}

	// Check honeypot field
	if ( ! empty( $_POST['home_address'] ) ) {

		echo 'No spam please!';
		exit;

	}

	// Send the email.
	if ( empty( array_filter( $errors ) ) ) {

		$ch = curl_init( 'https://api.vcita.com/v1/partners/leads' );
		curl_setopt_array( $ch, array(
			CURLOPT_POST           => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER     => array( 'Authorization: Token token="88e33d35ef4a42ef47443c13aa58621b"' ),
			CURLOPT_POSTFIELDS     => $postData
		) );

		$response = curl_exec( $ch );

		curl_close( $ch );

		$_POST = array();

		echo '<p class="callout">Thank you for taking the time to fill out our form! We will respond as quickly as we can!</p>';

	} else { ?>

		<div class="alert-box callout alert">
			<?php
			foreach ( $errors as $error ) {

				echo $error;

			}
			?>
		</div>
		<?php
	}

} ?>

<form id="standard-form" method="post">

	<div class="flex-outter">

		<input class="contact-first-name" name="first_name" type="text" placeholder="*First Name" value="<?php
		echo isset( $_POST['standard-form'] ) ? $_POST['first_name'] : '';
		?>" required/>

		<input class="contact-last-name" name="last_name" type="text" placeholder="*Last Name" value="<?php
		echo isset( $_POST['standard-form'] ) ? $_POST['last_name'] : '';
		?>" required/>

	</div>

	<div class="flex-outter">

		<input class="contact-email" name="email" type="email" placeholder="*Email" title="Please valid email" pattern="[^ @]*@[^ @]*" value="<?php
		echo isset( $_POST['standard-form'] ) ? $_POST['email'] : '';
		?>"/>

		<input class="contact-phone" name="phone" type="tel" placeholder="Phone" title="555-555-5555" pattern="\d{3}[\-]\d{3}[\-]\d{4}" value="<?php
		echo isset( $_POST['standard-form'] ) ? $_POST['phone'] : '';
		?>"/>

	</div>

	<textarea class="contact-notes" placeholder="Questions and Comments..." name="notes"><?php
		echo isset( $_POST['standard-form'] ) ? $_POST['notes'] : '';
		?></textarea>

	<?php
	/* Phoney field post variable will need to be changed to something else if address is added to a different input */
	?>

	<p class="phoney-field">Address: <span>(required)</span>
		<input name="home_address" type="text" value="<?php
		echo isset( $_POST['standard-form'] ) ? $_POST['home_address'] : '';
		?>"/>
	</p>

	<input type="hidden" value="1" name="standard-form"/>

	<button class="button form-submit">
		SUBMIT
	</button>

</form> <!-- /#standard-form -->