<html>
      <head>
            <title>Is Available ? || A Techie Cat Product</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      </head>
</html>

<?php
$status_message = "";

$db = pg_connect("host=ec2-176-34-113-15.eu-west-1.compute.amazonaws.com port=5432 dbname=d7idvta5j12bu8 user=hbvbxoabwlcwwo password=7fc101a7a3462d275bde95493f6b66a35a17ec874b9a99b5eff263c56b4caabc") or exit("cannot connect db");
$stat = pg_connection_status($db);

$sql = 'create table if not exists isavailable(ip_address varchar(50) primary key, status varchar(1) not null)';
$result = pg_query($db, $sql);

$ip_address = getenv('HTTP_CLIENT_IP')?:getenv('HTTP_X_FORWARDED_FOR')?:getenv('HTTP_X_FORWARDED')?:getenv('HTTP_FORWARDED_FOR')?:getenv('HTTP_FORWARDED')?:getenv('REMOTE_ADDR');
$ip_address_long = ip2long($ip_address);

if(isset($_REQUEST['status']) && !empty($_REQUEST['status'])){
      $query_string = $_REQUEST['status'];
      if ($query_string == "Occupy"){
            $sql = "insert into isavailable values($ip_address_long, '1')";
            echo $sql;
            $result = pg_query($db, $sql);
            if($result === false){
                  echo pg_last_error($db);
            }else{
                  $status_message = "Wait";
            }
            
      }else if ($query_string == "Wait" || $query_string == "Release"){
            $sql = "truncate table isavailable";
            $result = pg_query($db, $sql);
            
            if($result === false){
                  echo pg_last_error($db);
            }else{
                  $status_message = "Occupy";
            }
      }
}

$sql = 'select * from isavailable';
$result = pg_query($db, $sql);
$affected_rows = pg_affected_rows($result);

if($affected_rows == 0){
      //$status_message = "Occupy";
      display_buttons("Occupy", "btn-success");
      //echo '<div class="col-xs-5 col-xs-push-5"><form action=""><button type="submit" class="btn btn-success" name="status" value="'.$status_message.'">'.$status_message.'</button></form></div>';
}else{
      $sql = 'select ip_address from isavailable';
      $result = pg_query($db, $sql);
      $result_set = pg_fetch_all($result);
      $this_ip = $result_set[0]["ip_address"];
      
      /*$affected_rows = pg_affected_rows($result);
      echo "Affected row".$affected_rows;
      */
      if($this_ip == ip2long($ip_address)){
            //$status_message = "Release";
            display_buttons("Release", "btn-warning");
            //echo '<div class="col-xs-5 col-xs-push-5"><form action=""><button type="submit" class="btn btn-warning" name="status" value="'.$status_message.'">'.$status_message.'</button></form></div>';
      }else{
            //$status_message = "Wait";
            display_buttons("Wait", "btn-danger");
            //echo '<div class="col-xs-5 col-xs-push-5"><form action=""><button type="submit" class="btn btn-danger" name="status" value="'.$status_message.'" disabled>'.$status_message.'</button></form></div>';
      }
}

function display_buttons($status_message, $class_name){
      echo '<div class="col-xs-5 col-xs-push-5"><form action=""><button type="submit" class="btn '.$class_name.'" name="status" value="'.$status_message.'" disabled>'.$status_message.'</button></form></div>';
}
pg_close($db);
