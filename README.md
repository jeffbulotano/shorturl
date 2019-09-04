# Shorturl

Shorturl is a small web application built with Lumen and VueJS. 

## Installation
Clone the repo and enter the directory: 

```
git clone git@github.com:jeffbulotano/shorturl.git shorturl

cd shorturl
```

Install packages:

```
composer install
```
or if you don't need dev dependencies:
```
composer install --no-dev
```

Copy sample environment file:
```
cp .env.example .env
```

Modify .env file with your preferred text editor:
```
APP_NAME=Lumen # Modify this with what you want to name your app
APP_ENV=local # Change to production when your app is launched
APP_KEY= # 32 character random string
APP_DEBUG=true # false is recommended for production
APP_URL=http://localhost # Set to the URL that you will be running the app on
APP_TIMEZONE=UTC

LOG_CHANNEL=stack
LOG_SLACK_WEBHOOK_URL=

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret

CACHE_DRIVER=file
QUEUE_CONNECTION=sync

HASH_ID_SALT=testsalt # String that is used to create the hash for short links
HASH_ID_PADDING=5 # Minimum length of hash for short links
```

*NOTE It is important that you change APP_URL, DB_DATABASE, DB_USERNAME, DB_PASSWORD for the application to work.

Run migration:
```
php artisan migrate
```

Your app is now ready!

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## TODO
Improvements on URL validation.