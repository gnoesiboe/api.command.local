#!/bin/bash

echo "Installing Pear"
yum install -y php-pear
echo " --> Pear installed.."

echo "Adding Pear channels"
pear channel-discover pear.phpunit.de
echo " --> Pear channel pear.phpunit.de installed.."
pear channel-discover pear.symfony.com
echo " --> Pear channel pear.symfony.com installed.."


echo "Installing PHPUnit - note this might take a while"
pear install phpunit/PHPUnit
echo " --> PHPUnit installed"
