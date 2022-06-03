<?php
require '../configuration.php';


if(!empty($_FILES['csv_file']['name'])){
  $ctr_success = 0;
  $ctr_failed = 0;
  $mymessage = "";
  $output= "";
  $allowed_ext = array("csv");
  $tmp = explode(".", $_FILES["csv_file"]["name"]);
  $extension = end($tmp);
  if(in_array($extension, $allowed_ext)){
    $file_data = fopen($_FILES["csv_file"]["tmp_name"], "r");
    fgetcsv($file_data);
    while($row = fgetcsv($file_data)){
 
      $id = mysqli_real_escape_string($connection, $row[0]);
      $ean = mysqli_real_escape_string($connection, $row[1]);
      $upc = mysqli_real_escape_string($connection, $row[2]);
      $category = mysqli_real_escape_string($connection, $row[3]);
      $item_name = mysqli_real_escape_string($connection, $row[4]);
      $cover = mysqli_real_escape_string($connection, $row[5]);
      $description = mysqli_real_escape_string($connection, $row[6]);
      $price = mysqli_real_escape_string($connection, number_format(floatval($row[7]), 2, '.', ''));
      $weight = mysqli_real_escape_string($connection, $row[8]);
      $notes = mysqli_real_escape_string($connection, $row[9]);
      $img_path = mysqli_real_escape_string($connection, $row[10]);
      $modified_date_time = date("Y-m-d H:i:s");

      $esql = "SELECT id, upc FROM inv_pickups WHERE upc='$upc' AND id<>'$id'";
      $results = mysqli_query($connection, $esql);
      if(mysqli_num_rows($results) == 0 && is_numeric($id) == 1){
           // row not found, do stuff...
        $ctr_success++;
        $query = "UPDATE inv_pickups SET ean = '$ean', upc = '$upc', category = '$category', item_name = '$item_name', cover = '$cover', description = '$description', price = '$price', weight = '$weight', notes = '$notes', img_path = '$img_path', modified_at = '$modified_date_time' WHERE id = '$id'";
        mysqli_query($connection, $query);

      } else {
          // do other stuff...
        if($id == 'ID'){
          
        }else if(empty($id)){
          
        }
        else{
          $mymessage .= "<li>ID: ".$id." - duplicated UPC</li>";
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