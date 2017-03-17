<!DOCTYPE html>
<html>
<head>

<script>

function stoprunning(){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", "stop.php?q = stop",true);
	xmlhttp.send();
}


</script>

<style>
body {
    margin: 0;
}

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: 25%;
    background-color: #f1f1f1;
    position: fixed;
    height: 100%;
    overflow: auto;
}

li a {
    display: block;
    color: #000;
    padding: 8px 16px;
    text-decoration: none;
}

li a.active {
    background-color: #4CAF50;
    color: white;
}

li a:hover:not(.active) {
    background-color: #555;
    color: white;
}
.button {
    background-color:#008CBA; /*BLUE */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
</style>
</head>
<body>

<ul>
  <li><a class="active" href="VboutDataAnalysis2.php">Home</a></li>
  <li><a href="controlerpage.php">Refresh the Page</a></li> 
  <li><button class="button" type ="button" onclick = "stoprunning()">STOP PROGRAM</button></li>
  
</ul>
<form method="get">
</form>



<div style="margin-left:25%;padding:1px 16px;height:1000px;">
  <h2>VBOUT DATA ANALYSIS AND VALIDATION</h2>
  <h3>Created by PHILIPPE DONAUS</h3>
  <p><font size= "3" face="veranda" color="black">
  
  <?php 
  include("vboutclass4.php");
  trymenow();
  ?>
  
  </font></p></div></body></html>
  
  
  
