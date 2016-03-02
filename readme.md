## Razvoj web bazirane aplikacije za sms prijavu ispita

###Instructions for full setup:

**Notice**: Install composer and git tools

Clone this project to your path.
```sh
git clone https://github.com/nstojanovickg/diplomski.git
```

**Notice**: *storage* dir and **.env** file are not in git, so you need to create them manualy.
*.env* contains nessesary constants with sensitive data.
*storage* and *bootstrap/cache* directories should be writable by your web server.

Via composer update (will install if they are not installed) necessary packages.
```sh
composer update
```

Autoload full classmap files.
```sh
composer dump-autoload --optimize
```

Set up database. You can find database dump file in *database* dir, named *sms_application_dump.sql*.

Run propel command to generate models.
```sh
php artisan propel:model:build
```

In *config/auth.php* change driver to propel.

Autoload full classmap files again to add models.
```sh
composer dump-autoload --optimize
```

Clear application cache.
```sh
php artisan cache:clear
```

That's it, you should be ready.