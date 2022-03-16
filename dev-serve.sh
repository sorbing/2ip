#!/bin/bash

echo "Serve on: http://127.0.0.1:8090"
php -S 0.0.0.0:8090 -t public/
