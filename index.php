<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$database = "Notes";
$connection = mysqli_connect($servername, $username, $password, $database);
$delete = false;
$update = false;
if (isset($_POST["delete-all-submit"])) {
  if (array_key_exists('delete-all-submit', $_POST)) {
    function cleardb()
    {
      global $connection;
      mysqli_query($connection, "TRUNCATE TABLE notes");
      header("Refresh:0");
    }
    cleardb();
  }
}

if (isset($_POST["notes-submit"])) {
  $title = trim($_POST["title"]);
  $desc = trim($_POST["desc"]);
  if (!empty($title) && !empty($desc)) {
    $add = mysqli_query(
      $connection,
      "INSERT INTO notes (sno,title,description,tstamp) values(NULL,'$title','$desc', CURRENT_TIMESTAMP)"
    );
  }
};

if (isset($_POST["edit-submit"]) && !empty($_POST["editTitle"]) && !empty($_POST["editDesc"])) {
  $tit = $_POST["editTitle"];
  $des = $_POST["editDesc"];
  $sno = $_POST["editSno"];
  $statement = "UPDATE notes SET title = '$tit' , description = '$des' WHERE sno = '$sno' ";
  $q = mysqli_query($connection, $statement);
  if($q){
    $update = true;
  }else{
    $update = false;
  }
}

if(isset($_POST["delete-submit"])){
  $sno = $_POST["deleteSno"];
  $q = mysqli_query($connection,"DELETE FROM notes WHERE sno = '$sno'");
  if($q){
    $delete = true;
  }else{
    $delete = false;
  }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ZNotes - Notes taking make easy</title>
<!--    <script src="//cdn.jsdelivr.net/npm/eruda"></script> 
    <script>eruda.init();</script> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  </style>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" type="text/css" media="all" />
  <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js" type="text/javascript" charset="utf-8"></script>
  <style>
 /* @import url("https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@800&display=swap");*/
  *{
    /*font-family: "JetBrains Mono";*/
    font-size: 15px;
  }
 table{
    table-layout: fixed;
  }
  .td{
    overflow: scroll;
    text-align: left;
    word-wrap: break-word;
    /*white-space: nowrap;*/
  }
  td,th{text-align:left;}
  .custom{
    width: 60px;
    margin-bottom: 5px;
    text-align: center;
  }
  </style>
</head>
<body style="background-color:#111;color:#fff;">
  
  <div class="modal fade" id="deleteAllModal" tabindex="-1" aria-labelledby="deleteAllModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header" style="border:none;">
        <h1 class="modal-title fs-5" id="deleteAllModalLabel">Are you sure want to delete all notes ? <psan style="color:#f00;"> This will delete all your notes permanently.</psan></h1>
      </div>
 
      <div class="modal-footer" style="border:none;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <form action="./index.php" method="post">
        <button type="submit" class="btn btn-primary" name="delete-all-submit">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
  
  
  
  
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit note</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color:#fff;"></button>
      </div>
      <div class="modal-body">

     <form action="<?php echo htmlspecialchars(
       $_SERVER["PHP_SELF"]
     ); ?>" method="post" name="edit-form">
      <div class="mb-3">
        <label for="editTitle" class="form-label">Note Title<span style="color:red;">*</span></label><?php if (
          isset($_POST["edit-submit"])
        ) {
          if (empty(trim($_POST["editTitle"]))) {
            echo "<p style='color:red;'>Title is required</p>";
          }
        } ?>
        <input type="text" class="form-control bg-dark text-light" id="editTitle" aria-describedby="emailHelp" name="editTitle">
      </div>
      <div class="form-group mb-3">
        <label for="editDesc">Notes Description<span style="color:red;">*</span></label><?php if (
          isset($_POST["edit-submit"])
        ) {
          if (empty(trim($_POST["editDesc"]))) {
            echo "<p style='color:red;'>Description is required</p>";
          }
        } ?>
        <textarea class="form-control mt-1 bg-dark  text-light" id="editDesc" rows="3" name="editDesc"></textarea>
      </div>
      </div>
      <input type="hidden" name="editSno" id="editSno" />
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="edit-submit">Update</button>
      </div>
    </form>
    </div>
  </div>
