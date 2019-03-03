read -n1 -r -p "Edit .env - set database parameters... (Press any button when you're done)
" key
composer install
yarn install
yarn encore dev
echo "Creating database structure"
bin/console doctrine:schema:update --force
echo "Loading fixures - for example first, administrative user"
php bin/console doctrine:fixtures:load
