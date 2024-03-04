# Laravel rest api onion-architecture
## Dir structure
固有もの
```text
.
├── app
│   ├── Application // アプリケーション層
│   │   └── Services
│   │       └── Auth
│   ├── Domain // ドメイン層
│   │   ├── Models
│   │   │   └── Auth
│   │   └── Repositories
│   │       └── UserRepository.php
│   ├── Http // UI層
│   │   └── Requests // リクエストモデル
│   │       └── Auth
│   ├── Infrastructures // インフラ層(永続化)
│   │   └── Repositories
│   │       └── Auth
│   └── Util // 言語特有のユーティリティ
└── docs //apiや自動生成docsを配置
```

## First time only
```shell
# コミットルール用
$ make git/commit-template

# laravel用(環境依存有)
$ composer install
$ cp .env.docker.example .env
$ php artisan key:generate
$ php artisan jwt:secret
$ php artisan storage:link
$ sudo chmod -R 775 bootstrap/cache && sudo chmod -R 775 storage
$ sudo chown -R www-data:admin storage && sudo chown -R www-data:admin bootstrap/cache
$ php artisan migrate:fresh
$ php artisan db:seed --force
```

## When committing
```shell
$ ./vendor/bin/pint
```

## As necessary
```shell
# when code updated
## Model
$ php artisan ide-helper:models --write --reset
## Facade
$ php artisan ide-helper:generate
## Metafile
$ php artisan ide-helper:meta

## clear cache()
$ php artisan optimize:clear
$ composer dump-autoload
```

## Documents
- [Git Commit Rule](./docs/markdown/git-commit.md)
- [jwtの導入覚書](./docs/markdown/jwt-install.md)
- [open api選定](./docs/markdown/about-open-api.md)
- [phpstorm helper](./docs/markdown/phpstorm-helper.md)
- [status code](./docs/markdown/statuscode.md)
- [rest](./docs/markdown/rest.md)
- [release drafter](./docs/markdown/release-drafter.md)
- [api infra memo](./docs/markdown/infra-memo.md)
- [laravel(MailMessage)](./docs/markdown/laravel/mail-message.md)

## やっていること
- timestampの削除(2038年問題)
- emoji prefix
- oasのテンプレート配置
- api化
- jwtのインストール
- アクセスログの追加(request id毎)
- phpstorm helper library(補完用)
- pintの導入
- 日付フォーマット(API規格)
- 不適切なロジックの例外スロー(laravel機能)
- 多言語用のファイルを配置(一部：要カスタマイズ)
- config設定(必要なもののみ)
- プルリクによってリリースノートを作成し、自動バージョニングを行う
- api用の例外処理(詳細な例外は返さず汎用的な例外のみを返している。)
- cache etagを使用

## メモ
- strtotimeの使用しない(2038年問題)
- date関数の使用しない(2038年問題)
- mysqlでtimestampの使用しない(2038年問題)
- addMonthの月末使用しない
- 日付フォーマットは規格以外のものを返す(フロントで適宜フォーマットすること)
- 一般公開APIの場合、jsonの命名をsnake_caseに変更する(難しい話)
- paging情報はheaderに格納する
- トークンのリフレッシュタイミングは「75% of token lifetime」
- 環境変数「TRUSTED_PROXIES」：ロードバランサー用

## 考慮
- user status(login etc...)
- seeder factories()
- request headers(accept, referer, X-XSRF-TOKEN)
- envoy(product deploy)
- Enforce preflight
- sanctum
- docs generator(https://scramble.dedoc.co, ER)
- unit test(+ about tests mock=>mockery https://www.youtube.com/watch?v=ZSjc2tqUmmI)
- git actions(test...)

## やりたいこと
- コマンドのテンプレート作成
- スケージュールのテンプレート作成
- ソケットサーバーのテンプレート作成
- ブロードキャストのテンプレート作成
- SSO
- 2FA
- user role
