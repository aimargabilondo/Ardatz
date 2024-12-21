<?php

// A module to write out events to a set of log files. Similar to error_log(),
// but with multiple output files.
//
// You'll need to set up a directory that the process running PHP (eg Apache) has
// permission to write to. You'll also need to keep an eye on the size of the log
// files, rotate out old ones once they get too large, etc.
//
// By Pete Warden ( http://petewarden.typepad.com ) - freely reusable with no restrictions

// Edit this to set it to the folder on your server where you want the logs to live
//define('CUSTOM_LOG_ROOT_DIRECTORY', '/private/var/log/apache2/'); // OS X default Apache log directory
define('CUSTOM_LOG_ROOT_DIRECTORY', '/mnt/data/remesak_log/');

$g_custom_log_categories = array();
$g_custom_log_shutdown_registered = false;

// This function works like error_log(), but takes an extra category argument that
// determines which file the message is appended to.
function custom_log($category, $message)
{
	global $g_custom_log_categories;
	
	// If the file hasn't been opened for appending yet, create a new file handle
	if (!isset($g_custom_log_categories[$category]))
	{
		// Make sure there's no shenanigans with special characters like ../ that
		// could be abused to write outside of the specified directory
		$sanitizedcategory = preg_replace('/[^a-zA-Z0-9.]/', '_', $category);
		$filename = CUSTOM_LOG_ROOT_DIRECTORY.$sanitizedcategory;
		$filehandle = fopen($filename, 'a');
		if (empty($filehandle))
		{
			error_log("Failed to open file '$filename' for appending");
			return;
		}

		// To close any open files once the script is done, and so ensure that
		// all the messages are written to disk, register a global shutdown
		// function that fclose()'s any open handles
		global $g_custom_log_shutdown_registered;
		if (!$g_custom_log_shutdown_registered)
		{
			register_shutdown_function('custom_log_on_shutdown');
			$g_custom_log_shutdown_registered = true;
		}
		
		// Urghh, this is required to prevent a spew of warnings when more recent
		// PHP versions are set to strict errors
		if (!ini_get('date.timezone'))
			date_default_timezone_set('UTC');
		
		$g_custom_log_categories[$category] = array('filehandle' => $filehandle);
	}

	// Create the full message and append it to the file
	$categoryinfo = $g_custom_log_categories[$category];	
	$filehandle = $categoryinfo['filehandle'];
	
	$timestring = date('D M j H:i:s Y');
	$ipaddress = $_SERVER['REMOTE_ADDR'];
	//$fullmessage = "[$timestring] [$category] [client $ipaddress] $message\n";
	$fullmessage = "[$timestring] [$ipaddress] $message\n";
	
	fwrite($filehandle, $fullmessage);
}

// A clean-up function called to make sure all open file handles are closed
function custom_log_on_shutdown()
{
	global $g_custom_log_categories;
	foreach ($g_custom_log_categories as $category => $categoryinfo)
		fclose($categoryinfo['filehandle']);
}

?>