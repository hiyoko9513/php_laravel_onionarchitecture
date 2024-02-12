#!/bin/zsh
TMP_DIR='./tmp'
OPEN_API_DIR='../../app/OpenAPI'
MODEL_DIR='/Model'

docker run --rm -v $(PWD):/spec openapitools/openapi-generator-cli generate -i /spec/root.gen.yml -g php -o /spec/${TMP_DIR} -c /spec/gen-php-config.json
rm -rf ${OPEN_API_DIR}
mkdir -p ${OPEN_API_DIR}${MODEL_DIR}

# 不要ファイルの削除
rm -rf ${TMP_DIR}/lib/Api
rm -rf ${TMP_DIR}/lib/ApiException.php

cp -r ${TMP_DIR}/lib/* ${OPEN_API_DIR}

rm -rf ${TMP_DIR}
