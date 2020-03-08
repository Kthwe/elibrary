<?php
$conn = mysqli_connect("localhost", "root", "", "file_management");
$output = '';
$i=0;
if(isset($_POST["query"]))
{
	$search = mysqli_real_escape_string($conn, $_POST["query"]);
	$query = "
	SELECT * FROM files 
	WHERE title LIKE '%".$search."%'
	OR author LIKE '%".$search."%' 
	OR thesis_class LIKE '%".$search."%' 
	";
}
else
{
	$query = "
	SELECT * FROM files ORDER BY id";
}
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0)
{
	$output .= '<div class="container">
				<table class="table table-bordered table-striped">
				<thead>
				<th class="col-1">No.</th>
				<th class="col-3">THESIS TITLE</th>
				<th class="col-3">Submitted By</th>
				<th class="col-1">Class</th>
				<th class="col-1">Counts</th>
				<th class="col-1">View</th>
				<th class="col-1">Download</th>
				<th class="col-1">Delete</th>
				</thead>';
	while($row = mysqli_fetch_array($result))
	{
		$i++; {
				$output .= '
				<tr>
				<td class="icon">';
				$output .= $i;
				$output .= '
				</td>
				<td>'.$row["title"].'</td>
				<td class="icon">'.$row["author"].'</td>
				<td class="icon">'.$row["thesis_class"].'</td>
				<td class="icon">'.$row["downloads"].'</td>
				<td class="icon"><a href="http://localhost/dashboard/dire/htmlviewer/web/viewer.html?file=books/';
				$output .= $row["file_name"];
				$output .= '"><i class="icofont-eye"></i></a></td>
				   <td class="icon"><a href="admin.downloads.php?file_id=';
				$output .= $row["id"];
				$output .= '"><i class="icofont-download"></i></a></td>
				   <td class="icon"><a href="admin.downloads.php?delete_id=';
				$output .= $row["id"];
				$output .= '"><i class="icofont-ui-delete"></i></a></td></tr>';
		}
	}
	echo $output;
}
else
{
	echo 'Data Not Found';
}
?>