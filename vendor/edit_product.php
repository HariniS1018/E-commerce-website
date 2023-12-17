<?php

$pid=$_GET['pid'];

include "authguard.php";
include "menu.html";
include_once "../shared/connection.php";

$detail = mysqli_query($conn,"select * from product where pid= $pid ");
$row=mysqli_fetch_assoc($detail);
$pid=$row['pid'];
$name=$row['name'];
$details=$row['details'];
$discount=$row['discount'];
$price=$row['price'];
$impath=$row['impath'];
$dest_file_path = 'C:/xampp/htdocs/EducationalWebsite/shared/images/FB.JPG';
echo "<html lang='en'>
<head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script>
</head>
<body>
    <div><br></div>
    <div class='d-flex justify-content-center vh-75 align-items-center'>
        <form action='editted_product.php?pid=$pid' class='bg-info p-4' method='post' enctype='multipart/form-data'>
            <div class='text-center text-white'>
                <h4>Upload Product here...</h4>
            </div>
            <hr>
            <input type='text' name='pro_name' placeholder='Product name' class='form-control mt-2' value=$name>
            <input type='number' name='pro_price' placeholder='Product price' class='form-control mt-2' value=$price>
            <textarea cols='30' rows='5' name='pro_details' placeholder='Product description...' class='form-control mt-2' >{$details}</textarea>
            <input type='file' name='pro_img' placeholder='Product image' class='form-control mt-2'>
            <input type='number' name='pro_discount' placeholder='Product discount' class='form-control mt-2' value=$discount>
            <div class='text-center'>
                <button class='btn btn-warning mt-3'>edit</button>
            </div>
        </form>
    </div>
</body>
</html>
"
?>
