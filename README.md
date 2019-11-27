# SlamQuiz

[![Build Status](https://travis-ci.org/LaurentBouquet/slamquiz.svg?branch=master)](https://travis-ci.org/LaurentBouquet/slamquiz.svg?branch=master) 
[![HitCount](http://hits.dwyl.io/LaurentBouquet/slamquiz.svg)](http://hits.dwyl.io/LaurentBouquet/slamquiz) 
[![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](https://github.com/LaurentBouquet/slamquiz/issues)

[![Deploy on Heroku](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy)

## Description
SlamQuiz is an online quiz software, a PHP web application developed using the Symfony framework (version 4).

Thanks to [Symfony](https://symfony.com/)

## Installation

### 1) Get all source files

```bash
git clone https://github.com/LaurentBouquet/slamquiz.git
cd slamquiz
composer install
```

### 2) Create database

In the commands below, replace **aSecurePassword** with a secure password.

Here are the steps to create the database, either with MySQL or with PostreSQL.


#### Either with MySQL

Enter this commands in a terminal prompt :
```sql
sudo mysql
CREATE USER 'slamquiz'@'localhost' IDENTIFIED BY 'aSecurePassword';
CREATE DATABASE slamquiz CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON slamquiz.* TO 'slamquiz'@'localhost';
```

Update config/packages/doctrine.yaml :
```yaml
doctrine:
    dbal:
        # configure these for your MySQL database server
        driver: 'pdo_mysql'
        server_version: '5.7'
        charset: utf8mb4
        default_table_options:
            charset: utf8mb4
            collate: utf8mb4_unicode_ci

        # configure these for your PostgreSQL database server
        # driver: 'pdo_pgsql'
        # charset: utf8
```

Copy **.env** file to **.env.local**.

Uncomment and update the password in this line of **.env.local** file :
DATABASE_URL=mysql://slamquiz:**aSecurePassword**@127.0.0.1:3306/slamquiz


Enter this commands in a terminal prompt :
```bash
# cd slamquiz
bin/console doctrine:migrations:latest
```
If an error occured "could not find driver", enter this command in a terminal prompt (and re-enter the command above) :
```bash
sudo apt install php-mysql
```


#### Or with PostgreSQL

Enter this commands in a terminal prompt :
```bash
sudo -i -u postgres
createuser --interactive
slamquiz
# -> yes
psql
ALTER USER slamquiz WITH password 'aSecurePassword';
ALTER USER slamquiz SET search_path = public;
\q
exit
```

Update config/packages/doctrine.yaml :
```yaml
doctrine:
    dbal:
        # configure these for your MySQL database server
        # driver: 'pdo_mysql'
        # server_version: '5.7'
        # charset: utf8mb4
        # default_table_options:
        #     charset: utf8mb4
        #     collate: utf8mb4_unicode_ci

        # configure these for your PostgreSQL database server
        driver: 'pdo_pgsql'
        charset: utf8
```

Copy **.env** file to **.env.local**.

Uncomment and update the password in this line of **.env.local** file :
DATABASE_URL=pgsql://slamquiz:**aSecurePassword**@127.0.0.1:5432/slamquiz


Enter this commands in a terminal prompt :
```bash
# cd slamquiz
php bin/console doctrine:database:create
```
If an error occured "could not find driver", enter this command in a terminal prompt (and re-enter the command above) :
```bash
sudo apt install php-pgsql
```


### 3) Fill database and start built-in server

Enter this commands in a terminal prompt :
```bash
# cd slamquiz
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
php bin/console server:run
```

### 4) With your web browser open url where server is listening on

For example, with your browser open this page :  http://127.0.0.1:8000 and GO !

Here is initial credentials of the student user.
 - Email : user@domain.tld
 - Password : user

Here is initial credentials of the admin user.
 - Email : admin@domain.tld
 - Password : admin

Here is initial credentials of the super-admin user.
 - Email : superadmin@domain.tld
 - Password : superadmin


## Contributing

SlamQuiz is an open source project that welcomes pull requests and issues from anyone.
Before opening pull requests, please read our short Contribution Guide.
