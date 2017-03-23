<?php

echo "one ".getenv('HTTP_CLIENT_IP')."\n";
echo "two ".getenv('HTTP_X_FORWARDED_FOR')."\n";
echo "three ".getenv('HTTP_X_FORWARDED')."\n";
echo "four ".getenv('HTTP_FORWARDED_FOR')."\n";
echo "five ".getenv('HTTP_FORWARDED')."\n";
echo "six ".getenv('REMOTE_ADDR')."\n";

print_r($_SERVER['HTTP_USER_AGENT']);
