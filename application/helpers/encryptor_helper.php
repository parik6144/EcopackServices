<?php
// application/helpers/encryptor_helper.php

if ( ! function_exists('encryptor'))
{
	function encryptor($action, $string) {
		$output = false;

		$encrypt_method = "AES-256-CBC";
		// Set your secret key and secret iv
		$secret_key = 'Your_Secret_Key_Here'; // CHANGE THIS TO A STRONG, UNIQUE KEY
		$secret_iv = 'Your_Secret_IV_Here';   // CHANGE THIS TO A STRONG, UNIQUE IV (16 characters for AES-256-CBC)

		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);

		if ( $action == 'encrypt' ) {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		} else if( $action == 'decrypt' ) {
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}

		return $output;
	}
}
