# Laravel PHP Framework Local setup for XAMPP Windows

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Download XAMPPP for windows:

https://sourceforge.net/directory/os:windows/?q=xampp%20control%20panel%20v3.2.1
https://www.apachefriends.org/download.html

## Download source code
1. clone the source code and put it on C:/xampp/htdocs/Iknowwelding/
2. It should be on iknowwelding folder

## Local setup Virtual Host

1. Go to C:\xampp\apache\conf\extra 
2. Update httpd-vhosts.conf file
3. Append the following line of codes

```
<VirtualHost *:80> 
    ServerName Iknowwelding.local 
     DocumentRoot "C:/xampp/htdocs/Iknowwelding/public" 
    SetEnv APPLICATION_ENV "development"
    <Directory "C:/xampp/htdocs/Iknowwelding/public">
        DirectoryIndex index.php
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>
</VirtualHost>
```

4. In C:\Windows\System32\drivers\etc 
5. Update hosts file
6. Append the following:
```
127.0.0.1 Iknowwelding.local
```
7. Restart the apache


## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
