#!/bin/sh

cd application
php doctrine-cli.php orm:generate-entities models
php doctrine-cli.php orm:generate-proxies
