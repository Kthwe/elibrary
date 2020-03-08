<?php include 'filesLogic.php';?>
<!DOCTYPE html>
<html> 
<head> 
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Electronic Department e-Library</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">
    
  <!-- Add Bootstrap Links -->
  <link rel="stylesheet" href="assets/bootstrap.min.css"> 
  <script src="assets/jquery.min.js"></script> 
  <script src="assets/bootstrap.min.js"></script> 
  <link href="assets/icofont/icofont.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/stylesheet.css"> 
</head> 
<body>
<div class="container">
<div class="topnav">
  <a class="active" href="index.php">Home</a>
  <a type="icon"><i class="icofont-search-2"></i></a>
  <input type="text" name="search_text" id="search_text" placeholder="Search by Title,Class Or Author"/>
</div> 
		<br />
		<h2 align="center">Thesis Titles</h2><br />
    </div>
<div id="result"></div>
</div>
</body>
</html>
<script>
$(document).ready(function(){
	load_data();
	function load_data(query)
	{
		$.ajax({
			url:"admin.fetch.php",
			method:"post",
			data:{query:query},
			success:function(data)
			{
				$('#result').html(data);
			}
		});
	}
	
	$('#search_text').keyup(function(){
		var search = $(this).val();
		if(search != '')
		{
			load_data(search);
		}
		else
		{
			load_data();			
		}
	});
});
</script>
<style>
.topnav {
  overflow: hidden;
  background-color: #e9e9e9;
}

/* Style the links inside the navigation bar */
.topnav a{
  float: left;
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}
.topnav a[type=icon]{
  float: right;
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

/* Change the color of links on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

/* Style the "active" element to highlight the current page */
.topnav a.active {
  background-color: #2196F3;
  color: white;
}

/* Style the search box inside the navigation bar */
.topnav input[type=text] {
  width: 25%;
  float: right;
  padding: 6px;
  border: none;
  margin-top: 8px;
  margin-right: 0px;
  font-size: 17px;
}

/* When the screen is less than 600px wide, stack the links and the search field vertically instead of horizontally */
@media screen and (max-width: 600px) {
  .topnav a, .topnav input[type=text] {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 14px;
  }
  .topnav input[type=text] {
    border: 1px solid #ccc;
  }
}
</style>