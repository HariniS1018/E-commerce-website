<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        .parent{
            display: flex;
            width:1350px;
            height: 100%;
            justify-content: space-evenly; 
            align-items: center; 
        }
        .child{
            padding:10px;
        }
        .card{
            width:300px;            
            display:inline-block !important;
            margin:10px;
        }
        .card-title{
            float: left;
            margin-right: 30px;
        }
        .qty-container
        {
            margin-top:5px;
            text-align: center;
        }
        .qty
        {
            width:50%;
            margin-left: 5px;           
        }
        .discount{
            color:darkviolet;
        }
        .pdtimg-container{
            width:100%;            
        }
        .pdtimg{
            width:100%;
        }
        .orgprice{
            float: left;
            font-size:24px;
            color:violet;
        }
        .saleprice{
            float: left;
            font-size:24px;
            color:violet;
            margin-left: 10px;
        }
        .saleprice::before{
            content:"Rs ";
        }
        .review{
            display: flex;
            width: 530px;
        }
        .checked {
            color: orange;
        }

    </style>
</head>
<body>
</body>
</html>

<?php

include "authguard.php";
include "menu.html";

$userid=$_SESSION['User_Id'];
$pid=$_GET['pid'];

include_once "../shared/connection.php";

$query = mysqli_query($conn,"select * from product as pro join customer_reviews as cr on pro.pid=cr.pid where cr.pid=$pid;");
$query2 = mysqli_query($conn," select *from security as user where user.User_Id in (select userid from customer_reviews as cr where cr.pid=8004);");
$count = 0;
if(mysqli_num_rows($query) == 0 ){
    echo "<div style='align-items:center'><div style='margin:100px 100px 100px 500px;'><h2>No reviews on this item</h2></div>
                <div class='mt-2 d-flex  gap-1 justify-content-evenly'>
                <a href='home.php' class='btn btn-warning'>Go back</a>
            </div></div>";
}
else{
while($row=mysqli_fetch_assoc($query)){
    $rows=mysqli_fetch_assoc($query2);
    if($count == 0){
        $count = 1;
        
        $name=$row['name'];
        $details=$row['details'];
        $price=$row['price'];
        $impath=$row['impath'];
        $discount=$row['discount'];
        $saleprice = $price - ($discount/100*$price);

        echo "<div class='parent'><div class='child'><div class='card'>
                    <div class='card-body'>";

        if($discount == 0){
            echo"       <h4>$name</h4>
                        <div class='orgprice'>Rs $price</div>
                        <div class='pdtimg-container'>
                            <img class='pdtimg' src='$impath'>
                        </div></div>
                        </div>
                        <div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                            <a href='home.php' class='btn btn-warning'> back</a>
                        </div></div>";
        }
        else{
            echo"       <h4 class='card-title'>$name</h4>
                        <h3 class='discount'>$discount% OFF</h3>
                        <div class='orgprice'><s>Rs $price</s></div>
                        <div class='saleprice'>$saleprice</div>
                        <div class='pdtimg-container'>
                            <img class='pdtimg' src='$impath'>
                        </div></div></div>
                        <div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                            <a href='home.php' class='btn btn-warning'> back</a>
                        </div></div>";
        }
        echo "<div class='child'><h3 class='text-danger'>comments</h3>";
    }
    $username = $rows['User_name'];
    $review = $row['review'];
    $star_rate = $row['star_rate'];
    
    echo "  
    
            <h4>review given by $username</h4>
            <h4>star rating: $star_rate/5</h4>
            <div class='review'>
                <div name='review' placeholder='Product review...' class='form-control mt-2'>{$review}</div>
            </div><br>";
}
echo "</div></div>";
}
?>