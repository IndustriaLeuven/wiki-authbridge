#!/bin/bash
set -e # Quit the script on error
composer install --no-dev --no-plugins --no-scripts --optimize-autoloader
npm install
php app/console cache:clear --env=prod
php app/console assets:install --env=prod
php app/console assetic:dump --env=prod
php app/console braincrafted:bootstrap:install --env=prod
php app/console doctrine:migrations:migrate --env=prod
