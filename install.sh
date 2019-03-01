read -n1 -r -p "Edit .env - set database parameters... (Press any button when you're done)
" key
./composer.phar install
echo "Loading fixures - for example first, administrative user"
php bin/console doctrine:fixtures:load