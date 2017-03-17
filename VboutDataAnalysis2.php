<!DOCTYPE html>
<html>

<style>

ul {
        	
        	list-style-type: none;
        	margin: 0;
        	padding: 0;
        	overflow: hidden;
        	background-color: #3686be;
        	
        	}
        	
        	li{
        	
        	float: left;
        	
        	}
        	
        	li a{
        	display: inline-block;
        	color: white;
        	text-align: center;
        	padding: 14px 16px;
        	text-decoration: none;
        	}
        	
        	li a:hover {
        		background-color:#111;
        	}
        	
            body {
                background-color:#f1f1f1;
                color:#FFF;
                border:0px;
                margin:0px;
                overflow:hidden;
            }


input[type=text], select {
    width:100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font: veranda;
}

input[type=submit] {
    width: 100%;
    background-color: #008CBA;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font: veranda;
}

input[type=submit]:hover {
    background-color: #2175a8;
}

input[type=password], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font: veranda;
}

div {
    border-radius: 5px;
    background-color: #99ccff;
    padding: 20px;
    font:veranda;
    width: 30%;
    height: 100%;
}


</style>


<head>
<title></title>
</head>

<!--THE MENU -->
<div style ='font:14px/18px Arial,tahoma,sans-serif;width: 100%; padding: 0; boarder-radius:0;'>
    <ul> 
    <li><a href = "index.html">HOME</a></li>
    <li><a href = "VboutDataAnalysis2.php">DATA PROCESSING</a></li>
    <li><a href = "" >VIEW SQL DATA</a></li>
    <li><a href = "phpmyadmin" >PHPMyAdmin Server Access</a></li>
    </ul>
    </div>

<div style = 'font:14px/18px Arial,tahoma,sans-serif;'>
<form action = "controlerpage.php" method = "post">
<fieldset>
<legend>Log Into Database: </legend>
Host (Lolcahost or IP):<br>
<input type="text" name = "host"><br>
Username:<br>
<input type="text" name = "user"><br>
Password:<br>
<input type="password" name = "pass"><br>
Database Name:<br>
<input type ="text" name = "database">Database Name: <br>
Port:<br>
<input type ="text" name = "port"><br>
Table (Must be listed in database):<br>
<input type ="radio" name = "table" value = "Agri_Forest_Fishing" checked>Agriculture Forestry Fishing<br>
<input type ="radio" name = "table" value = "Business" checked >Business<br>
<input type ="radio" name = "table" value = "Construction" checked>Construction Companies<br>
<input type ="radio" name = "table" value = "Extra_Data" checked>Extra Data<br>
<input type ="radio" name = "table" value = "Fin_Insurance_Realestate" >Finance, Insurance, and Relestate<br>
<input type ="radio" name = "table" value = "Manufacturing" >Manufacturing Companies<br>
<input type ="radio" name = "table" value = "Mining">Mining Industry<br>
<input type ="radio" name = "table" value = "Public_Admin">Public Administration<br>
<input type ="radio" name = "table" value = "Retail_Trade" >Retail Trade<br>
<input type ="radio" name = "table" value = "table1">Test Table (1)<br>
Run Time (Enter Size of Database or 0 for whole database):<br>
<input type ="text" name = "run"><br>
<br><br>
    <input type="submit" value="Submit">
</fieldset>
</form></div>


</body>
