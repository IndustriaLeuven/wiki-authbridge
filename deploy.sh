#!/bin/bash
set -e # Quit the script on error
composer install --no-dev --no-plugins --no-scripts --optimize-autoloader
npm install
php app/console cache:clear --env=prod
php app/console assets:install --env=prod
php app/console assetic:dump --env=prod
php app/console braincrafted:bootstrap:install --env=prod
php app/console doctrine:migrations:migrate --env=prod

# Notify rollbar of deploy
ACCESS_TOKEN=$(sed /rollbar/\!d < app/config/parameters.yml | cut -d: -f2 | tr -d " \r\n")
ENVIRONMENT=production
LOCAL_USERNAME=`whoami`
REVISION=`git log -n 1 --pretty=format:"%H"`

curl https://api.rollbar.com/api/1/deploy/ \
  -F access_token=$ACCESS_TOKEN \
  -F environment=$ENVIRONMENT \
  -F revision=$REVISION \
  -F local_username=$LOCAL_USERNAME
