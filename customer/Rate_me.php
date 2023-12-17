<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
    <style>
        .split {
            margin-top: 143px;
            height: 80%;
            position: fixed;
            z-index: 1;
            top: 0;
            overflow-x: hidden;
            padding-top: 20px;
        }
        .left {
            width: 25%;
            left: 0;
        }
        .right {
            width: 75%;
            right: 0;
            padding: 25px;
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
        .rating{
            position: absolute;
            top: 60%;
            left: 13%;
            transform: translate(-50%,-50%) rotateY(180deg);
            display: flex;
        }
        .rating input{
            display: none;
        }
        .rating label{
            display: block;
            cursor: pointer;
            width: 50px;
            background: transparent;
        }
        .rating label::before{
            content: '\f005';
            font-family: fontAwesome;
            position: relative;
            display: block;
            font-size: 50px;
            color: black;
        }
        .rating label::after{
            content: '\f005';
            font-family: fontAwesome;
            position: absolute;
            display: block;
            font-size: 50px;
            color: gold;
            top: 0;
            opacity: 0;
            transition: .5s;
            text-shadow: 0 2px 5px rgba(0, 0, 0, .5);
        }
        .rating label:hover:after,
        .rating label:hover ~ label::after,
        .rating input:checked  ~ label::after{
            opacity: 1;
        }
        .review{
            display: flex;
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
$orderid=$_GET['orderid'];

include_once "../shared/connection.php";

$sql_cursor=mysqli_query($conn,"select orders.quantity,orders.orderid,orders.pid,product.name,product.price,product.details,product.discount,product.impath from orders join product on orders.pid=product.pid where orders.pid in (select orders.pid from orders where orders.orderid= $orderid);");

while($row=mysqli_fetch_assoc($sql_cursor)){

    $orderid=$row['orderid'];
    $pid=$row['pid'];
    $name=$row['name'];
    $details=$row['details'];
    $price=$row['price'];
    $impath=$row['impath'];
    $quantity=$row['quantity'];
    $discount=$row['discount'];
    $saleprice = $price - ($discount/100*$price);
    
    echo "<form action='review_store.php' method='post'>
            <div class='split left'>
            <div class='card'>
                <div class='card-body'>
                    <input class='w-25 border-0' readonly type='hidden'name='orderid' value='$orderid'>
                    <input class='w-25 border-0' readonly type='hidden'name='pid' value='$pid'>";
                    

    if($discount == 0){
        echo"       <h4>$name</h4>
                    <div class='orgprice'>Rs $price</div>
                    <div class='pdtimg-container'>
                        <img class='pdtimg' src='$impath'>
                    </div>
                    </div></div></div>";
    }
    else{
        echo"       <h4 class='card-title'>$name</h4>
                    <h3 class='discount'>$discount% OFF</h3>
                    <div class='orgprice'><s>Rs $price</s></div>
                    <div class='saleprice'>$saleprice</div>
                    <div class='pdtimg-container'>
                        <img class='pdtimg' src='$impath'>
                    </div>
                    </div></div></div>";
    }

    echo "<div class='split right'>
            <div class='display-5 mt-1 card-text text-primary'>$details</div>
            <div><br></div>
            <div class='review'>
                <textarea cols='30' rows='5' name='review' placeholder='Product review...' class='form-control mt-2'></textarea>
            </div>
            <div><br></div>
            <h2>star rating</h2>
            <div class='rating'>
                <input type='radio' name='star' id='star1' value='1'><label for='star1'></label>
                <input type='radio' name='star' id='star2' value='2'><label for='star2'></label>
                <input type='radio' name='star' id='star3' value='3'><label for='star3'></label>
                <input type='radio' name='star' id='star4' value='4'><label for='star4'></label>
                <input type='radio' name='star' id='star5' value='5'><label for='star5'></label>
            </div><div><br><br><br></div>
            <div class='mt-2 d-flex'>
                <button type='submit' class='btn btn-warning'> submit</button>
            </div>
        </div>";
}

echo "</form>";

?>