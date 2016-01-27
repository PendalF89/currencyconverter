# CurrencyConverter WordPress Plugin

[Stable version on WordPress.org](https://wordpress.org/plugins/currencyconverter/)

## Before releasing wordpress.org version

1. Change versions in next files:

```
plugin/source/Service/ScriptStyles.php
plugin/source/Admin/Service/ScriptStyles.php

plugin/plugin.php
plugin/readme.txt

package.json
```

## Generate language files

Run this comand from [VVV](https://github.com/Varying-Vagrant-Vagrants/VVV) server to create `.po` file which can be used to create localized `.mo` files. This requires that `currencyconverter` folder mounted to `wordpress-default` site directory. 

```
php /srv/www/wordpress-develop/tools/i18n/makepot.php wp-plugin /srv/www/wordpress-default/wp-content/plugins/currencyconverter/ /srv/www/wordpress-default/wp-content/plugins/currencyconverter/languages/currencyconverter.pot
```
