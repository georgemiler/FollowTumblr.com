<?php
session_start();
if(isset($_POST['comment'])){
	$timestamp=time();
	$user=$_SESSION['user'];
	mysql_connect('10.246.16.182','followtumblr_co','bi') or die("invalid user");
	mysql_select_db("followtumblr_co");
	$sql="CREATE TABLE IF NOT EXISTS comments (name VARCHAR(150),comm VARCHAR(200),ts INT)";
	mysql_query($sql);
	$sql="SELECT ts FROM comments WHERE name='".$user."'";
	$res=mysql_query($sql);
	if(mysql_num_rows($res)==0){
		$sql="INSERT INTO comments (name,comm,ts) VALUES('".$user."','".$_POST['comment']."','".$timestamp."')";
		mysql_query($sql);
		$sql="SELECT * FROM users WHERE name='".$user."'";
		$res=mysql_query($sql);
		$row=mysql_fetch_array($res);
		$points=$row['points']+5;
		$sql="UPDATE users SET points='".$points."' WHERE name='".$user."'";
		mysql_query($sql);

	}
	else{
		$row=mysql_fetch_array($res);
		$oldtime=$row['ts'];
		if($timestamp-$oldtime>3600){
			$sql="INSERT INTO comments (name,comm,ts) VALUES('".$_SESSION['user']."','".$_POST['comment']."','".$timestamp."')";
			mysql_query($sql);
			$sql="SELECT * FROM users WHERE name='".$user."'";
			$res=mysql_query($sql);
			$row=mysql_fetch_array($res);
			$points=$row['points']+5;
			$sql="UPDATE users SET points='".$points."' WHERE name='".$user."'";
			mysql_query($sql);
		}
	}
	unset($_POST);
	header('Location: http://followtumblr.com/tumblr.php');

}
if(isset($_POST['user'])){
	$user=$_POST['user'];
	$json=file_get_contents('http://api.tumblr.com/v2/blog/'.$user.'.tumblr.com/info?api_key=5bxcHT01x9MtMnsOzfcXTYa6oqIx1OKtxMaqmNo3xNjNybdpqY');
	$var=json_decode($json);
	$var2=$var->{'meta'}->{'status'};
	if($var2=='200'){
		$_SESSION['user']=$user;
		$timestamp=time();
		#add user to Last Login if not exists, otherwise update timestamp
		mysql_connect('10.246.16.182','followtumblr_co','bi') or die("invalid user");
		mysql_select_db("followtumblr_co");
		$sql="CREATE TABLE IF NOT EXISTS users (name VARCHAR(150),ts INT,points INT)";
		mysql_query($sql);
		$sql="SELECT * FROM users WHERE name='".$user."'";
		$res=mysql_query($sql);
		if(mysql_num_rows($res)==0){
			$sql="INSERT INTO users (name,ts,points) VALUES('".$user."','".$timestamp."','20')";
			mysql_query($sql);
		}
		else{
			$row=mysql_fetch_array($res);
			if($row['points']==0)
				$sql="UPDATE users SET ts='".$timestamp."', points='20' WHERE name='".$user."'";
			else
				$sql="UPDATE users SET ts='".$timestamp."' WHERE name='".$user."'";
			mysql_query($sql);

		}
		unset($_POST);
		echo '<script>window.location = "http://followtumblr.com/tumblr.php";</script>';
		#header('Location: http://followtumblr.com/tumblr.php');
	}
	else{
		echo '<script>window.location = "http://followtumblr.com/404.html";</script>';
		#header('Location: http://google.com')
	}
}
else if (isset($_SESSION['user']))
	$user=$_SESSION['user'];

echo '
	<script type="text/javascript">
		if(window.location.hash=="#_=_"){
			window.close();
		}		
	</script>
';	
?>
<html>
<head>
<link href="http://bootswatch.com/cosmo/bootstrap.min.css" rel="stylesheet">
<link href="http://bootswatch.com/default/bootstrap-responsive.min.css" rel="stylesheet">
<link href="http://bootswatch.com/css/font-awesome.min.css" rel="stylesheet">
<link href="http://bootswatch.com/css/bootswatch.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
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
	      	<a href="http://followtumblr.com/featured.html">Get Featured</a>	      	<hr />
	    </div>

	    <table align="center">
			<td style="padding:50px;" valign="top" width="200px">
				<table style="position:fixed;">
				<td>
				<?php
				echo '
					<img style="width:128px; margin-right: 5px; float: left;" src="http://api.tumblr.com/v2/blog/'.$user.'.tumblr.com/avatar/128" />'
				?>
				<br>
				<a target="_blank" href="http://www.tumblr.com/share/link?url=http%3A%2F%2Ffollowtumblr.com&name=Free+Promo!&tags=fff,promo,f4f,follow%20for%20follow,follow%20me,follow%20back&description=Reblog%20this%20post%20and%20click%20the%20link%20above%20for%20a%20free%20promo%20to%20thousands!">
					<img src="http://platform.tumblr.com/v1/share_3.png" style="margin-top: 5px;">
				</a>
