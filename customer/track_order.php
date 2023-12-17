<!DOCTYPE html>
<html>
    <head>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'></script>
    </head>
    <body>
        
    </body>
</html>


<?php

$orderid=$_GET['orderid'];

include_once "../shared/connection.php";
include "menu.html";

$track = mysqli_query($conn, "select DATE(created_date) as placed, DATE(DATE_ADD(orders.created_date, INTERVAL 1 DAY)) as confirmed, DATE(DATE_ADD(orders.created_date, INTERVAL 3 DAY)) as shipped, DATE(DATE_ADD(orders.created_date, INTERVAL 4 DAY)) as outfordelivery, DATE(DATE_ADD(orders.created_date, INTERVAL 5 DAY)) as delivered from orders where orderid=$orderid;");

while($row = mysqli_fetch_assoc($track)){
    $placed = $row['placed'];
    $place = date("d-m-Y",strtotime($placed));
    $confirmed=$row['confirmed'];
    $confirm = date("d-m-Y",strtotime($confirmed));
    $shipped=$row['shipped'];
    $ship = date("d-m-Y",strtotime($shipped));
    $outfordelivery=$row['outfordelivery'];
    $outfor = date("d-m-Y",strtotime($outfordelivery));
    $delivered=$row['delivered'];
    $deliver = date("d-m-Y",strtotime($delivered));
    
    echo "<div class=' mt-5 d-flex justify-content-center vh-75 align-items-center'>
            <div class='bg-light p-4 h3'>
              <table >
                <tr>
                  <th style='color:maroon'; 'font-size:500px !important;'>Order placed on </th>
                  <td>$place</td>  
                </tr>
                <tr>
                  <th style='color:maroon';>confirmed on </th>
                  <td>$confirm </td>
                </tr>
                <tr>
                  <th style='color:maroon';>shipped on </th>
                  <td>$ship </td>
                </tr>
                <tr>
                  <th style='color:maroon';>out for delivery </th>
                  <td>$outfor </td>
                </tr>
                <tr >
                  <th style='color:maroon';> delivered on </th>
                  <td>$deliver </td>
                </tr>
              </table>
            </div>
          </div>
          <div class='mt-5 d-flex justify-content-center vh-75 align-items-center'>
            <div class='btn btn-large btn-warning fw-bold'>
 ";
}

$db_query = mysqli_query($conn,"select status from orders where orderid = $orderid");

while($row = mysqli_fetch_assoc($db_query)){
  $status = $row['status'];
  
  switch ($status) {
    case "placed":
      echo "Your order is placed at present";
      break;
    case "confirmed":
      echo "Your order is confirmed at present";
      break;
    case "shipped":
      echo "Your order is shipped at present";
      break;
    case "out for delivery":
      echo "Your order is out for delivery at present";
      break;
    case "delivered":
      echo "Your order is delivered at present";
      break;
    case "Returning":
      echo "Your order is Returning at present... order will be collected within a week...";
      break;
    case "Returned":
      echo "Your order is Returned at present";
      break;
    default:
      echo "Your order is not updated at present, please wait!!";
      break;
    }                 
    echo "</div></div>";
  }

?>