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
    function confirmDelete(cartid){
        res=confirm("Are you sure to remove product from cart");
        if(res){
            window.location=`delete_product.php?cartid=${cartid}`;
        }
    }
    function confirmclean(){
        res=confirm("Are you sure to clean the cart" );
        if(res){
            window.location=`delete_product.php`;
        }
    }
</script>
</body>
</html>

<?php

include "authguard.php";
include "menu.html";

$userid=$_SESSION['User_Id'];

include_once "../shared/connection.php";

$sql_cursor=mysqli_query($conn,"select cart.quantity,cart.cartid,cart.pid,product.name,product.price,product.details,product.discount,product.impath from cart join product on cart.pid=product.pid where product.pid in (select cart.pid from cart where cart.cartid not in (select orders.cartid from orders where userid = $userid));");
$total=0;
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
    
    $total+=$saleprice*$quantity;

    echo "<form action='place_orders.php' method='post'>
            <div class='card'>
                <div class='card-body'>";

    if($discount == 0){
        echo"       <h4>$name </h4>
                    <div class='orgprice'>Rs $price</div>
                    <div class='pdtimg-container'>
                        <img class='pdtimg' src='$impath'>
                    </div>
                    <div class='mt-1 card-text'>$details</div>
                    <div class='qty-container'>Quantity:
                        <input readonly name='qty' class='qty' type='number' value=$quantity>
                    </div>
                    <div class='mt-2 d-flex  gap-1'>
                        <a href='edit_product.php?cartid=$cartid' class='btn btn-warning'>Edit product</a>
                        <a onclick='confirmDelete($cartid)' class='btn btn-danger'>Delete product </a>
                    </div>
                </div>
            </div>";
    }
    else{
        echo"       <h4 class='card-title'>$name </h4>
                    <h3 class='discount'>$discount% OFF</h3>
                    <div class='orgprice'><s>Rs $price</s></div>
                    <div class='saleprice'>$saleprice</div>
                    <div class='pdtimg-container'>
                        <img class='pdtimg' src='$impath'>
                    </div>
                    <div class='mt-1 card-text'>$details</div>
                    <div class='qty-container'>Quantity:
                        <input readonly name='qty' class='qty' type='number' value=$quantity>
                    </div>
                    <div class='mt-2 d-flex  gap-1'>
                        <a href='edit_product.php?cartid=$cartid' class='btn btn-warning'>Edit product</a>
                        <a onclick='confirmDelete($cartid)' class='btn btn-danger'>Delete product</a>
                    </div>
                </div>
            </div>";
    }
}

echo "<div class='d-flex gap-1 justify-content-evenly'>
        <b class='h2 mb-5'>Total amount to pay: Rs $total</b>
        <div class='d-inline-block' ><div class='btn btn-danger pr-5' onclick='confirmclean()'> clean cart</div></div>
        <div class='d-inline-block' ><button class='btn btn-warning pr-5' type='submit'>Place Order</button></div>
    </div>
</form>";

?>