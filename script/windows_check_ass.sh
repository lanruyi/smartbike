#!/bin/sh

cd application

if [  -e  /c/xampp/php/php ]
then
/c/xampp/php/php doctrine-cli.php orm:validate-schema
fi

if [  -e  /d/xampp/php/php ]
then
/d/xampp/php/php doctrine-cli.php orm:validate-schema
fi

if [  -e  /e/xampp/php/php ]
then
/e/xampp/php/php doctrine-cli.php orm:validate-schema
fi
