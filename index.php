<?php
define("BASE", __DIR__ . "/");
require_once "_core.php";

if(!function_exists("getallheaders")) {
	// Probably you are in CLI and it's not usefull!
	// But sometimes it's usefull for some webserver!
	function getallheaders() {
		$headers = [];
		foreach($_SERVER as $name => $value) {
			if(substr($name, 0, 5) == "HTTP_") {
				$headers[str_replace(" ", "-", ucwords(strtolower(str_replace("_", " ", substr($name, 5)))))] = $value;
			}
		}
		return $headers;
	}
}

$headers=getallheaders();
if($headers != null && is_array($headers) and count($headers) > 0) {
	if(isset($headers["Token"]) and isset($headers["Key"])) {
		$key=$headers["Key"];
		$token=$headers["Token"];
		$app=$db->select("app", ["token"=>$token, "publicKey"=>$key]);
		// print_r($app);
		if($app == null) {
			display(["status"=>"failed", "message"=>"This token and key is not valid!"]);
		}
		else {
			$data=$_GET;
			foreach($_POST as $key=>$value) {
				$data[$key]=$value;
			}
			if(isset($data["method"])) {
				$method=$data["method"];
				if($method == "total") {
				}
			}
			else {
				display(["status"=>"failed", "message"=>"Every request in this webservice need a method type!"], $app);
			}
		}
	}
	else {
		display(["status"=>"failed", "message"=>"You did not have access to this webservice without token and key!"]);
	}
}
else {
	display(["status"=>"failed", "message"=>"You did not have access to this webservice!"]);
}
