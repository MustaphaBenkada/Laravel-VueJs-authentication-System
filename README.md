# install instructions :

- $ composer install

- $ cp .env.example .env

- $ php artisan key:generate


# in .env set appropriate parameters to replace these:

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=delivery-ezy

DB_USERNAME=root

DB_PASSWORD=

clear cach 

# $ php artisan cache:clear
# $ php artisan route:clear
# $ php artisan config:clear

Optimization 

# $ php artisan optimize
# $ php artisan config:cache
# $ php artisan route:cache
# $ php artisan view:cache
# $ composer dumpautoload -o