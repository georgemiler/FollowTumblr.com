<html>
<head>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<link href="http://bootswatch.com/cosmo/bootstrap.min.css" rel="stylesheet">
<link href="http://bootswatch.com/default/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://bootswatch.com/css/font-awesome.min.css" rel="stylesheet">
<link href="http://bootswatch.com/css/bootswatch.css" rel="stylesheet">
<style type="text/css">
body
{
background-image:url("http://i.imgur.com/ne8ePgb.png");
background-repeat: repeat;
width: 100%;
}
</style>
</head>
<body>
		<div align="center">
	      	<a href="http://followtumblr.com/"><h1>Tumblr Followers</h1></a>
	      	<p class="lead">An easy way to be more popular.</p>
	      	<b><a href="http://followtumblr.com">Home</a> |
	      	<a href="http://followtumblr.com/points.php">Most Points</a> |
	      	<a href="http://followtumblr.com/featured.html">Get Featured</a>
	    	<hr />
	    	<table>
	    		<td>
	    			<h2>How to get points:</h2>
	    			<p style="padding:20px;">
	    			<b>Login</b>: 20 points.
	    			<p style="padding:20px;">
	    			<b>Post</b>: 5 points.
	    			<p style="padding:20px;">
	    			<b>Follow</b>: 1 point.
	    			
	    		</td>
		    	<td>
<h2>Users with most points</h2>
		    	<?php
						mysql_connect('10.246.16.182','followtumblr_co','bi') or die("invalid user");
						mysql_select_db("followtumblr_co");
						$sql="SELECT name FROM users ORDER BY points DESC LIMIT 10";
						$res=mysql_query($sql);
						if($res>0)
							while($row = mysql_fetch_array($res)){
								echo '<a class="newWindow" target="_blank" href="http://followtumblr.com/addpoints.php?q=http://www.tumblr.com/follow/';
								echo $row['name'];
								echo '">';
								echo '<img src="http://api.tumblr.com/v2/blog/';
								echo $row['name'];
								echo '.tumblr.com/avatar/64"></a>';
							}
					?>
				</td>
			</table>



</body>
</html>