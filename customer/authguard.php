<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    
</body>
</html>

<?php

session_start();

if(!isset($_SESSION["login_status"])){
    echo "illegal attempt";
    die;
}
if($_SESSION["login_status"] == false){
    echo "Unauthorised attempt";
    die;
}
if($_SESSION['User_type'] != 'customer'){
    echo "U 've no permission to access this resource";
    die;
}

$User_name = $_SESSION['User_name'];
$User_type = $_SESSION['User_type'];
$User_Id = $_SESSION['User_Id'];
echo "<div class='d-flex justify-content-evenly p-3 bg-secondary text-white'>
    <div>$User_name</div>
    <div>$User_type</div>
    <div>$User_Id</div>
</div>";
?>