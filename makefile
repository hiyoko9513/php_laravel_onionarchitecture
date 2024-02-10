# oapi
docker/oapi/%/gen:
	docker run --rm -v $(PWD)/docs/oas/$*:/spec redocly/cli:latest bundle root.yml -o root.gen.yml
docker/oapi/%/mock:
	make docker/oapi/$*/gen &&\
	docker run --rm -it -p 4011:4010 -v $(PWD)/docs/oas/$*:/spec stoplight/prism:4 mock -h 0.0.0.0 /spec/root.gen.yml
docker/oapi/%/validate: # バージョン管理していないので将来バグが出そう
	make docker/oapi/$*/gen &&\
	docker run --rm -v $(PWD)/docs/oas/$*:/spec openapitools/openapi-generator-cli validate -i /spec/root.gen.yml
docker/oapi/%/ui:
	make docker/oapi/$*/gen &&\
	docker run -p 8081:8080 -v $(PWD)/docs/oas/$*:/usr/share/nginx/html/$* -e API_URL=$*/root.gen.yml swaggerapi/swagger-ui
docker/oapi/%/php/codegen:
	make docker/oapi/$*/gen &&\
	docker run --rm -v $(PWD):/spec openapitools/openapi-generator-cli generate -i /spec/docs/oas/$*/root.gen.yml -g php-laravel -o /spec/$* -c /spec/docs/oas/$*/php-gen-config.json

# git
git/commit-template:
	cp ./.github/.gitmessage.txt.example ./.github/.gitmessage.txt &&\
    git config commit.template ./.github/.gitmessage.txt &&\
    git config --add commit.cleanup strip
