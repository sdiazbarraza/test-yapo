# Api-Rest MVC Test

### Prerequisites

```
PHP 5.4>
MySQL 5.4>
Composer
```
### Requisites Functions API
*Content-Type Allowed : 
```
application/x-www-form-urlencoded
application/json
```
*Format json 
```
{"field":"value"..}
```
*Format form 
```
field=value&field=value
```
### Installing

Clone Repo in folder project
```
git clone git@github.com:simp06/test-yapo.git /folderProject
```
Install FastRoute
```
composer install
```
Create  Database 
```
mysql>CREATE DATABASE test_yapo;
```

Execute to Script Database that to save data user test
```
mysql>use test_yapo;
mysql> source \home\user\Desktop\bd_test_yapo.sql;
```
You should change the config connection to mysql, you should do in Database.php
```
path =test-yapo/framework/conf/Database.php
...
'host'=> youHost
'user'=> userName
'password'=> password
'dbname'=> database	
'port'=> port
'prefix'=> ""	
'charset'=> "UTF8"
....
```
Execute server 
```
php -S localhost:PORT routes.php
```

## Build 
I started by creating the project folder structure for proper use of the mvc pattern. Then install fastRoute, to streamline the theme of the routes with the drivers. Then begin with the development of the "Core" of the framework, in the first instance with the Views, then with Model that included the connection to the database, to continue with the development of the BaseController which includes the loading of views and models properly such. Once this is done, it starts with the development of the application, starting with the login module, once this is completed, continue with the development of the api, with the respective operations, ending with the login of credentials and respective validations.

## Built With
* [FastRoute][https://github.com/nikic/FastRoute] Fast request router for PHP
* [Simple MVC FrameWork][https://www.codeproject.com/Articles/1080626/Code-Your-Own-PHP-MVC-Framework-in-Hour]
