# 開発手順
## oapiベース
- 手順
    - oapi記入
    - code generate
    - qpi実装
- メリットとデメリット(簡易)
    - oapiのフォーマットを覚えるコスト増
    - 対応していない機能がある
    - modelがあまり保証されていなさそう()


## laravelベース
- 手順
    - api実装
    - oapi generate
- メリットとデメリット(簡易)
    - apiの実装が終わらないとフロントの開発が進まない
    - documentが充実しておらず、コードから読むしかない

## oapiベース手順
一応残しておく
### When updating oas
```shell
$ make docker/oapi/php/codegen
```
