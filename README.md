# laravel api onion-architecture
## First time only
```shell
$ composer install
$ php artisan key:generate
$ php artisan storage:link
$ sudo chmod -R 775 bootstrap/cache && sudo chmod -R 775 storage
$ sudo chown -R www-data:admin storage && sudo chown -R www-data:admin bootstrap/cache
```

## document
- [Git Commit Rule](./docs/markdown/git-commit.md)