</div>

 <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header" style="border:none;">
        <h1 class="modal-title fs-5" id="deleteModalLabel">Are you sure want to delete this note ?</h1>
      </div>
 
      <div class="modal-footer" style="border:none;">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <form action="./index.php" method="post">
        <input type="hidden" name="deleteSno" id="deleteSno" />
        <button type="submit" class="btn btn-primary" name="delete-submit">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

  <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="./index.php">iNotes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact us</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  <?php if (isset($_POST["notes-submit"])) {
    if ($add) {
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Added!</strong> Your note has successfully added.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    } else {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Your note did not added.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
  } ?>
  <?php 
  if($delete){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Deleted!</strong> Your note has successfully deleted.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
  }
  if($update){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Updated!</strong> Your note has successfully updated.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>'; 
}
  ?>
 
  <div class="cont m-4">
    <h2>Add a note to iNotes app</h2>
    <form action="<?php echo htmlspecialchars(
      $_SERVER["PHP_SELF"]
    ); ?>" method="post" name="notes-form">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title<span style="color:red;">*</span></label><?php if (
          isset($_POST["notes-submit"])
        ) {
          if (empty(trim($_POST["title"]))) {
            echo "<p style='color:red;'>Title is required</p>";
          }
        } ?>
        <input type="text" class="form-control bg-dark text-light" id="title" aria-describedby="emailHelp" name="title">
      </div>
      <div class="form-group mb-3">
        <label for="desc">Notes Description<span style="color:red;">*</span></label><?php if (
          isset($_POST["notes-submit"])
        ) {
          if (empty(trim($_POST["desc"]))) {
            echo "<p style='color:red;'>Description is required</p>";
          }
        } ?>
        <textarea class="form-control mt-1 bg-dark  text-light" id="desc" rows="3" name="desc"></textarea>
      </div>
      <button type="submit" class="btn btn-primary" name="notes-submit">Add Note</button>
        <button type="button" class="btn btn-danger"  data-bs-toggle='modal' data-bs-target='#deleteAllModal'>Clear All Notes</button>
    </form>
  </div>
  <div class="container">
    <table class="table table-striped table-dark table-condensed" style="border-radius:10px;overflow:hidden;text-align:center;" id="myTable">
      <thead class="thead-dark">
        <tr>
          <th scope="col" style="width:65px;">S.No.</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = "SELECT * FROM notes";
        $outcome = mysqli_query($connection, $query);
        $i = 0;
        while ($row = mysqli_fetch_assoc($outcome)) {
          ++$i;
          echo "<tr class='dataTable'>
          
      <th scope='row' style='text-align:center;'>" .
            $i .
            "</th>
      <td>" .
            $row["title"] .
            "</td>
      <td class='td'>" .
            htmlspecialchars($row["description"]) .
            "</td>
      <td>" .
            "<button type='button' class='btn btn-primary custom edit' data-bs-toggle='modal' data-bs-target='#editModal' id=".$row['sno'].">Edit</button>    
            <button type='button' class='btn btn-danger custom delete' data-bs-toggle='modal' data-bs-target='#deleteModal' id=".$row['sno'].">Delete</button>
            " .
            "</td>
    </tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <script type="text/javascript" charset="utf-8">
  let table = new DataTable('#myTable');
  let f = e => document.querySelector(e);
  let ff = e => document.querySelectorAll(e);
  ff(".edit").forEach((valuee,index)=>{
    valuee.onclick = function(e){
      ff(".edit").forEach((element,number)=>{
        if(number == index){
          let title = element.parentNode.parentNode.querySelector("td:first-of-type").innerText;
          let desc = element.parentNode.parentNode.querySelector("td:nth-child(3)").innerText;
          f("#editTitle").value = title;
          f("#editDesc").value = desc;
          f("#editSno").value = e.target.id;
        }
      })
    }
  })  
  ff(".delete").forEach((value,index)=>{
    value.onclick = function(e){
      ff(".delete").forEach((element,number)=>{
        if(number == index){
          f("#deleteSno").value = e.target.id;
        }
      })
    }
  })
  </script>
</body>
</html>