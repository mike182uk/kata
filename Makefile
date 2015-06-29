all:
	@echo "Only the build-phar target is currently supported."
build-phar:
	@echo "--> Checking for Composer"
	command -v composer >/dev/null && continue || { echo "Composer not found."; exit 1; }
	@echo "--> Cleaning vendor directory"
	rm -Rfv vendor
	@echo "--> Installing composer dependencies (without dev)"
	composer install --no-dev
	@echo "--> Building phar"
	box build
	@echo "--> Success"
