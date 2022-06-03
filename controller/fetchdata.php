<?php
require '../configuration.php';

$request=$_REQUEST;
$col =array(
    0   =>  'upc',
    1   =>  'ean',
    2   =>  'category',
    2   =>  'item_name',
    3   =>  'description',
    4   =>  'cover',
    5   =>  'notes',
    6   =>  'price'

);  //create column like table in database

$sql ="SELECT * FROM inv_pickups";
$query=mysqli_query($connection,$sql);

$totalData=mysqli_num_rows($query);

$totalFilter=$totalData;

//Search
$sql ="SELECT * FROM inv_pickups WHERE upc<>'' ";
if(!empty($request['search']['value'])){
    $sql.=" AND (upc Like '".$request['search']['value']."%' ";
    $sql.=" OR ean Like '".$request['search']['value']."%' ";
    $sql.=" OR category Like '".$request['search']['value']."%' ";
    $sql.=" OR item_name Like '".$request['search']['value']."%' ";
    $sql.=" OR description Like '".$request['search']['value']."%' ";
    $sql.=" OR cover Like '".$request['search']['value']."%' ";
    $sql.=" OR notes Like '".$request['search']['value']."%' ";
    $sql.=" OR price Like '".$request['search']['value']."%' ";
    $sql.=" OR price Like '".$request['search']['value']."%' )";
}
$query=mysqli_query($connection,$sql);
$totalData=mysqli_num_rows($query);

//Order
// $sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
//     $request['start']."  ,".$request['length']."  ";

$query=mysqli_query($connection,$sql);

$data=array();

while($row=mysqli_fetch_array($query)){
    $subdata=array();

    $subdata[]=$row["upc"];
    $subdata[]=$row["ean"];
    $subdata[]=$row["category"];
    $subdata[]=$row["item_name"];
    $subdata[]=$row["description"];
    $subdata[]=$row["cover"];
    $subdata[]=$row["notes"];
    $subdata[]=$row["price"];

    $data[]=$subdata;
}

$json_data=array(
    "draw"              =>  intval($request['draw']),
    "recordsTotal"      =>  intval($totalData),
    "recordsFiltered"   =>  intval($totalFilter),
    "data"              =>  $data
);

echo json_encode($json_data);

?>
