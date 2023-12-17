<!DOCTYPE html>
<html lang="en">
<head>
    <style>
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
    </style>
</head>
<body>
</body>
</html>

<?php

include "authguard.php";
include "menu.html";

$userid=$_SESSION['User_Id'];

include_once "../shared/connection.php";

$sql_cursor=mysqli_query($conn,"select cart.quantity,cart.cartid,cart.pid,product.name,product.price,product.details,product.discount,product.impath from cart join product on cart.pid=product.pid where cart.userid= $userid;");

while($row=mysqli_fetch_assoc($sql_cursor)){

    $cartid=$row['cartid'];
    $pid=$row['pid'];
    $name=$row['name'];
    $details=$row['details'];
    $price=$row['price'];
    $impath=$row['impath'];
    $quantity=$row['quantity'];
    $discount=$row['discount'];
    $saleprice = $price - ($discount/100*$price);
    
    echo "
            <div class='card'>
                <div class='card-body'>
                    ";

    if($discount == 0){
        echo"       <h4>$name</h4>
                    <div class='orgprice'>Rs $price</div>
                    <div class='pdtimg-container'>
                        <img class='pdtimg' src='$impath'>
                    </div>
                    <div class='mt-1 card-text'>$details</div>
                    <form action='editted_cart.php' method='post'>
                    <b>CartId: </b><input class='w-25 border-0' readonly type='hidden'name='cartid' value='$cartid'>
                    <div class='qty-container'><b>Edit Quantity:</b>
                        <input name='qty' class='qty' type='number' value=$quantity>
                    </div>
                    <div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                        <button type='submit' class='btn btn-warning'> submit</button>
                    </div>
                    </form>
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
                    <form action='editted_cart.php' method='post'>
                    <b>CartId: </b><input class='w-25 border-0' readonly type='hidden'name='cartid' value='$cartid'>
                    <div class='qty-container'><b>Edit Quantity:</b>
                        <input name='qty' class='qty' type='number'value=$quantity>
                    </div>
                    <div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                        <button type='submit' class='btn btn-warning'> submit</button>
                    </div>
                    </form>
                </div>
            </div>";
    }
}
?>