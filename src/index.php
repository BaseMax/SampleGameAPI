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
	if(isset($headers["Token"])) {
		$token=$headers["Token"];
		$developer=$db->select("developer", ["token"=>$token]);
		// print_r($app);
		if($developer == null) {
			display(["status"=>"failed", "message"=>"This token is not valid!"]);
		}
		else {
			$data=$_GET;
			foreach($_POST as $key=>$value) {
				$data[$key]=$value;
			}
			if(isset($data["method"])) {
				$method=$data["method"];
				if($method == "highScore") {
					if(isset($data["packageName"])) {
						$packageName=$data["packageName"];
						$clauses=[
							"packageName"=>$packageName,
						];
						if($db->count("app", $clauses) == 0) {
							display(["status"=>"failed", "message"=>"Cannot create a user in a wrong application!"], $app);
						}
						$app=$db->select("app", $clauses);
						$clauses=["appID"=>$app["id"]];
						// $scores=$db->selects("score", $clauses, "ORDER BY `value` DESC");// Need `LIMIT 500`
						$scores=$db->selectsRaw("select value from `".$db->db."`.`score` ORDER BY `value` DESC");// Need `LIMIT 500`
						$count=count($scores);
						if($count == 0) {
							$hightest=null;
							$lowest=null;
						}
						else {
							$hightest=$db->select("score", $clauses, "ORDER BY `value` DESC")["value"];
							$lowest=$db->select("score", $clauses, "ORDER BY `value` ASC")["value"];
						}
						display(["status"=>"success", "message"=>"You get list as below...", "result"=>[
							"list"=>$scores,
							"count"=>$count,
							"hightest"=>$hightest,
							"lowest"=>$lowest,
						]], $app);
					}
					else {
						display(["status"=>"failed", "message"=>"Cannot verify you without passing packageName!"], $app);
					}
				}
				else if($method == "submitScore") {
					if(isset($data["packageName"], $data["device"], $data["version"], $data["email"], $data["session"], $data["value"])) {
						$packageName=$data["packageName"];
						$version=$data["version"];
						$device=$data["device"];
						$email=$data["email"];
						$session=$data["session"];
						$value=(int) $data["value"];
						$clauses=[
							"packageName"=>$packageName,
						];
						if($db->count("app", $clauses) == 0) {
							display(["status"=>"failed", "message"=>"Cannot create a user in a wrong application!"], $app);
						}
						$app=$db->select("app", $clauses);
						$clauses=["email"=>$email, "appID"=>$app["id"]];
						if($db->count("user", $clauses) == 0) {
							display(["status"=>"failed", "message"=>"Email not exists!"], $app);
						}
						$user=$db->select("user", $clauses);
						$clauses=[
							"userID"=>$user["id"],
							"appID"=>$app["id"],
							"session"=>$session,
						];
						if($db->count("verify", $clauses) == 0) {
							display(["status"=>"failed", "message"=>"You are not a valid member!"], $app);
						}
						$verify=$db->select("verify", [
							"userID"=>$user["id"],
							"appID"=>$app["id"],
							"session"=>$session,
						], "ORDER BY `id` DESC");
						if($verify["hasUse"] != 1) {
							display(["status"=>"failed", "message"=>"You are not a valid member!"], $app);
						}
						$db->insert("score", [
							"appID"=>$app["id"],
							"userID"=>$user["id"],
							"session"=>$session,
							"value"=>$value,
						]);
						display(["status"=>"success", "message"=>"Great, Enjoy!"], $app);
					}
					else {
						display(["status"=>"failed", "message"=>"Cannot verify you without passing device, version, packageName, email, session and value!"], $app);
					}
				}
				else if($method == "authUser") {
					if(isset($data["packageName"], $data["device"], $data["version"], $data["email"], $data["code"])) {
						$packageName=$data["packageName"];
						$version=$data["version"];
						$device=$data["device"];
						$email=$data["email"];
						$code=$data["code"];
						$clauses=[
							"packageName"=>$packageName,
						];
						if($db->count("app", $clauses) == 0) {
							display(["status"=>"failed", "message"=>"Cannot create a user in a wrong application!"], $app);
						}
						$app=$db->select("app", $clauses);
						$clauses=["email"=>$email, "appID"=>$app["id"]];
						if($db->count("user", $clauses) == 0) {
							display(["status"=>"failed", "message"=>"Email not exists!"], $app);
						}
						$user=$db->select("user", $clauses);
						$verify=$db->select("verify", [
							"appID"=>$app["id"],
							"userID"=>$user["id"],
						], "ORDER BY `id` DESC");
						if($verify == null || ! is_array($verify) || count($verify) == 0) {
							display(["status"=>"failed", "message"=>"Cannot find one session for you recently!"], $app);
						}
						if($code == $verify["code"] and $verify["hasUse"] == 0) {
							$db->update("verify", ["id"=>$verify["id"]], ["hasUse"=>1]);
							display(["status"=>"success", "message"=>"Wellcome!", "result"=>[
								"session"=>$verify["session"],
							]], $app);
						}
						else {
							// if($verify["hasUse"] != -1 and $verify["hasUse"] != 1) {
							if($verify["hasUse"] == 0) {
								$db->update("verify", ["id"=>$verify["id"]], ["hasUse"=>-1]);
							}
							display(["status"=>"failed", "message"=>"You not have this premission to do this task!"], $app);
						}
					}
					else {
						display(["status"=>"failed", "message"=>"Cannot verify you without passing device, version, packageName, email and code!"], $app);
					}
				}
				if($method == "loginUser") {
					if(isset($data["packageName"], $data["device"], $data["version"], $data["email"])) {
						$packageName=$data["packageName"];
						$version=$data["version"];
						$device=$data["device"];
						$email=$data["email"];
						$clauses=[
							"packageName"=>$packageName,
						];
						if($db->count("app", $clauses) == 0) {
							display(["status"=>"failed", "message"=>"Cannot create a user in a wrong application!"], $app);
						}
						$app=$db->select("app", $clauses);
						$clauses=["email"=>$email, "appID"=>$app["id"]];
						if($db->count("user", $clauses) == 0) {
							display(["status"=>"failed", "message"=>"Email not exists!"], $app);
						}
						$user=$db->select("user", $clauses);
						$values=[
							"userID"=>$user["id"],
							"appID"=>$app["id"],
							"code"=>string("0123456789abcdef", 5),
							"hasUse"=>0,
							"session"=>string("abcdefghijklmnopqrstuvwxyz0123456789", 50),
						];
						$verifyID=$db->insert("verify", $values);
						$verify=$db->select("verify", ["id"=>$verifyID]);
						// send email to $email with $verify["code"]...
						// Note: You can complete this part of code!
						display(["status"=>"success", "message"=>"successfully created!", "result"=>[
							"email"=>$email,
						]], $app);
					}
					else {
						display(["status"=>"failed", "message"=>"Cannot login as a user without passing device, version, packageName and email!"], $app);
					}
				}
				else if($method == "registerUser") {
					if(isset($data["packageName"], $data["device"], $data["version"], $data["email"])) {
						$packageName=$data["packageName"];
						$version=$data["version"];
						$device=$data["device"];
						$email=$data["email"];
						$clauses=[
							"packageName"=>$packageName,
						];
						if($db->count("app", $clauses) == 0) {
							display(["status"=>"failed", "message"=>"Cannot create a user in a wrong application!"], $app);
						}
						$app=$db->select("app", $clauses);
						if($db->count("user", ["email"=>$email, "appID"=>$app["id"]]) > 0) {
							display(["status"=>"failed", "message"=>"Cannot create a user with dublicate email address!"], $app);
						}
						$values=[
							"appID"=>$app["id"],
							"email"=>$email,
							"deviceInformation"=>$device,
							"appVersion"=>$version,
							// "ip"=>getIpAddr(),
							// "userAgent"=>getUserAgent(),

							// Note: publicKey, privateKey will use to enc and dec the data between server and clients! (such as : Android, Java and others)
							"publicKey"=>string("abcdefghijklmnopqrstuvwxyz0123456789", 50),
							"privateKey"=>string("abcdefghijklmnopqrstuvwxyz0123456789", 50),
							"token"=>string("abcdefghijklmnopqrstuvwxyz0123456789", 50),
						];
						$db->insert("user", $values);
						$user=$db->select("user", $values);
						display(["status"=>"success", "message"=>"successfully created!", "result"=>[
							"publicKey"=>$user["publicKey"],
							"token"=>$user["token"],
						]], $app);
					}
					else {
						display(["status"=>"failed", "message"=>"Cannot create a user without passing device, version, packageName and email!"], $app);
					}
				}
				else if($method == "createApp") {
					if(isset($data["packageName"])) {
						// $developerToken=$data["token"];
						// if($db->count("developer", ["token"=>$developerToken]) == 0) {
						// 	display(["status"=>"failed", "message"=>"You are not a valid developer!"], $app);
						// }
						// $developer=$db->select("developer", ["token"=>$developerToken]);
						$packageName=$data["packageName"];
						$clauses=[
							"packageName"=>$packageName,
						];
						if($db->count("app", $clauses) == 0) {
							$values=$clauses;
							$values["developerID"]=$developer["id"];
							// Note: publicKey, privateKey will use to enc and dec the data between server and clients! (such as : Android, Java and others)
							$values["publicKey"]=string("abcdefghijklmnopqrstuvwxyz0123456789", 50);
							$values["privateKey"]=string("abcdefghijklmnopqrstuvwxyz0123456789", 50);
							$values["token"]=string("abcdefghijklmnopqrstuvwxyz0123456789", 50);
							$appID=$db->insert("app", $values);
							$app=$db->select("app", $clauses);
							display(["status"=>"success", "message"=>"successfully created!", "result"=>[
								"publicKey"=>$app["publicKey"],
								"token"=>$app["token"],
							]], $app);
						}
						else {
							display(["status"=>"failed", "message"=>"Cannot create an app with dublicate package name!"], $app);
						}
					}
					else {
						display(["status"=>"failed", "message"=>"Cannot create an app without passing package name!"], $app);
					}
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
