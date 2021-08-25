<?php
// router.php

//<html><body><pre><?php print_r($_SERVER ); </pre>

if (preg_match('/\.(?:mp4|mp3|wav)$/', $_SERVER["SCRIPT_FILENAME"])) {
	$file = $_SERVER["SCRIPT_FILENAME"];
	$path = pathinfo($_SERVER["SCRIPT_FILENAME"]);
	$fm=@fopen($_SERVER["SCRIPT_FILENAME"],'rb');
	
	if(!$fm) {
	  // You can also redirect here
	  header ("HTTP/1.0 404 Not Found");
	  return ( true );
	}
	
	$size   = filesize($file); // File size
	$length = $size;           // Content length
	$begin  = 0;               // Start byte
	$end    = $size - 1;       // End byte
	/*
	if(isset($_SERVER['HTTP_RANGE']))
	{
	  if(preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches)) {
		$begin=intval($matches[0]);
		if(!empty($matches[1])) {
		  $end=intval($matches[1]);
		}
	  }
	}
	*/
	
	if ( $begin > 0 || $end < ($size-1))
	  header('HTTP/1.0 206 Partial Content');
	else
	  header('HTTP/1.0 200 OK');
  
	header("Content-Type: video/mp4");
	header('Accept-Ranges: bytes');
	header('Content-Length:'.($end-$begin));
	header("Content-Disposition: inline;");
	header("Content-Range: bytes $begin-$end/$size");
	header("Content-Transfer-Encoding: binary\n");
	header('Connection: close');
	$cur=$begin;
	fseek($fm,$begin,0);

	while ( !feof($fm) && $cur<$end && (connection_status()==0))
	{ 
		print fread($fm,min(1024*16,$end-$cur));
		$cur+=1024*16;
		usleep(1000);
	}

    //printf("<pre>%s</pre>\n", print_r($_SERVER, TRUE ) );
//Connection: close
//Content-Length: 976600
//Content-Type: video/mp4
//Date: Tue, 24 Aug 2021 18:52:18 GMT
//Host: 192.168.1.36:8081

//	header("Content-Range: bytes");
	//readfile($_SERVER["SCRIPT_FILENAME"]);
	return ( true );
} else { 
    return false;    // serve the requested resource as-is.
}
/* */
?>