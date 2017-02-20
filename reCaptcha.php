<?php
/*
  reCaptcha validator

*/

//initial variables
$key;
$secret = $param;
$user_ip = $_SERVER['REMOTE_ADDR'];
$response_string = $value;
$result;


//checks for errors
if(empty($secret)){
  $validator->addError($key,'No secret or private key given');
	return false;
}
if(empty($response_string)){
  $validator->addError($key,'No value was submitted for the captcha.');
	return false;
}

//urlencode vars
$secret = urlencode($secret);
$user_ip = urlencode($user_ip);
$response_string = urlencode($response_string);

//check for validation via cURL
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$response_string.'&remoteip='.$user_ip
));

//get results
$result = curl_exec($curl);

//close request
curl_close($curl);

//if $result is not false
	if($result){
		$resultObject = json_decode($result);
		if($resultObject->success){
			//success
			return true;
		}else{
			//errorCode to error handeling
			foreach($resultObject->error-codes as $errorCode){
				switch($errorCode){
					case 'missing-input-secret':
            $validator->addError($key,'The secret parameter is missing.');
						break;
					case 'invalid-input-secret':
            $validator->addError($key,'The secret parameter is invalid or malformed.');
						break;
					case 'missing-input-response':
            $validator->addError($key,'The response parameter is missing.');
						break;
					case 'invalid-input-response':
            $validator->addError($key,'The response parameter is invalid or malformed.');
						break;
					default:
            $validator->addError($key,'Unknown error: '.$errorCode);
						break;
				}
				return false;
			}
		}
	}else{
    $validator->addError($key,'There was an error executing your request');
		return false;
	}

?>
