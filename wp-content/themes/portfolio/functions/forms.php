<?php


// check to see if ACF is active
if ( class_exists('acf') ) {

	$start_smtp = get_field( 'use_smtp', 'option' );

	// check to see if SMTP is active
	if ( $start_smtp ) {

		// Overrides PHP mailer to send through SMTP
		add_action( 'phpmailer_init', 'amped_phpmailer_init' );

		function amped_phpmailer_init( PHPMailer $phpmailer ) {

			// get ACF fields
			$email_host     = get_field( 'smtp_server_address', 'option' );
			$email_port     = get_field( 'smtp_server_port', 'option' );
			$email_username = get_field( 'smtp_username', 'option' );
			$email_password = get_field( 'smtp_password', 'option' );
			$email_security = get_field( 'smtp_security', 'option' );
			$email_from     = get_field( 'smtp_from_email_address', 'option' );


			if ( ! empty( $email_from ) ) {
				$email_receive_from = $email_from;
			} else {
				$email_receive_from = 'no-reply@' . WEBSITE_DOMAIN;
			}

			$phpmailer->Host       = '' . $email_host . '';
			$phpmailer->Port       = $email_port;
			$phpmailer->Username   = '' . $email_username . '';
			$phpmailer->Password   = '' . $email_password . '';
			$phpmailer->SMTPAuth   = true;
			$phpmailer->SMTPSecure = '' . $email_security . '';
			$phpmailer->From       = '' . $email_receive_from . '';

			$phpmailer->IsSMTP();
		}
	}
}

// create options page for ACF
if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page( array(
		'page_title' => 'Contact Form',
		'menu_title' => 'Contact Form',
		'menu_slug'  => 'contact-form',
		'capability' => 'edit_posts',
		'redirect'   => false
	) );

}

if ( function_exists( 'acf_add_local_field_group' ) ):

	acf_add_local_field_group( array(
		'key'                   => 'group_58f617c953719',
		'title'                 => 'Contact Form SMTP Options',
		'fields'                => array(
			array(
				'key'               => 'field_58f627cf9ebae',
				'label'             => 'Use SMTP?',
				'name'              => 'use_smtp',
				'type'              => 'true_false',
				'instructions'      => 'This will override PHPmailer function to use SMTP',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'message'           => 'Check box to activate',
				'default_value'     => 0,
				'ui'                => 0,
				'ui_on_text'        => '',
				'ui_off_text'       => '',
			),
			array(
				'key'               => 'field_58f6189164a2e',
				'label'             => 'Send to Email Address:',
				'name'              => 'smtp_receive_emails',
				'type'              => 'email',
				'instructions'      => 'What email address do you want to receive emails to.',
				'required'          => 1,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_58f627cf9ebae',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
			),
			array(
				'key'               => 'field_58f618f0cd2b0',
				'label'             => 'From Email Address:',
				'name'              => 'smtp_from_email_address',
				'type'              => 'email',
				'instructions'      => 'Sets From: address for outgoing messages. (if you leave blank default no-reply address will be used)',
				'required'          => 0,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_58f627cf9ebae',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
			),
			array(
				'key'               => 'field_58f619731238a',
				'label'             => 'SMTP server address:',
				'name'              => 'smtp_server_address',
				'type'              => 'text',
				'instructions'      => 'Example: smtp.gmail.com or smtp.mailgun.org',
				'required'          => 1,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_58f627cf9ebae',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
			),
			array(
				'key'               => 'field_58f61a2f7b22f',
				'label'             => 'SMTP server port:',
				'name'              => 'smtp_server_port',
				'type'              => 'text',
				'instructions'      => 'Default for gmail and mail gun is \'465\'',
				'required'          => 1,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_58f627cf9ebae',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
			),
			array(
				'key'               => 'field_58f61a983b605',
				'label'             => 'SMTP Username:',
				'name'              => 'smtp_username',
				'type'              => 'email',
				'instructions'      => 'Example: johndoe@gmail.com',
				'required'          => 1,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_58f627cf9ebae',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
			),
			array(
				'key'               => 'field_58f61ad014a15',
				'label'             => 'SMTP password:',
				'name'              => 'smtp_password',
				'type'              => 'password',
				'instructions'      => '',
				'required'          => 1,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_58f627cf9ebae',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'readonly'          => 0,
				'disabled'          => 0,
			),
			array(
				'key'               => 'field_58f61b3bf39c7',
				'label'             => 'SMTP Security type:',
				'name'              => 'smtp_security',
				'type'              => 'radio',
				'instructions'      => '',
				'required'          => 1,
				'conditional_logic' => array(
					array(
						array(
							'field'    => 'field_58f627cf9ebae',
							'operator' => '==',
							'value'    => '1',
						),
					),
				),
				'wrapper'           => array(
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'choices'           => array(
					'ssl' => 'SSL',
					'tls' => 'TSL',
				),
				'allow_null'        => 0,
				'other_choice'      => 0,
				'save_other_choice' => 0,
				'default_value'     => '',
				'layout'            => 'vertical',
				'return_format'     => 'value',
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'contact-form',
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => 1,
		'description'           => '',
	) );

endif;