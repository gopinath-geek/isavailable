<?php

$db = pg_connect("host=ec2-176-34-113-15.eu-west-1.compute.amazonaws.com port=5432 dbname=d7idvta5j12bu8 user=hbvbxoabwlcwwo password=7fc101a7a3462d275bde95493f6b66a35a17ec874b9a99b5eff263c56b4caabc") or exit("cannot connect db");
$stat = pg_connection_status($db);

if ($stat === PGSQL_CONNECTION_OK) {
      echo 'Connection status ok';
  } else {
      echo 'Connection status bad';
  }

$create_query = 'create table isavailable(ip_address varchar(50) primary key, status varchar(1) not null)';
$create_query_exec = pg_query($db, "create_table");

if(!$create_query_exec){
      echo pg_last_error($db);
}else{
      echo "Table created successfully";
}

pg_close($db);
