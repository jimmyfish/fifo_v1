Licensed MIT to Komaltechno Inc.

COMPOSER
---
```bash
composer install
```

SETTING UP DATABASE
---
edit config file first in ``` app/config.php ``` 
create ``` cli-config.php ``` from ``` cli-config.php.dist ```
after that do this command

```bash
php vendor/bin/doctrine orm:schema-tool:update
```

```bash
php vendor/bin/doctrine orm:generate:proxies
```

PHP 7.0
---

```bash
sudo apt-get install php-xml php7.0-mbstring libapache2-mod-php7.0
```

Running Server
---

```bash
php -S localhost:[port] -t public/
```

Don't Forget to change name config.php.dist to config.php
 ---
