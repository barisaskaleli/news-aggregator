# Installation

```
cp .env.example .env
```

```
docker-compose up -d --build
```

And then get in the fpm container and run these commands
```
docker exec -it News-Serve sh
```
```
composer install
```
```
php artisan migrate --seed
```
To fetch news from sources you can use this command (--list will show you available sources)
If no provider given it will fetch all sources
```
php artisan app:fetch-news {--source=} {--list}
```

After installation done you can reach from http://localhost:8000 here or you can use postman collection

[POSTMAN COLLECTION](https://github.com/barisaskaleli/news-aggregator/blob/main/News_Aggregator.postman_collection)
