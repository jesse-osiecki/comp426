<?php
include_once 'email-class.php';

$path_components = explode('/', $_SERVER['PATH_INFO']);

// Note that since extra path info starts with '/'
// First element of path_components is always defined and always empty.

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  // GET means either instance look up, index generation, or deletion
  // Following matches instance URL in form
  // /rest.php/<id>

  if ((count($path_components) >= 2) &&
      ($path_components[1] != "")) {

    // Interpret <id> as integer
    $email_id = intval($path_components[1]);

    // Look up object via ORM
    $email = emailclass::_get_email_by_id($email_id);

    if ($email == null) {
      // email not found.
      header("HTTP/1.0 404 Not Found");
      print("email id: " . $email_id . " not found.");
      exit();
    }

    // Check to see if deleting
    if (isset($_REQUEST['delete'])) {
      $email->delete();
      header("Content-type: application/json");
      print(json_encode(true));
      exit();
    } 

    // Normal lookup.
    // Generate JSON encoding as response
    header("Content-type: application/json");
    print($email->getJSON());
    exit();

  }

  // ID not specified, then must be asking for index
  header("Content-type: application/json");
  print(json_encode(emailclass::_getAllIDs()));
  exit();

} 
else if ($_SERVER['REQUEST_METHOD'] == "POST") {

  // Either creating or updating

  // Following matches /rest.php/<id> form
  if ((count($path_components) >= 2) &&
      ($path_components[1] != "")) {

    //Interpret <id> as integer and look up via ORM
    $email_id = intval($path_components[1]);
    $email = emailclass::_get_email_by_id($email_id);

    if ($email == null) {
      // email not found.
      header("HTTP/1.0 404 Not Found");
      print("email id: " . $email_id . " not found while attempting update.");
      exit();
    }

    // Validate values
    $new_from = false;
    if (isset($_REQUEST['from'])) {
      $new_from = trim($_REQUEST['from']);
      if ($new_from == "") {
	header("HTTP/1.0 400 Bad Request");
	print("Bad from");
	exit();
      }
    }

    $new_cc = false;
    if (isset($_REQUEST['cc'])) {
      $new_cc = trim($_REQUEST['cc']);
    }

    $new_to = false;
    if (isset($_REQUEST['to'])) {
      $new_to = trim($_REQUEST['to']);
      if ($new_to == "") {
	header("HTTP/1.0 400 Bad Request");
	print("Bad to");
	exit();
      }
    }

    $new_body = false;
    if (isset($_REQUEST['body'])) {
      $new_note = trim($_REQUEST['body']);
    }


    $new_date = false;
    $new_date_obj = null;
    if (isset($_REQUEST['date'])) {
      $new_date = true;
      $date_str = trim($_REQUEST['date']);
      if ($date_str != "") {
	$new_date_obj = new DateTime($date_str);
      }
    }


    // Update via ORM
    if ($new_from != false) {
      $email->setFrom($new_from);
    }
    if ($new_cc != false) {
      $email->setCC($new_cc);
    }
    if ($new_to != false) {
      $email->setTO($new_to);
    }
    if ($new_date) {
      $email->setTime($new_date_obj);
    }
    if ($new_body != false) {
      $email->setBody($new_body);
    }
    
    // Return JSON encoding of updated email
    header("Content-type: application/json");
    print($email->getJSON());
    exit();
  } 
  else {

    // Creating a new email item
    

    $from = "";
    if (isset($_REQUEST['from'])) {
      $from = trim($_REQUEST['from']);
    }

    $to = "";
    if (isset($_REQUEST['to'])) {
      $to = trim($_REQUEST['to']);
    }
    $cc = "";
    if (isset($_REQUEST['cc'])) {
      $cc = trim($_REQUEST['cc']);
    }

    $date = "";
    if (isset($_REQUEST['date'])) {
      $date = trim($_REQUEST['date']);
    }
    $message = "";
    if (isset($_REQUEST['message'])) {
      $message = trim($_REQUEST['message']);
    }

    // Create new email via ORM
    $new_email = emailclass::_create_email($from, $to, $cc, $date, $message);

    // Report if failed
    if ($new_email == null) {
      header("HTTP/1.0 500 Server Error");
      print("Server couldn't create new email");
      exit();
    }
    
    //Generate JSON encoding of new email
    header("Content-type: application/json");
    print($new_email->getJSON());
    exit();
  }
}

// If here, none of the above applied and URL could
// not be interpreted with respect to RESTful conventions.

header("HTTP/1.0 400 Bad Request");
print("Did not understand URL");

?>
