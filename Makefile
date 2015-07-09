all:
	@echo "Supported targets are: build-phar, release"

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

release:
	# Update version
	@echo "--> Updating version"
	sed -i '' -E "s/const VERSION = '[0-9\.]+';/const VERSION = '${TAG}';/" src/Console/Application.php
	git add src/Console/Application.php
	git commit -m "bump version to ${TAG}"
	git tag ${TAG}

	# Build Phar
	$(MAKE) build-phar

	# Add phar to gh-pages branch
	@echo "--> Adding phar to gh-pages branch"
	git checkout gh-pages
	cp kata.phar downloads/kata-${TAG}.phar
	git add downloads/kata-${TAG}.phar
	rm -Rfv downloads/kata-latest.phar
	cp downloads/kata-${TAG}.phar downloads/kata-latest.phar
	git add downloads/kata-latest.phar
	git commit -m "bump version to ${TAG}"

	# Clean up master
	@echo "--> Cleaning up master"
	git checkout master
	rm kata.phar
	composer install

	# Push to github
	@echo "Version ${TAG} tagged. Make sure you push to github:"
	@echo "git push origin master"
	@echo "git push origin gh-pages"
	@echo "git push --tags"
