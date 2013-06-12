<?php
	session_start();
	$redirect=$_GET['q'];
	$user=$_SESSION['user'];
	mysql_connect('10.246.16.182','followtumblr_co','bi') or die("invalid user");
	mysql_select_db("followtumblr_co");
	$sql="SELECT * FROM users WHERE name='".$user."'";
	$res=mysql_query($sql);
	$row=mysql_fetch_array($res);
	$points=$row['points']+1;
	$sql="UPDATE users SET points='".$points."' WHERE name='".$user."'";
	mysql_query($sql);
	header('Location: '.$redirect.'');
?>