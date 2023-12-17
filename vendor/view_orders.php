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
    function confirmDispatch(orderid){
        res=confirm("Are you sure the product been dispatched? ");
        if(res){
            window.location=`dispatch_product.php?orderid=${orderid}`;
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
$sql_cursor=mysqli_query($conn," select pro.pid,pro.name,pro.details,pro.price,pro.impath,orders.status,pro.discount,orders.orderid,orders.quantity from product as pro join orders where pro.pid in (select orders.pid from orders) and pro.uploaded_by = $userid and pro.pid = orders.pid;");

while($row=mysqli_fetch_assoc($sql_cursor)){
    

    $pid=$row['pid'];
    $name=$row['name'];
    $details=$row['details'];
    $price=$row['price'];
    $impath=$row['impath'];
    $status = $row['status'];
    $orderid = $row['orderid'];
    $discount = $row['discount'];
    $quantity=$row['quantity'];
    $saleprice = $price - ($discount/100*$price);
    $str = strcasecmp($status,'returning');
    $str1 = strcasecmp($status,'returned');
    
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
        if($str ===0){
        echo"       <div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                        <button class='btn btn-danger'><b>current status: </b>$status</button>
                        <a href='track_update.php?orderid=$orderid' class='btn btn-primary'>update status</a>
                    </div>
                    <div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                        <a href='ViewReason.php?orderid=$orderid' class='btn btn-primary'>View Reason</a>
                    </div>";
        }
        elseif($str1 === 0){
        echo"       <div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                        <button class='btn btn-danger'><b>current status: </b>$status</button>
                        <a href='ViewReason.php?orderid=$orderid' class='btn btn-primary'>View Reason</a>
                    </div>";
                       }
        else{
        echo"       <div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                        <button class='btn btn-danger'><b>current status: </b>$status</button>
                        <a href='track_update.php?orderid=$orderid' class='btn btn-primary'>update status</a>
                    </div>";
                    
        }
        echo "</div></div>";
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
                    <div class='qty-container'>Quantity:
                        <input name='qty' readonly class='qty' type='number' value=$quantity>
                    </div>";
        if($str ===0){
            echo"       <div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                            <button class='btn btn-danger'><b>current status: </b>$status</button>
                            <a href='track_update.php?orderid=$orderid' class='btn btn-primary'>update status</a>
                        </div>
                        <div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                            <a href='ViewReason.php?orderid=$orderid' class='btn btn-primary'>View Reason</a>
                        </div>";
            }
            elseif($str1 === 0){
            echo"       <div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                            <button class='btn btn-danger'><b>current status: </b>$status</button>
                            <a href='ViewReason.php?orderid=$orderid' class='btn btn-primary'>View Reason</a>
                        </div>";
          }
            else{
            echo"       <div class='mt-2 d-flex  gap-3 justify-content-evenly'>
                            <button class='btn btn-danger'><b>current status: </b>$status</button>
                            <a href='track_update.php?orderid=$orderid' class='btn btn-primary'>update status</a>
                        </div>";
                        
            }
            echo" </div></div>";
    }
}
?>