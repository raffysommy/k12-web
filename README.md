K12 - Web application
=======================

Introduction
------------
This is a web interface for k12 app services. 

Installation
------------

Using Composer (recommended)
----------------------------
Clone the repository and manually invoke `composer` using the shipped
`composer.phar`:

    cd my/project/dir
    git clone https://hub.jazz.net/git/sorus/k12-web
    cd K12-web
    php composer.phar self-update
    php composer.phar install

Web Server Setup
----------------
### Apache Setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName k12-web
        DocumentRoot /path/to/k12-web/public
        SetEnv APPLICATION_ENV "development"
        <Directory /path/to/k12-web/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>
