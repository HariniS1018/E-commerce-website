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
        .discount{
            color:darkviolet;
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
        .pdtimg-container{
            width:100%;    
            height: 280px;
        }
        .pdtimg{
            width:100%;
            height: 240px;
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
    
<script>
    function cancelorder(orderid){
        res=confirm("Are you sure to cancel the order? ");
        if(res){
            window.location=`cancel_order.php?orderid=${orderid}`;
        }
    }
    function returnorder(orderid){
        res=confirm("Are you sure to return the product? ");
        if(res){
            window.location=`Return_product.php?orderid=${orderid}`;
        }
    }
</script>
</body>
</html>
<?php

include "authguard.php";
include "menu.html";
include_once "../shared/connection.php";

$userid=$_SESSION['User_Id'];

$sql_cursor=mysqli_query($conn,"select orders.status,orders.quantity,orders.orderid,pro.discount,pro.pid,pro.name,pro.price,pro.details,pro.impath from product as pro join orders on pro.pid = orders.pid where userid = $userid;");

while($row=mysqli_fetch_assoc($sql_cursor)){
    
    $orderid = $row['orderid'];
    $pid=$row['pid'];
    $name=$row['name'];
    $details=$row['details'];
    $price=$row['price'];
    $impath=$row['impath'];
    $status = $row['status'];
    $quantity=$row['quantity'];
    $discount=$row['discount'];
    $saleprice = $price - ($discount/100*$price);
    $str = strcasecmp($status,'delivered');
    $str1 = strcasecmp($status,'Returning');
    
    echo "<div class='card'>
            <div class='card-body'>";

    if($discount == 0){
        echo"       <h4>$name</h4>
                    <div class='orgprice'>Rs $price</div>
                    <div class='pdtimg-container'>
                        <img class='pdtimg' src='$impath'>
                    </div>
                    <div class='mt-1 card-text'>$details</div>
                    <div class='qty-container'>Quantity:
                        <input name='qty' readonly class='qty' type='number' value=$quantity>
                    </div>";
            if($str !==0 && $str1 !==0){
                echo "<div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                        <button onclick='cancelorder($orderid)' class='btn btn-danger'>cancel order</button>
                        <a href='track_order.php?orderid=$orderid'><button class='btn btn-warning'>track order</button></a>
                    </div>";
            }
            elseif($str !==0 && $str1 ===0){
                echo "<div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                        <button class='btn btn-danger'>$status</button>
                        <a href='Reason_me.php?orderid=$orderid'><button class='btn btn-warning'>Reason why?</button></a>
                    </div>";
            }
            else{
                echo"<div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                        <a href='Rate_me.php?orderid=$orderid'><button class='btn btn-danger'>Rate me</button></a>
                        <button onclick='returnorder($orderid)' class='btn btn-warning'>Return product</button>
                    </div>";
            }
        echo"</div></div>";
        
    }
    else{
        echo"   <h4 class='card-title'>$name</h4>
                <h3 class='discount'>$discount% OFF</h3>
                <div class='orgprice'><s>Rs $price</s></div>
                <div class='saleprice'>$saleprice</div>
                <div class='pdtimg-container'>
                    <img class='pdtimg' src='$impath'>
                </div>
                <div class='mt-1 card-text'>$details</div>
                <div class='qty-container'>Quantity:
                    <input name='qty' readonly class='qty' type='number' value=$quantity>
                </div>";
            if($str !==0 && $str1 !==0){
                echo "<div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                        <button onclick='cancelorder($orderid)' class='btn btn-danger'>cancel order</button>
                        <a href='track_order.php?orderid=$orderid'><button class='btn btn-warning'>track order</button></a>
                    </div>";
            }
            elseif($str !==0 && $str1 ===0){
                echo "<div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                        <button class='btn btn-danger'>$status</button>
                        <a href='Reason_me.php?orderid=$orderid'><button class='btn btn-warning'>Reason why?</button></a>
                    </div>";
            }
            else{
                echo"<div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                        <a href='Rate_me.php?orderid=$orderid'><button class='btn btn-danger'>Rate me</button></a>
                        <button onclick='returnorder($orderid)' class='btn btn-warning'>Return product</button>
                    </div>";
            }
        echo"</div></div>";
    }

}

?>