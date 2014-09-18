Portals
=======

Laravel driven content portal


## Intalation

Composer

    composer update 

Run Migration

    php artisan migrate --bench="sugarcrm/portals"

    php artisan asset:publish --bench="sugarcrm/portals"

    
Seed Demo Portal

    php artisan db:seed --class="PortalSeeder"
