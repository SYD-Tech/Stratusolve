<?php
/**
 * This script is to be used to receive a POST with the object information and then either updates, creates or deletes the task object
 */
require('task.class.php');
// Assignment: Implement this script

$taskName = (isset($_POST['taskName'])) ? $_POST['taskName'] : null;
$taskDescription = (isset($_POST['taskDescription'])) ? $_POST['taskDescription'] : null;
$currentTaskId = (isset($_POST['currentTaskId'])) ? $_POST['currentTaskId'] : null;
$action = (isset($_POST['action'])) ? $_POST['action'] : null;


switch($action) {
	case 'save':
		$task = new Task($currentTaskId,$taskName,$taskDescription);
		break;
	case 'delete':
		$task = new Task($currentTaskId);
		$task->Delete();
		break;
	default:
		break;
}

$task->Save();