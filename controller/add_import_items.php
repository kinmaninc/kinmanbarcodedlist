<?php
require '../configuration.php';


if(!empty($_FILES['csv_file_add']['name'])){
  $ctr_success = 0;
  $ctr_failed = 0;
  $mymessage = "";
  $output= "";
  $allowed_ext = array("csv");
  $tmp = explode(".", $_FILES["csv_file_add"]["name"]);
  $extension = end($tmp);
  if(in_array($extension, $allowed_ext)){
    $file_data = fopen($_FILES["csv_file_add"]["tmp_name"], "r");
    fgetcsv($file_data);
    while($row = fgetcsv($file_data)){
 
      $ean = mysqli_real_escape_string($connection, $row[0]);
      $upc = mysqli_real_escape_string($connection, $row[1]);
      $category = mysqli_real_escape_string($connection, $row[2]);
      $item_name = mysqli_real_escape_string($connection, $row[3]);
      $cover = mysqli_real_escape_string($connection, $row[4]);
      $description = mysqli_real_escape_string($connection, $row[5]);
      $price = mysqli_real_escape_string($connection, number_format(floatval($row[6]), 2, '.', ''));
      $weight = mysqli_real_escape_string($connection, $row[7]);
      $notes = mysqli_real_escape_string($connection, $row[8]);

      $esql = "SELECT id, upc, ean FROM inv_pickups WHERE upc='$upc' OR ean='$ean'";
      $results = mysqli_query($connection, $esql);
      if(mysqli_num_rows($results) == 0 && is_numeric($ean) == 1){
           // row not found, do stuff...
        $ctr_success++;
        $query = "INSERT INTO inv_pickups (ean, upc, category, item_name, cover, description, price, weight, notes)
          VALUES 
          ('$ean', '$upc', '$category', '$item_name', '$cover', '$description', '$price', '$weight', '$notes')";
        mysqli_query($connection, $query);

      } else {
          // do other stuff...
        if(empty($ean)){
          
        }
        else{
          $mymessage .= "<li>ID: ".$ean." - existing.</li>";
          $ctr_failed++;
        }
      }

      
    }
    //echo success here
    echo '<hr>';
    echo '<ul>Updated items: '.$ctr_success.'</ul>';
    echo '<ul>Failed to update items: '.$ctr_failed;
    echo $mymessage;
    echo '</ul>';
  }
  else{
    echo "Error1";
  }
}
else{
  echo 'Error2';
}



?>