<h4>^ Share = 50 points!</h4>

				</td>
				<td width="30px" valign="top">
				<h4>Welcome back!</h4>


				</td>
				</table>
			</td>
			<td  width="900px">
				<h2>Subscribed users</h2>
				<div>
					<a class="newWindow" title="Follow ilikeiwantivisit!" target="_blank" href="http://www.tumblr.com/follow/ilikeiwantivisit">
						<img height="78" src="http://api.tumblr.com/v2/blog/ilikeiwantivisit.tumblr.com/avatar/96">
					</a>
										<a class="newWindow" title="Follow heylula!" target="_blank" href="http://www.tumblr.com/follow/heylula">
						<img height="78" src="http://api.tumblr.com/v2/blog/heylula.tumblr.com/avatar/96">
					</a>
				</div>
				
				<h2>Most recent users</h2>
				
				<?php
					mysql_connect('10.246.16.182','followtumblr_co','biscuite') or die("invalid user");
					mysql_select_db("followtumblr_co");
					$sql="SELECT name FROM users ORDER BY ts DESC LIMIT 10";
					$res=mysql_query($sql);
					if($res>0)
						while($row = mysql_fetch_array($res)){
							echo '<a class="newWindow" target="_blank" href="http://followtumblr.com/addpoints.php?q=http://www.tumblr.com/follow/';
							echo $row['name'];
							echo '"">';
							echo '<img src="http://api.tumblr.com/v2/blog/';
							echo $row['name'];
							echo '.tumblr.com/avatar/64"></a>';
						}
				?>

				<h2>Describe your blog below</h2>
					<?php
						$sql="SELECT * FROM comments ORDER BY ts DESC LIMIT 10";
						$res=mysql_query($sql);
						if($res>0)
							while($row=mysql_fetch_array($res)){
								if(time()-(int)$row['ts']<60)
									echo '<a class="newWindow" target="_blank" href="http://followtumblr.com/addpoints.php?q=http://www.tumblr.com/follow/'.$row['name'].'">'.$row['name'].' </a> - '.$row['comm'].' - '.(time()-(int)$row['ts']).' seconds ago </p>';
								else if(time()-(int)$row['ts']>60 && time()-(int)$row['ts']<3600)
									echo '<a class="newWindow" target="_blank" href="http://followtumblr.com/addpoints.php?q=http://www.tumblr.com/follow/'.$row['name'].'">'.$row['name'].' </a> - '.$row['comm'].' - '.(int)((time()-(int)$row['ts'])/60) .' minutes ago </p>';
								else if(time()-(int)$row['ts']>3600 && time()-(int)$row['ts']<3600*24)
									echo '<a class="newWindow" target="_blank" href="http://followtumblr.com/addpoints.php?q=http://www.tumblr.com/follow/'.$row['name'].'">'.$row['name'].' </a> - '.$row['comm'].' - '.(int)((time()-(int)$row['ts'])/3600) .' hours ago </p>';
								else 
									echo '<a class="newWindow" target="_blank" href="http://followtumblr.com/addpoints.php?q=http://www.tumblr.com/follow/'.$row['name'].'">'.$row['name'].' </a> '.$row['comm'].' - '.(int)((time()-(int)$row['ts'])/3600/24) .' days ago </p>';
							}
					?>
					<form action="tumblr.php" method="post">
						<input type="text" name="comment" style="height:30px; margin-top:10px;" class="input-xlarge" >
						<button type="submit" class="btn">Submit</button>
					</form>
			</td>
		</table>


<script type="text/javascript">
$(document).ready(function() {
  $('.newWindow').click(function (event){
 
                    var url = $(this).attr("href");
                    var windowName = "follow";//$(this).attr("name");
                    var windowSize = "width=800,height=600,scrollbars=yes,titlebar=no,toolbar=no,location=no";
 
                    window.open(url, windowName, windowSize);
 
                    event.preventDefault();
 
                });
                
    // attaching onclick event listener to all images with class swappable
    $('div.swappable').click(function() {
        // get current event target
        var $this = $(this);

        // get current src value and store it in swap variable (local scope)
        var swap = $this.css('display','none');
        // set src's new value to the value of rel=""
        $this.css('display','none');
    });
});
</script>
<script src="http://platform.tumblr.com/v1/share.js"></script>
</body>
</html>