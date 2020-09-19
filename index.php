<?php

$insert = false;
$update = false;
$delete = false;
// connect to the databse
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);
if(!$conn){
  die("connection was not successfull");
}

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;

  $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
  $result = mysqli_query($conn, $sql);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
if(isset($_POST['snoEdit'])){
  // update the record
  $sno = $_POST['snoEdit'];
  $title = $_POST['titleEdit'];
  $description = $_POST['descriptionEdit'];

  $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = $sno";
  $result = mysqli_query($conn, $sql);

  if($result){
    $update = true;
  }
  else{
    echo "note has not been updated successfully because of this error: --> " . mysqli_error($result);
  }
}
else{

  $title = $_POST['title'];
  $description = $_POST['description'];

  $sql = "INSERT INTO `notes`(`title`, `description`) VALUES('$title', '$description')";
  $result = mysqli_query($conn, $sql);

  if($result){
    //die("record was inserted successfully");
    $insert = true;
  }
  else{
    echo "note has not been inserted successfully because of this error: --> " . mysqli_error($result);
  }
}
}

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

  <title>iNotes -Notes taking make easy</title>
</head>

<body>

<!-- edit modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
Edit Modal
</button> -->

<!--edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit this noteEdit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/crud/index.php" method="post">
      <div class="modal-body">
          <input type="hidden" name="snoEdit" id="snoEdit">
          <div class="form-group">
            <label for="title">Note Title</label>
            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp"
              placeholder="Enter title">
          </div>
          <div class="form-group">
            <label for="desc">Note Description</label>
            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
          </div>
          <!-- <button type="submit" class="btn btn-primary">Update Note</button> -->
      </div>
      <div class="modal-footer d-block mr-auto">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">iNotes</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact US</a>
        </li>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
  </nav>

  <?php
  if($insert){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>Success!</strong> Your note has been inserted Successfully.
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>';
  }
  ?>

<?php
  if($update){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>Success!</strong> Your note has been updated Successfully.
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>';
  }
  ?>

<?php
  if($delete){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
<strong>Success!</strong> Your note has been deleted Successfully.
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>';
  }
  ?>
  <div class="container my-3">
    <h2>Add a Note</h2>
    <form action="/crud/index.php" method="post">
      <div class="form-group">
        <label for="title">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp"
          placeholder="Enter title">
      </div>
      <div class="form-group">
        <label for="desc">Note Description</label>
        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>

  <div class="container my-4">

    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php

$sql = "SELECT * FROM `notes`";
$result = mysqli_query($conn, $sql);
$sno = 0;
while($row = mysqli_fetch_assoc($result)){
  $sno = $sno +1;
  echo "<tr>
  <th scope='row'>". $sno . "</th>
          <td>". $row['title'] . "</td>
          <td>" . $row['description'] . "</td>
          <td><button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-danger' id=d".$row['sno'].">Delete</button></td>
  </tr>";

}

?>

      </tbody>
    </table>

  </div>

  <hr>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>

<script>
  edits = document.getElementsByClassName('edit');
  Array.from(edits).forEach((element)=>{
    element.addEventListener("click", (e)=>{
      console.log("edit",);
      tr =  e.target.parentNode.parentNode;
      title = tr.getElementsByTagName("td")[0].innerText;
      description = tr.getElementsByTagName("td")[1].innerText;
      console.log(title, description);
      titleEdit.value = title;
      descriptionEdit.value = description;
      snoEdit.value = e.target.id;
      console.log(e.target.id);
      $('#editModal').modal('toggle');
    })
  })

// this eventListener for delete
  deletes = document.getElementsByClassName('delete');
  Array.from(deletes).forEach((element)=>{
    element.addEventListener("click", (e)=>{
      console.log("delete",);
      sno = e.target.id.substr(1,);
      
      if(confirm("Sure For Delete.!")){
        console.log("yes");
        window.location = `/crud/index.php?delete=${sno}`;
      }
      else{
        console.log("no");
      }
    })
  })
 </script>
</body>

</html>