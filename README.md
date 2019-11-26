# SlamQuiz

[![Build Status](https://travis-ci.org/LaurentBouquet/slamquiz.svg?branch=master)](https://travis-ci.org/LaurentBouquet/slamquiz.svg?branch=master)

## Description
SlamQuiz is an online quiz software, a PHP web application developed using the Symfony framework (version 4).

Thanks to [Symfony](https://symfony.com/)

## Screenshot 
![Home page](https://raw.githubusercontent.com/LaurentBouquet/slamquiz/assets/screenshot_home.png?raw=true)

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

Uncomment and update the password in this line of **.env** file :
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

Uncomment and update the password in this line of **.env** file :
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
php bin/console server:start
```

### 4) With your web browser open url where server is listening on

For example, with your browser open this page :  http://127.0.0.1:8000 and GO !

![Workout page](https://raw.githubusercontent.com/LaurentBouquet/slamquiz/assets/home_page.png?raw=true)

Here is initial credentials of the student user.
 - Username : user
 - Password : user

Here is initial credentials of the teacher user.
 - Username : teacher
 - Password : teacher

Here is initial credentials of the admin user.
 - Username : admin
 - Password : admin

Here is initial credentials of the super-admin user.
 - Username : superadmin
 - Password : superadmin


## Contributing

SlamQuiz is an open source project that welcomes pull requests and issues from anyone.
Before opening pull requests, please read our short Contribution Guide.
