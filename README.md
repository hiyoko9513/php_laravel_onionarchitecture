# laravel api onion-architecture
## First time only
```shell
# コミットルール用
$ make git/commit-template

# laravel用
$ composer install
$ php artisan key:generate
$ php artisan storage:link
$ sudo chmod -R 775 bootstrap/cache && sudo chmod -R 775 storage
$ sudo chown -R www-data:admin storage && sudo chown -R www-data:admin bootstrap/cache
```

## document
- [Git Commit Rule](./docs/markdown/git-commit.md)


## todo
1. API化
2. ユーザー登録機能
3. jwt
4. oapi
5. オニオン＋code-gen
