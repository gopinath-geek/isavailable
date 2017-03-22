<?php
/*
$db = pg_connect("host=ec2-176-34-113-15.eu-west-1.compute.amazonaws.com port=5432 dbname=d7idvta5j12bu8 user=hbvbxoabwlcwwo password=7fc101a7a3462d275bde95493f6b66a35a17ec874b9a99b5eff263c56b4caabc") or exit("cannot connect db");
$stat = pg_connection_status($db);

if ($stat === PGSQL_CONNECTION_OK) {
      echo 'Connection status ok';
  } else {
      echo 'Connection status bad';
  }

$create_query = pg_prepare($db, "create_table", 'create table if not exist isavailable(ip_address varchar(50) primary key, status varchar(1) not null)');
$create_query = pg_exec($db, "create_table", $create_query, array(""));

if($create_query == false){
      echo "Db is down";
      exit;
}else{
      echo "Db works fine";
}
*/

  try {
      $db = new PDO('pgsql:host=ec2-176-34-113-15.eu-west-1.compute.amazonaws.com;port=5432;dbname=d7idvta5j12bu8;user=hbvbxoabwlcwwo;password=7fc101a7a3462d275bde95493f6b66a35a17ec874b9a99b5eff263c56b4caabc);

      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql ='CREATE TABLE IF NOT EXISTS test (ip_address varchar(50) PRIMARY KEY, availability VARCHAR(1));';
      $db->exec($sql);
  } catch(PDOException $e) {
      echo $e->getMessage();
  }
