<?php

defined('BASEPATH') or exit('No direct script access allowed');

class BackupController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('file');
		$this->load->library('email');
	}

	public function database_backup()
	{
		// Load the database utility class
		$this->load->dbutil();

		// Backup your entire database and assign it to a variable
		$prefs = array(
			'format' => 'zip',
			'filename' => 'db_ecopack_database.sql' // Filename inside the zip
		);

		$backup = $this->dbutil->backup($prefs);

		// Save the file to a directory
		$backup_filename = 'backup-on-' . date('Y-m-d') . '.zip';
		$backup_path = FCPATH . 'backups/' . $backup_filename; // Save to 'backups' folder in your project root
		write_file($backup_path, $backup);

		// Email the backup file
		$this->email->from('parikachevier2013@gmail.com', 'Ecopack services PVT LTD');
		$this->email->to('support@ecopackservices.com');
		$this->email->subject('Database Backup - ' . date('Y-m-d'));
		$this->email->message('Please find the database backup attached.');
		$this->email->attach($backup_path);

		if ($this->email->send()) {
			echo "Backup and email sent successfully!";
		} else {
			echo "Failed to send email.";
		}
	}
}
