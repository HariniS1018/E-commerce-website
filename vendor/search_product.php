<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .searchbar{
            margin: 5px;
        }
        .search{
            height: 40px;
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
        .discount{
            color:darkviolet;
        }
        .pdtimg-container{
            width:100%;            
        }
        .pdtimg{
            width:100%;
            height: 200px;
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
    </style>
</head>
<body>
</body>
</html>

<?php
include_once "authguard.php";
include "menu.html";
include_once "../shared/connection.php";

$name  = $_GET['searchproduct'];
$userid=$_SESSION['User_Id'];

$sql_cursor=mysqli_query($conn,"select * from product where uploaded_by=$userid and name like '$name%' or name like '%$name' and uploaded_by=$userid");
if (mysqli_num_rows($sql_cursor) == 0){
    $sql_cursor=mysqli_query($conn,"select * from product where uploaded_by=$userid");
}

while($row=mysqli_fetch_assoc($sql_cursor)){

    $pid=$row['pid'];
    $name=$row['name'];
    $details=$row['details'];
    $price=$row['price'];
    $impath=$row['impath'];

    $pid=$row['pid'];
    $name=$row['name'];
    $details=$row['details'];
    $price=$row['price'];
    $impath=$row['impath'];
    $discount=$row['discount'];
    $saleprice = $price - ($discount/100*$price);

    echo "<div class='card'>
            <div class='card-body'>";
    
            if($discount == 0){
                echo"       <h4>$name</h4>
                            <div class='orgprice'>Rs $price</div>
                            <div class='pdtimg-container'>
                                <img class='pdtimg' src='$impath'>
                            </div>
                            <div class='mt-1 card-text'>$details</div>
                            <div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                                <a href= 'edit_product.php?pid=$pid' ><button class='btn btn-warning'>Edit</button></a>        
                                <button onclick='confirmDelete($pid)' class='btn btn-danger'>Delete</button>
                                    
                            </div>
                            <div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                                <a href='reviews.php?pid=$pid' class='btn btn-primary'>customer reviews here</a>
                            </div>
                        </div>
                    </div>";
            }
            else{
                echo"       <h4 class='card-title'>$name</h4>
                            <h3 class='discount'>$discount% OFF</h3>
                            <div class='orgprice'><s>Rs $price</s></div>
                            <div class='saleprice'>$saleprice</div>
                            <div class='pdtimg-container'>
                                <img class='pdtimg' src='$impath'>
                            </div>
                            <div class='mt-1 card-text'>$details</div>
                            <div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                                <a href= 'edit_product.php?pid=$pid' ><button class='btn btn-warning'>Edit</button></a>        
                                <button onclick='confirmDelete($pid)' class='btn btn-danger'>Delete</button>    
                            </div>
                            <div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                                <a href='reviews.php?pid=$pid' class='btn btn-primary'>customer reviews here</a>
                            </div>
                        </div>
                    </div>";
            }
        }
        ?>