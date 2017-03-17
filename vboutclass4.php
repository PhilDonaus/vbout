
<?php
//Philippe Donaus
function trymenow(){

include ("TEST3.php");
include ("stop.php");

ignore_user_abort(true);


//___________________________
//CREATE TEMP CANCLE FLE
file_put_contents(sys_get_temp_dir().'/myscriptcancelfile','run');

//Use mysqli_connect() to connect to the database with the host, username, password, and db
//Use mysqli_query() to send a command in char length to the sql database table.

// Report no errors
//error_reporting(E_COMPILE_ERROR);

echo "<div style ='font:11px/21px Arial,tahoma,sans-serif;color:#2146ff'>........The PROGRAM IS RUNNING............</div>";
set_time_limit(0);
$time_start = microtime(true);
$timetrack = microtime(true);
// Anywhere else in the script
echo 'Total execution time in seconds: ' . (microtime(true) - $time_start);
//Connect to DB
//--------------------------------------------------------------------
$host = (string)$_POST['host'];
echo $host;
$user = htmlspecialchars($_POST['user']);
echo $user;
$pass = htmlspecialchars($_POST['pass']);
echo $pass;
$db = htmlspecialchars($_POST['database']);
echo $db;
$port = (int)$_POST['port'];
echo $port;
$table = htmlspecialchars($_POST['table']);
echo $table;
$run_time = (int)$_POST['run'];


$con = mysqli_connect($host,$user,$pass,$db,$port) or die("<br/><br/><div style ='font:14px/18px Arial,tahoma,sans-serif;color:#ff0000'> NOT CONNECTED </div>");
echo "<br/> Connected successfully<br/>";
//--------------------------------------------------------------------
// Create Space in Database 43696

mysqli_query($con, "ALTER TABLE `".$table."` ADD `ID` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`ID`)");
mysqli_query($con, "ALTER TABLE `".$table."` ADD COLUMN Email TEXT;") ; //ADDS FACEBOOK COLUM
mysqli_query($con, "ALTER TABLE `".$table."` ADD COLUMN facebookID TEXT;") ; //ADDS FACEBOOK COLUM
mysqli_query($con, "ALTER TABLE `".$table."` ADD COLUMN twitterID TEXT;") ;
mysqli_query($con, "ALTER TABLE `".$table."` ADD COLUMN instagramID TEXT;") ;//ADDS Instagram COLUM
mysqli_query($con, "ALTER TABLE `".$table."` ADD COLUMN linkedinID TEXT;");
mysqli_query($con, "ALTER TABLE `".$table."` ADD COLUMN youtubeID TEXT;");//ADDS INSTAGRAM COLUM
mysqli_query($con, "ALTER TABLE `".$table."` ADD COLUMN googleplusID TEXT;");
mysqli_query($con, "ALTER TABLE `".$table."` ADD COLUMN pinterestID TEXT;");//ADDS PINTEREST COLUM
mysqli_query($con, "ALTER TABLE `".$table."` ADD COLUMN points INT;");//ADDS Points COLUMN
mysqli_query($con, "ALTER TABLE `".$table."` ADD COLUMN basket TEXT;");//ADDS Basket COLUMN
mysqli_query($con, "ALTER TABLE `".$table."` ADD COLUMN flag TEXT;") ;//
mysqli_query($con, "ALTER TABLE `".$table."` ADD COLUMN ABOUTME TEXT;");
mysqli_query($con, "OPTIMIZE TABLE `".$table."`") or die("DON'T DO THAT");
//mysqli_query($con, "ANALYZE TABLE `".$table."`") or die("DON'T DO THAT ALSO, Failed: Analyze Table");

echo "ALTER TABLE ".$table." ADD ALL COLUMNS TEXT;";

//--------------------------------------------------------------------- START FROM WHERE IT LAST LEFT OFF
$sql = "select points from `".$table."` where ID = 1;";
$sult = mysqli_query($con,$sql) or die ("COULD NOT ACCESS STARTING POINT");
$onerow = mysqli_fetch_array($sult) or die("BAD IDEA1");

$sql2 = "SELECT COUNT(*) FROM `".$table."`";
$sult2 = mysqli_query($con,$sql2) or die ("COULD NOT COUNT NUMBER OF ROWS");
$onerow2 = mysqli_fetch_array($sult2) or die("BAD IDEA2");

//---------------------------------------------------------------------
//9740 is the bad one.//12104//30615
	if( $onerow['points'] <1){$ID = 1;
	}else{ $ID = $onerow['points'];}
	
	$result;
	$timeAVG = array();
	$part = 0;
	
	do{
		//------------------------------------------------------------- GET DATA FROM SQL DATABASE
		echo "<br/><div style ='font:14px/18px Arial,tahoma,sans-serif;color:#000000'>---------------------------------$ID-----------------------------------</div>";
		$time_start1 = microtime(true);
		$sql = "select Website,Email,basket from `".$table."` where ID = ".$ID;
		
		$result = mysqli_query($con, $sql) or die("ACCESS DENIED");
		$row = mysqli_fetch_array($result) or die(mysqli_error($con));
		$webweb = $row['Website'];
		echo $webweb;
		//------------------------------------------------------------- CHECK IF COMPLETED ALREADY
		if( (strlen($webweb) <3 ))  //or ($row['basket'] !== NULL ))
		{echo "<div style ='font:14px/18px Arial,tahoma,sans-serif;color:#ff0000'> COMPLETED </div>";
		}else{
		//------------------------------------------------------------- COMPUTE SOCIAL MEDIA
		$vbout = new myVBOUT($row['Website'],$row['Email']);
		$mg = $vbout->RUNIT();
		//------------------------------------------------------------- WRITE INTO SQL DATABASE
		echo "<br/>";
		echo "<div style ='font:11px/21px Arial,tahoma,sans-serif;color:#2146ff'>Writting Information into database. </div>";
		
		
		$remove[] = "'";
		$remove[] = '"';
		$remove[] = '`';
		$remove[] = "”";
		$remove[] = "“";
		$remove[] = "’";
		
		$facebook = " facebookID = '".str_replace($remove, "",$mg['facebook'])."',"; 
		$twitter = " twitterID = '".str_replace($remove, "",$mg['twitter'])."',"; 
		$instagram = " instagramID = '".str_replace($remove, "",$mg['instagram'])."',";
		$linkedin = " linkedinID = '".str_replace($remove, "",$mg['linkedin'])."',"; 
		$youtube = " youtubeID = '".str_replace($remove, "",$mg['youtube'])."',"; 
		$googleplus = " googleplusID = '".str_replace($remove, "",$mg['google+'])."',"; 
		$pinterest = " pinterestID = '".str_replace($remove, "",$mg['pinterest'])."',";
		
		
		$mastersql = array($facebook, $twitter, $instagram, $linkedin, $youtube, $googleplus, $pinterest);
		
		$mastersql = implode("",$mastersql);
		echo $mastersql;
		//------------------------------------------------------------- About Edit
		
		$newabout = preg_replace($remove, "", $mg['about']);
		
		//------------------------------------------------------------- About Edit
		
		$mastersql2 = "UPDATE `".$table."` SET ".$mastersql."  points = ".$mg['grade'].", basket = '".$mg['level']."' , flag = '".$mg['flag']."',  
				 ABOUTME = '".$newabout."' WHERE ID = ".$ID.";";

		
		mysqli_query($con, $mastersql2) or die('<br/><br/><br/> Cannot Write '.$mastersql2);
		
	/*	mysqli_query($con, "UPDATE ".$table." SET points = '".$mg['grade']."' WHERE ID =".$ID);
		mysqli_query($con, "UPDATE ".$table." SET basket = '".$mg['level']."' WHERE ID =".$ID);
		mysqli_query($con, "UPDATE ".$table." SET flag = '".$mg['flag']."' WHERE ID =".$ID);
		mysqli_query($con, "UPDATE ".$table." SET ABOUTME = '".$mg['about']."' WHERE ID =".$ID); */
		//1813
		
		echo '<br/> The Link: '.$row['Website'].'<br/> and the ABOUT: '.substr($mg['about'],0,20).'<br/>
				The Level: '.$mg['level'].' The Points: '.$mg['grade'];
		
		mysqli_query($con, "UPDATE ".$table." SET points = ".$ID." WHERE ID = 1;") or die("<br/>FAILED TO SAVE VARIABLE");
		
		}
		//------------------------------------------------------------- CHANGE INTERVAL AND COMPUTE TIME
		$ID++;
		$part++;
		echo 'Total execution time: ' .(microtime(true)-$time_start);
		array_push($timeAVG, microtime(true) - $time_start);
		echo "<div style ='font:11px/21px Arial,tahoma,sans-serif;color:#2146ff'> Total run time of the program is: </div>".myclock($timetrack,microtime(true));
		//------------------------------------------------------------- CLEAR CHACHE
		clearstatcache();
		
		
		if ($part == 10){ob_end_clean();
		$part = 0;
		}
		if ( file_get_contents(sys_get_temp_dir().'/myscriptcancelfile') != 'run' ) {
			mysqli_query($con, "UPDATE ".$table." SET points = ".$ID." WHERE ID = 1;") or die("<br/><br/>FAILED TO SAVE VARIABLE");
			echo "<br/><br/> Last Known spot Saved";
			exit('<br/><br/> THE SCRIPT WAS PAUSED ');
		}
				
		//------------------------------------------------------------- LOOP BLOCK
	} while(($ID < $count2[0]) or ($runtime == 0));
	
	
//--------------------------------------------------------------------- COMPUTE COMPUTING TIME AND AVERAGE
$timeAVG = array_sum($timeAVG)/$ID;
echo "<br/>AVERAGE RUN TIME = $timeAVG <br/>";
$time = microtime(true);
echo "TOTAL RUN TIME on $run_time iterations... $time seconds";

//--------------------------------------------------------------------- USABLE FUNCTIONS
}

?>

	
