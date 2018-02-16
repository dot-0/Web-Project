<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

**** OS: Windows 10***

## Requirements:

	Xampp with PHP version >= 7.0
	mongoDB version >= 3.4.0
	
	
## Configure the project in your machine:

-	install xampp in C drive.
	follow these instructions https://www.wikihow.com/Install-XAMPP-for-Windows

-	install mongoDB in C drive.
	follow these instructions https://docs.mongodb.com/manual/tutorial/install-mongodb-on-windows/

-	Install MongoDB driver for PHP.
	goto xampp/php directory (C:\xampp\php)
	open php.ini and add the line "extension=php_mongodb.dll" 

-	copy the "shurodhwani" folder in "xampp\htdocs\".

-	copy the "dump" folder to "C:\Program Files\MongoDB\Server\3.4\bin" folder. you may need administrator permission to do so.

-	open command prompt in administrator mode and run the following commands.
	cd C:\Program Files\MongoDB\Server\3.4\bin
	mongorestore --db shurodhwani dump\shurodhwani

-	Create virtual hosts
	->	open notepad in administrator mode go to C drive > xampp > apache > conf > extra and open "httpd-vhosts.conf" file
		now add the following
		
		<VirtualHost *:80>
			DocumentRoot "C:/xampp/htdocs"
			ServerName localhost
		</VirtualHost>

		<VirtualHost *:80>
			DocumentRoot "C:/xampp/htdocs/shurodhwani/public"
			ServerName shurodhwani.dev
		</VirtualHost>
		
	->	open notepad in administrator mode go to C drive > windows > system32 > drivers > etc and open "hosts" file 
		now add the following
		
		127.0.0.1       shurodhwani.dev
	
	===> Google Chrome does not support url with .dev extension. So, if you want to run this project in Chrome browser then
		replace "shurodhwani.dev" with "shurodhwani.test" or add another vhost named "shurodhwani.test". 

-	run Xampp and start Apache service.

-	go to C drive and run mongoDB by typing "mongod" command in command prompt.

-	Open a browser and run the app by typing shurodhwani.dev(shurodhwani.test for Chrome) in url.

