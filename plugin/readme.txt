=== CurrencyConverter ===
Contributors: lb-company, korobochkin
Tags: currencies, currency, rates, exchange, converter, widgets, usd, dollar
Requires at least: 4.0.0
Tested up to: 4.4.0
Stable tag: 0.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

More than 170+ currency rates. The data about currency rates is free and updates each hour automatically.

== Description ==

More than 170+ currency rates. The data with currency rates is free and updates each hour automatically.

Features:

1. Few widgets for showing currency rates. Each widget have multiple settings for customizing.
2. You can choose data provider.
3. No additional load to your site. Currency rates updated in background and cached.
4. Useful API for creating your custom widgets or showing exchange rates anywhere on your website.

= Data providers =

We are collect data from multiple data providers and store them on our server [exchangerate.guru](http://exchangerate.guru). This plugin retrieve data only from exchangerate.guru for all data providers (one request per hour by WordPress Cron). Our public API don't require any keys or passwords. Right now we have data from two data providers such as:

1. Open Exchange Rates (170+ currencies).
2. Central Bank of Russia (30+ currencies).

You can [suggest additional functionality or widget](https://github.com/korobochkin/currency/issues) for this plugin by posting your idea on Github. We will try to add functionality in future versions.

= On Russian (по-русски) =

Актуальные курсы более 170+ валют в виджетах для любых сайтов. Данные о ценах (ставках) валют бесплатны и обновляются каждый час.

Возможности плагина:

1. Несколько виджетов для показа курсов валют с большим количеством настроек.
2. Можно выбрать поставщика данных.
3. Нет дополнительной нагрузки на ваш сайт. Все данные обновляются в фоне и кэшируются (сохраняются).
4. Удобное API для вывода курса валют в любом месте сайта.

= Поставщики данных =

Мы собираем данные с нескольких поставщиков данных и храним их на нашем сайте [exchangerate.guru](http://exchangerate.guru). Плагин запрашивает данные лишь с сайта exchangerate.guru для всех поставщиков данных (один запрос в час с помощью WordPress Cron). Наше API публично и не требует каких-либо ключей или паролей. Сейчас у нас есть данные от двух поставщиков:

1. Open Exchange Rates (170+ валют).
2. Центральный банк Российской Федерации (30+ валют).

Вы можете [заказать создание дополнительного виджета или функционала](https://github.com/korobochkin/currency/issues) для плагина, написав об этом на Github. Мы постараемся добавить функционал в будущих версиях.

== Installation ==

= From your WordPress dashboard =

1. Visit 'Plugins > Add New'
2. Search for 'currencyconverter'
3. Activate CurrencyConverter from your Plugins page.
4. Add widgets on yourdomain.com/wp-admin/widgets.php page.

= From WordPress.org =

1. Download CurrencyConverter.
2. Upload the 'currencyconverter' directory to your '/wp-content/plugins/' directory, using your favorite method (ftp, sftp, scp, etc...).
3. Activate CurrencyConverter from your Plugins page.
4. Add widgets on yourdomain.com/wp-admin/widgets.php page.

= On Russian (по-русски) =

= Из консоли WordPress =

1. Откройте 'Плагины > Добавить новый'
2. В поиске наберите 'currencyconverter'
3. Активируйте CurrencyConverter со страницы Плагины.
4. Добавляйте виджеты на странице moy-sait.ru/wp-admin/widgets.php.

= Через сайт WordPress.org =

1. Скачайте CurrencyConverter.
2. Распакуйте архив и загрузите папку 'currencyconverter' на ваш сервер в папку '/wp-content/plugins/', используя любую удобную программу (ftp, sftp, scp, и др...).
3. Активируйте CurrencyConverter со страницы Плагины.
4. Добавляйте виджеты на странице moy-sait.ru/wp-admin/widgets.php.

== Screenshots ==

1. У каждого виджета множество настроек.
2. Виджет с таблицей валют.
3. Цветной виджет, где можно выбрать цвет фона.

== Frequently Asked Questions ==

= Does my theme support this plugin? =

Yes! This plugin enqueue additional styles for widgets only if some widgets active. Theme developers can use `add_theme_support ('plugin-currency-converter')` for creating styles manually inside `style.css` file.

= What requests to remote server sends this plugin? =

The plugin makes only one request per hour and caches the result with currencies exchange rates. In requests we only send the data provider name as parameter and that's all.

= On Russian (по-русски) =

= Поддерживает ли моя тема этот плагин? =

Да! Плагин подключит необходимые стили для виджетов, если они используются. Если вы не используете ни один из виджетов, то плагин, не будет подключать какие-либо файлы. Разработчики могут использовать `add_theme_support ('plugin-currency-converter')`, чтобы самостоятельно создать необходимые стили для виджетов.

= Какие запросы делает плагин к внешним серверам? =

Плагин делает один запрос в час и затем кэширует курсы валют. В запросе к внешнему серверу мы передаем лишь название поставщика данных в качестве параметра и все.

== Changelog ==

= 0.1.0 =

* Custom update rates link for Central Bank of Russia.
* Enqueue script & styles the right way.
* Code improvements.

= 0.0.0 =

* First release.

== Upgrade Notice ==

= 0.1.0 =

Small fixes and better code inside.

= 0.0.0 =

First release.