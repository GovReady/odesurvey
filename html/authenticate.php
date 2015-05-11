<?php
session_start();

// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require ('credentials.inc.php');
require ('vendor/parse.com-php-library/parse.php');

echo PARSE_APPLICATION_ID;
// echo APPLICATION_ID;

// test values
$_GET['u'] = 'greg'; $_GET['pw'] = 'xxxxxx';


$loginUser = new parseUser;
$loginUser->username = $_GET['u'];
$loginUser->password = $_GET['pw'];


print_r($loginUser);


try {
    $return = $loginUser->login();
    // print_r($return);
    if ($return->objectId) {
    	// echo "logged in";
    	$_SESSION['sessionToken'] = $return->sessionToken;
    	$_SESSION['objectId']     = $return->objectId;
    	$_SESSION['username']     = $return->username;
    	$_SESSION['createdAt']    = $return->createdAt;
    }
    $data = $return;

} catch (Exception $e) {
    // echo 'Caught exception: ',  $e->getMessage(), "\n";
    $_SESSION['sessionToken'] = null;
    $_SESSION['objectId']     = null;
    $_SESSION['username']     = null;
    $_SESSION['error']        = $e->getMessage();

    $data['sessionToken'] = null;
    $data['objectId']     = null;
    $data['username']     = null;
    $data['error']        = $e->getMessage();
}


echo "<br> here ==========<br>";
print_r($loginUser);
echo "<br> here ==========<br>";
print_r($data);
exit;

// header('Content-Type: application/json');
// echo json_encode($data);
// exit();

?>