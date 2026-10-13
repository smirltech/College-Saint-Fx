## Deploy the application to the server
deploy:
	ssh cenk 'cd ~/public_html/app.college-enk.com && git pull && make install'

deploy-refresh:
	ssh cenk 'cd ~/public_html/app.college-enk.com && git pull && make install && make refresh'


refresh:
	php artisan migrate:fresh --seed --step


install: .env vendor/autoload.php public/storage
	php artisan migrate --step
	php artisan cache:clear

.env:
	cp .env.example .env
	php artisan key:generate


vendor/autoload.php: composer.lock
	composer install
	touch vendor/autoload.php


public/storage:
	php artisan storage:link


