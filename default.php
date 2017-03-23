<?php

echo getenv('HTTP_CLIENT_IP')."\n";
echo getenv('HTTP_X_FORWARDED_FOR')."\n";
echo getenv('HTTP_X_FORWARDED')."\n";
echo getenv('HTTP_FORWARDED_FOR')."\n";
echo getenv('HTTP_FORWARDED')."\n";
echo getenv('REMOTE_ADDR')."\n";
