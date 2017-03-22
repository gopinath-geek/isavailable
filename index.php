<html>
      <head>
            <title>Is Available ? || A Techie Cat Product</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      </head>
</html>

<?php
$db = pg_connect("host=ec2-176-34-113-15.eu-west-1.compute.amazonaws.com port=5432 dbname=d7idvta5j12bu8 user=hbvbxoabwlcwwo password=7fc101a7a3462d275bde95493f6b66a35a17ec874b9a99b5eff263c56b4caabc") or exit("cannot connect db");
$stat = pg_connection_status($db);

$sql = 'create table if not exists isavailable(ip_address varchar(50) primary key, status varchar(1) not null)';
$result = pg_query($db, $sql);

$ip_address = getenv('HTTP_CLIENT_IP')?:getenv('HTTP_X_FORWARDED_FOR')?:getenv('HTTP_X_FORWARDED')?:getenv('HTTP_FORWARDED_FOR')?:getenv('HTTP_FORWARDED')?:getenv('REMOTE_ADDR');

$sql = 'select count(*) as is_ip_exist from isavailable where ip_address='.$ipaddress;
$result = pg_query($sql);
$result_set = pg_fetch_all($sql);
$status_message = "Occupy";
if(count($result_set) == 0){
      echo '<div class="col-xs-5 col-xs-push-5"><form action=""><button type="submit" class="btn btn-primary" name="status">'.$status_message.'</button></form></div>';
}else{
      
}


/*
$selectfields = array("ip_address" => $ip_address);
    $records = pg_select($db,"isavailable",$selectfields);
    print_r($records);
*/
pg_close($db);
