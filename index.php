<html>
      <head>
            <title>Is Available ? || A Techie Cat Product</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
      </head>
 <body>
       <div class="container">
             <div class="col-xs-10 col-xs-push-1">
                   <label class="label label-danger">It's Beta !</label>
             </div>
       </div>
<?php
//truncate_table();
$status_message = "";
$success = 1;

$image_url_prefix = "https://raw.githubusercontent.com/gopinath-geek/isavailable/master/";
$db = pg_connect("host=ec2-176-34-113-15.eu-west-1.compute.amazonaws.com port=5432 dbname=d7idvta5j12bu8 user=hbvbxoabwlcwwo password=7fc101a7a3462d275bde95493f6b66a35a17ec874b9a99b5eff263c56b4caabc") or exit("cannot connect db");
$stat = pg_connection_status($db);

$sql = 'create table if not exists isavailable(ip_address varchar(50) primary key, timestamp varchar(50), status varchar(1) not null)';
$result = pg_query($db, $sql);

$ip_address = getenv('HTTP_CLIENT_IP')?:getenv('HTTP_X_FORWARDED_FOR')?:getenv('HTTP_X_FORWARDED')?:getenv('HTTP_FORWARDED_FOR')?:getenv('HTTP_FORWARDED')?:getenv('REMOTE_ADDR');
$ip_address_long = ip2long($ip_address);

//echo $ip_address;

if(isset($_REQUEST['status']) && !empty($_REQUEST['status'])){
      $query_string = $_REQUEST['status'];
      if ($query_string == "Occupy"){
            $time = time();
            $sql = "insert into isavailable values($ip_address_long, $time, '1')";
            $result = pg_query($db, $sql);
            if($result === false){
                  //echo pg_last_error();
            }
      }else if ($query_string == "Release"){
            $ip_details = get_ip_from_db();
            if($ip_details["ip_address"].$ip_details["timestamp"] == $ip_address_long.$ip_details["timestamp"] ){
                  truncate_table();
            }
      }
}

$sql = 'select * from isavailable';
$result = pg_query($db, $sql);
$affected_rows = pg_affected_rows($result);

//echo "affected rows ".$affected_rows;
if($affected_rows == 0){
      //$status_message = "Occupy";
      //$alert_visibility_success = "";
      //$alert_visibility_danger = "hidden";
      display_buttons("Occupy", "free.png", "enabled");
      //echo '<div class="col-xs-5 col-xs-push-5"><form action=""><button type="submit" class="btn btn-success" name="status" value="'.$status_message.'">'.$status_message.'</button></form></div>';
}else{
      /*$affected_rows = pg_affected_rows($result);
      echo "Affected row".$affected_rows;
      */
      $ip_details = get_ip_from_db();
      global $success;
      $success = 2;
      if($ip_details["ip_address"].$ip_details["timestamp"] == $ip_address_long.$ip_details["timestamp"]){
            //$status_message = "Release";
            display_buttons("Release", "exit.png", "enabled");
            //echo '<div class="col-xs-5 col-xs-push-5"><form action=""><button type="submit" class="btn btn-warning" name="status" value="'.$status_message.'">'.$status_message.'</button></form></div>';
      }else{
            global $success;
            $success = 0;
            //$alert_visibility_success = "hidden";
            //$alert_visibility_danger = "";
            //$status_message = "Wait";
            display_buttons("Wait", "wait.png", "disabled");
            //echo '<div class="col-xs-5 col-xs-push-5"><form action=""><button type="submit" class="btn btn-danger" name="status" value="'.$status_message.'" disabled>'.$status_message.'</button></form></div>';
      }
}

function display_buttons($status_message, $image_src, $accessibility){
      global $success;
      //echo '<div class="col-xs-5 col-xs-push-5"><form action=""><button type="submit" class="btn '.$class_name.'" name="status" value="'.$status_message.'" '.$accessible.'>'.$status_message.'</button></form></div>';
      if($success == 1){
            echo '<div class="container"><div class="alert alert-success"><strong>Yeah ! It is available</strong></div></div>';
      }else if($success == 0){
            echo '<div class="alert alert-danger"><strong>Oh, No ! It is not available</strong></div>';
      }else if($success == 2){
            echo '<div class="alert alert-warning"><strong>Make way for others</strong></div>';
      }
      
      echo '<p style="margin-top:20px;"></p>
      <div class="container">
          <div class="col-sm-6 col-push-sm-3 col-md-4 col-push-md-4 col-lg-push-4">
              <div class="panel panel-info">
                  <div class="panel-body text-center">
                      <form class="form text-center" style="padding:50px;" action="#">
                          <input type="hidden" value="'.$status_message.'" name="status">
                          <button type="submit" class="btn btn-default" '.$accessibility.'>
                              <img src="'.$image_url_prefix.$image_src.'" style="padding:50px;">
                          </button>
                          <h4>'.$status_message.'</h4>
                      </form>
                      <a class="btn btn-warning" href="http://isavailable.herokuapp.com/">
                        <img src="'.$image_url_prefix.'refresh.png">
                      </a>
                  </div>
              </div>
          </div>
      </div>';
}

function get_ip_from_db(){
      $db = pg_connect("host=ec2-176-34-113-15.eu-west-1.compute.amazonaws.com port=5432 dbname=d7idvta5j12bu8 user=hbvbxoabwlcwwo password=7fc101a7a3462d275bde95493f6b66a35a17ec874b9a99b5eff263c56b4caabc") or exit("cannot connect db");
      $sql = 'select ip_address, timestamp from isavailable';
      $result = pg_query($db, $sql);
      $result_set = pg_fetch_all($result);
      return array("ip_address"=>$result_set[0]["ip_address"], "timestamp"=>$result_set[0]["timestamp"]);
}

function truncate_table(){
      $db = pg_connect("host=ec2-176-34-113-15.eu-west-1.compute.amazonaws.com port=5432 dbname=d7idvta5j12bu8 user=hbvbxoabwlcwwo password=7fc101a7a3462d275bde95493f6b66a35a17ec874b9a99b5eff263c56b4caabc") or exit("cannot connect db");
      $sql = "truncate table isavailable";
      $result = pg_query($db, $sql);
}
pg_close($db);
?>
</body>
</html>
