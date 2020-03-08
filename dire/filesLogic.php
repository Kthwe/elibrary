<?php
// connect to database
$conn = mysqli_connect('localhost', 'root', '', 'file_management');

$sql = "SELECT * FROM files";
$result = mysqli_query($conn, $sql);
$filenames = 'name';
$files = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Uploads files
if (isset($_POST['upload'])) { // if save button on the form is clicked
    // name of the uploaded file
    $title    =mysqli_real_escape_string($conn,$_POST['title']);
    $author    =mysqli_real_escape_string($conn,$_POST['author']);
    $thesis_class    =$_POST['thesis_class'];
    $filename = $_FILES['myfile']['name'];

    // destination of the file on the server
    $destination = 'htmlviewer/web/books/' . $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    $size = $_FILES['myfile']['size'];
    if (!in_array($extension, ['pdf'])) {
        echo "You file extension must be .pdf";
    } elseif ($_FILES['myfile']['size'] > 100000000) { // file shouldn't be larger than 1Megabyte
        echo "File too large!";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($file, $destination)) {
            $sql = "INSERT INTO files (title, author, file_name, file_size, thesis_class, downloads) VALUES ('$title','$author', '$filename', $size, '$thesis_class', 0)";
            if (mysqli_query($conn, $sql)) {
                //echo "<script>alert('$filename is uploaded successfully');setTimeout(\"location.href= 'http://localhost/dashboard/dire/index.php';\",1500);</script>";
            }
        } else {
            echo "Failed to upload file.";
        }
    }
}

if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    // fetch file to download from database
    $sql = "SELECT * FROM files WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'htmlviewer/web/books/' . $file['file_name'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('htmlviewer/web/books/' . $file['file_name']));
        readfile('htmlviewer/web/books/' . $file['file_name']);

        // Now update downloads count
        $newCount = $file['downloads'] + 1;
        $updateQuery = "UPDATE files SET downloads=$newCount WHERE id=$id";
        mysqli_query($conn, $updateQuery);
        exit;
    }

}

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    // fetch file to delete from database
    $delete = "DELETE FROM files WHERE id=$id";
    $sql = "SELECT * FROM files WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $file = mysqli_fetch_assoc($result);
    $path = 'htmlviewer/web/books/'.$file['file_name'];
    $filename = $file['file_name'];
    if(unlink($path) && $conn->query($delete) === true){
        echo "<script>alert('$filename is deleted successfully');setTimeout(\"location.href= 'http://localhost/dashboard/dire/admin.downloads.php';\",1500);</script>";
    }
}