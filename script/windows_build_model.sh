#!/bin/sh

cd application

if [  -e  /c/xampp/php/php ]
then
/c/xampp/php/php doctrine-cli.php orm:generate-entities models
/c/xampp/php/php doctrine-cli.php orm:generate-proxies
fi

if [  -e  /d/xampp/php/php ]
then
/d/xampp/php/php doctrine-cli.php orm:generate-entities models
/d/xampp/php/php doctrine-cli.php orm:generate-proxies
fi

if [  -e  /e/xampp/php/php ]
then
/e/xampp/php/php doctrine-cli.php orm:generate-entities models
/e/xampp/php/php doctrine-cli.php orm:generate-proxies
fi

if [  -e /cygdrive/c/xampp/php/php ]
then
/cygdrive/c/xampp/php/php doctrine-cli.php orm:generate-entities models
/cygdrive/c/xampp/php/php doctrine-cli.php orm:generate-proxies
fi

if [  -e /cygdrive/d/xampp/php/php ]
then
/cygdrive/d/xampp/php/php doctrine-cli.php orm:generate-entities models
/cygdrive/d/xampp/php/php doctrine-cli.php orm:generate-proxies
fi
