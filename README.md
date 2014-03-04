api.command.local
=================

Some Rest API setup with several Symfony 2 Components, Doctrine 2 and Vagrant.


Requirements:
=================

* vagrant installed
* virtual box installed
* added vhost for ip address 192.168.3.10


Setup
=================

Command line opzetten van virtual machine:

```
vagrant up
```

Add vhost to your hosts file for ip address 192.168.3.10

```
192.168.3.10  api.command.local
```


Unit tests
=================

Ga naar ./src/App/Test en run:

```
phpunit --testdox
```
