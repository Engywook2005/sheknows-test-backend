<?php

include '../lib/mysql_connect.php';

class ReceivePixel {
	
	function __construct($getArray, $domain, $dbUser, $dbPass, $db) {
		$this-> getArray = $getArray;
		$this-> logPixel($domain, $dbUser, $dbPass, $db);
	}

	//http://localhost:82/pixel.php?pageTitle=test&hostName=localhost&fromIframe=0&ipAdress=127.0.0.1&invokedOrder=0
	public function logPixel($domain, $dbUser, $dbPass, $db) {
		$pageTitle = $this->getArray['pageTitle'];
		$hostName = $this->getArray['hostName'];
		$fromIframe = $this->getArray['fromIframe'];
		$ipAdress = $_SERVER['REMOTE_ADDR'];
		$invokedOrder = $this->getArray['invokedOrder'];
		$conn = mysqli_connect($domain, $dbUser, $dbPass, $db) or die('Error connecting to MySQL server.');
		$insertQuery = "INSERT INTO tags (timestamp, pageTitle, hostName, fromIframe, ipAdress, invokedOrder) VALUES (current_timestamp(), '$pageTitle', '$hostName', $fromIframe, '$ipAdress', $invokedOrder);";
		//echo $insertQuery;
		$conn->query($insertQuery);
		$conn->close();
		$image = imagecreatetruecolor(0, 1);
        $bg = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image, 0, 0, 1, 1, $bg);
        //var_dump($pointValues);
        header('Content-type: image/gif');
        imagegif($image);
        imagedestroy($image);

	}


	/*
	INSERT INTO tags
    (timestamp, pageTitle, hostName, fromIframe, ipAdress, invokedOrder)
    VALUES
    (
    current_timestamp(),
    "test page title",
    "locahost:82",
    0,
    "127.0.0.1",
    0
    )
	*/

	//TODO - respond with 1x1


}

$receivePixel = new ReceivePixel($_GET, $domain, $dbUser, $dbPass, $db);


?>