# laravel api onion-architecture
## First time only
```shell
# コミットルール用
$ make git/commit-template

# laravel用(環境依存有)
$ composer install
$ cp .env.my-docker.example .env
$ php artisan key:generate
$ php artisan jwt:secret
$ php artisan storage:link
$ sudo chmod -R 775 bootstrap/cache && sudo chmod -R 775 storage
$ sudo chown -R www-data:admin storage && sudo chown -R www-data:admin bootstrap/cache
$ php artisan migrate
```

## document
- [Git Commit Rule](./docs/markdown/git-commit.md)
- [jwtの導入覚書](./docs/markdown/jwt-install.md)


## todo
3. オリジナルID
4. oapi
5. オニオン＋code-gen
