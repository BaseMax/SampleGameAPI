<?php
if(!defined("BASE")) {
	exit();
}
require_once "_phpedb.php";
$db=new database();
$db->connect("localhost", "root", "linuxconfig.org");
$db->db="googlegame";
$db->create_database($db->db, false);

// Sorry: pecl/mcrypt requires PHP (version >= 7.2.0, version <= 7.3.0, excluded versions: 7.3.0), installed version is 7.4.3
// function encrypt($data, $key) {
// 	return rtrim(
// 		base64_encode(
// 			mcrypt_encrypt(
// 				MCRYPT_RIJNDAEL_256,
// 				$key, $data,
// 				MCRYPT_MODE_ECB,
// 				mcrypt_create_iv(
// 					mcrypt_get_iv_size(
// 						MCRYPT_RIJNDAEL_256,
// 						MCRYPT_MODE_ECB
// 					),
// 					MCRYPT_RAND)
// 				)
// 			), "\0"
// 		);
// }
// function decrypt($data, $key) {
// 	return rtrim(
// 		mcrypt_decrypt(
// 			MCRYPT_RIJNDAEL_256,
// 			$key,
// 			base64_decode($data),
// 			MCRYPT_MODE_ECB,
// 			mcrypt_create_iv(
// 				mcrypt_get_iv_size(
// 					MCRYPT_RIJNDAEL_256,
// 					MCRYPT_MODE_ECB
// 				),
// 				MCRYPT_RAND
// 			)
// 		), "\0"
// 	);
// }

// # The Base64 index table:
// I    Binary Char		I 	Binary	Char	I	Binary	Char	I	Binary	Char
// 0	000000	A		16	010000	Q		32	100000	g		48	110000	w
// 1	000001	B		17	010001	R		33	100001	h		49	110001	x
// 2	000010	C		18	010010	S		34	100010	i		50	110010	y
// 3	000011	D		19	010011	T		35	100011	j		51	110011	z
// 4	000100	E		20	010100	U		36	100100	k		52	110100	0
// 5	000101	F		21	010101	V		37	100101	l		53	110101	1
// 6	000110	G		22	010110	W		38	100110	m		54	110110	2
// 7	000111	H		23	010111	X		39	100111	n		55	110111	3
// 8	001000	I		24	011000	Y		40	101000	o		56	111000	4
// 9	001001	J		25	011001	Z		41	101001	p		57	111001	5
// 10	001010	K		26	011010	a		42	101010	q		58	111010	6
// 11	001011	L		27	011011	b		43	101011	r		59	111011	7
// 12	001100	M		28	011100	c		44	101100	s		60	111100	8
// 13	001101	N		29	011101	d		45	101101	t		61	111101	9
// 14	001110	O		30	011110	e		46	101110	u		62	111110	+
// 15	001111	P		31	011111	f		47	101111	v		63	111111	/
// Padding	=

function encode($array, $key) {
	$key=trim($key);
	print $key."\n";
	$data=json_encode($array);
	$data=strrev($data);
	$table=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	array_push($table, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, '+', '/');
	array_push($table, '=');
	// Table has 64+1 = 65 chars! // print count($table);
	// print_r($table);
	// print "\n";
	// print mb_substr($key, 0, 65)."\n";
	if($key == "") {
		$key=strrev("abc0def4g5h6i7j8k6lm3op");
	}
	// $key=str_pad($key, 65, $key);
	// // print $key."\n";
	// // print mb_strlen($key)."\n";
	// $newTable=[];
	// for($i=0;$i<65;$i++) {
	// 	// $newTable[]=$i.mb_substr($key, $i, 1);
	// 	$newTable[]="'$i".mb_substr($key, $i, 1)."'";
	// }

	$newTable=[];
	$keyL=mb_strlen($key);
	for($i=0;$i<$keyL;$i++) {
		$newTable[]="'$i".mb_substr($key, $i, 1)."'";
	}

	$table=array_splice($table, 0, $keyL);

	print_r($table);
	print_r($newTable);

	$data=base64_encode($data);
	print $data."\n";
	$data=str_replace($table, $newTable, $data);
	print $data."\n";
	$data=strrev($data);
	$length=mb_strlen($data);
	// if($length % 2 == 0){} else {}
	$offset=$length/2;
	// print $data."\n";
	$data=mb_substr($data, $offset) . mb_substr($data, 0, $offset);
	$data=base64_encode($data);
	return $data;
}

function decode($data, $key) {
	$key=trim($key);
	print $key."\n";
	$data=trim($data);
	$data=base64_decode($data);
	$length=mb_strlen($data);
	// if($length % 2 == 0){} else {}
	$offset=$length/2;
	$data=mb_substr($data, $offset) . mb_substr($data, 0, $offset);
	$data=strrev($data);
	$table=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	array_push($table, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, '+', '/');
	array_push($table, '=');
	if($key == "") {
		$key=strrev("abc0def4g5h6i7j8k6lm3op");
	}
	// $key=str_pad($key, 65, $key);
	// // print $key."\n";
	// // print mb_strlen($key)."\n";
	// $newTable=[];
	// for($i=0;$i<=65;$i++) {
	// 	// $newTable[]=$i.mb_substr($key, $i, 1);
	// 	$newTable[]="'$i".mb_substr($key, $i, 1)."'";
	// }

	$newTable=[];
	$keyL=mb_strlen($key);
	// for($i=0;$i<$keyL;$i++) {
	for($i=$keyL-1;$i>=0;$i--) {
		// $newTable[]=mb_substr($key, $i, 1);
		$newTable[]="'$i".mb_substr($key, $i, 1)."'";
	}

	// print_r($newTable);
	// print_r($table);
	$table=array_splice($table, 0, $keyL);
	$table=array_reverse($table);
	print $data."\n";
	print_r($newTable);
	print_r($table);
	$data=str_replace($newTable, $table, $data);
	$data=base64_decode($data);
	$data=strrev($data);
	return $data;
}

function display($array, $app=null) {
	if($app == null) {
		header("Content-Type: application/json");
		exit(json_encode($array));
	}
	else {
		header("Content-Type: application/json");
		exit(json_encode($array));
		// header("Content-Type: text/html");
		// exit(encode($array, $app["privateKey"]));
	}
}

function string($input, $length = 5) {
	$lengths = strlen($input);
	$output = "";
	for($i = 0; $i < $length; $i++) {
		$output .= $input[mt_rand(0, $lengths - 1)];
	}
	return $output;
}
