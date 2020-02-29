<?php
define("BASE", __DIR__ . "/");
require_once "_core.php";
if(isset($_POST["submit"], $_POST["code"], $_POST["key"])) {
	$code=$_POST["code"];
	$key=$_POST["key"];
	$code=decode($code, $key);
	print $code."<hr>";
}
?>
<h1>Decoder String</h1>
<h2>By Max Base</h2>
<p>You can write implement of this deoder in Java if you want to use this API in your android applications!</p>
<form action="" method="POST">
Key: <input type="text" name="key" value="x1x1x1x1x1x1"><br>
Data:<br>
<textarea cols="100" rows="20" name="code"></textarea>
<br>
<button name="submit">Decode</button>
</form>
