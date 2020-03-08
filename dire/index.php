<?php include 'filesLogic.php';?>
<!DOCTYPE html>
<html lang="en">
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
  <script type="text/javascript" src="upload_progress.js"></script>
  <link href="assets/icofont/icofont.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/stylesheet.css">
</head> 
  
  <body>
    <div class="container">
      <div class="row">
        <form action="index.php" method="post" enctype="multipart/form-data" >
          <h3>Upload Now</h3>
          <p>Thesis Title</p>
          <input type="text" value="" name="title"  required>
          <p>Submitted By:</p>
          <input type="text" value="" name="author"  required><br>
					<label>Thesis Category:</label>
								<select name="thesis_class">
									<option>--PLEASE SELECT--</option>
									<option value="PLC">PLC</option>
									<option value="Networking">Networking</option>
									<option value="Arduino">Arduino</option>
								</select required><br><br>
          <input type="file" name="myfile"> <br>
          <div class="progress">
          <div class="bar"></div >
          <div class="percent">0%</div >
          </div>
          <div id="status"></div><br>
          <button class="btn btn-primary" type="submit" name="upload">Upload</button>&nbsp
          &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
          &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
          <a class="btn btn-primary" href="admin.downloads.php">Lists</a>
        </form>
      </div>
    </div>
  </body>
</html>
<script>

</script>
<style>
.body{
	background:url("http://localhost/dashboard/dire/bg.jpg") no-repeat 0px 0px;
  background-size:cover;
  -o-background-size:cover;
  -moz-background-size:cover;
  -webkit-background-size:cover;
  font-family: 'Source Sans Pro', sans-serif;

}

.container form{
  background : #428bca;
  border     : none;
}
.container p,label{
  color: #fff;
}

.container a{
  text-align : right;
}
.container h3{
  color: #fff;
  text-align : center;

}
.container input[type="file"] {
  text-align : center;
  border : none;
}
</style>