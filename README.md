## About

Under Progress

## Copyright & LICENSE

THIS APPLICATION IS CONFIDENTIAL AND PROPRIETARY AND DEVELOPED BY xtendum gmbh. THE SOURCE CODE MAY NOT BE REPRODUCED, PUBLISHED, OR DISCLOSED TO OTHERS WITHOUT WRITTEN AUTHORIZATION.
COPYRIGHT ©2017 BY xtendum gmbh, Switzerland. ALL RIGHTS RESERVED.

# License

License is granted to licensed party for indefinite time and in a non-restricting way which means licensed party can change, sub-license or sell the application including the source code without any further permission of the author (if not any other restriction of used frameworks and libraries apply).

# LIBRARIES AND FRAMEWORKS

-   Laravel (https://laravel.com): The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
-   VueJS
-   Various Packages and Frameworks: see file 'composer.json' and 'package.json' in the root folder.

## Contact

For any questions please contact

xtendum gmbh  
Christian Herter  
Egg 79  
CH-9103 Schwellbrunn  
Switzerland

Email contact@xtendum.com / www.xtendum.com

## Installation & Deployment

PROD setup is done in .env file
Important settings: APP*\*, DB*_, MAIL*MAILER=sendmail, VITE_COOKIES_SECURE, LOG*_, QUEUE_CONNECTION=database
See .env.example

## Checklist Updates PROD

For each update/install do the following :
IMPORTANT: Consider putting application in maintenance mode first (see above).

IMPORTANT: Make sure PHP version 8.1 is used, e.g. on Hostpoint Server as long as PHP default is not yet used, executed the following php command (or similar, depending on your web server configuration):
`/usr/local/php81/bin/php` instead of `php`

1. Pull from GIT  
   `git pull`

2. run composer
   `php composer.phar update --optimize-autoloader --no-dev`

3. run database migration  
   `php artisan migrate`

4. run `npm install` -- if npm not available on server, do locally

5. run `npm run build` -- if npm not available on server, do locally (make sure env file is set correctly)
   and publish files in public directory manually

6. rebuild caches
   `php artisan optimize`

7. Restart queues  
   `php artisan queue:restart`

Other informations:  
To clear caches use the following commands:

```
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

## Checklist Backend Installation & Updates DEV

1. Pull from GIT  
   `git pull`

2. run composer  
   `Composer install`
   or  
   `Composer install --ignore-platform-reqs` ==> If any platform requirements mismatch

3. run Sail build
   `sudo ./vendor/bin/sail build` ==> For the very first time to setup up docker

4. run Sail  
   `sudo ./vendor/bin/sail up`

5. Generate key
   `sudo ./vendor/bin/sail artisan key:generate`

6. run Migrations
   `sudo ./vendor/bin/sail artisan migrate`

7. run database seed  
   `sudo ./vendor/bin/sail artisan db:seed`

8. run `sudo ./vendor/bin/sail npm install` -- if npm not available on sail, do locally

9. run `sudo ./vendor/bin/sail npm run dev`

10. rebuild caches
    `sudo ./vendor/bin/sail artisan optimize`

or

`sudo ./vendor/bin/sail artisan config:cache`
`sudo ./vendor/bin/sail artisan route:cache`

Other informations:  
To clear caches (e.g. for local development) use the following commands:

```
sudo ./vendor/bin/sail artisan config:clear
sudo ./vendor/bin/sail artisan route:clear
sudo ./vendor/bin/sail artisan view:clear
sudo ./vendor/bin/sail artisan cache:clear
```

To setup a first user you can use tinker or the seed.

## Example for superadmin user setup with tinker - Available Roles: user, clientadmin, superadmin (otherwise regular client admin)

```
sudo ./vendor/bin/sail artisan tinker
$user = new User();
$user->firstname = 'Peter'
$user->lastname = 'Muster'
$user->email = 'p.muster@xtendum.com'
$user->password = bcrypt('12345678')
$user->role = 'superadmin' Or 'admin'
$user->save()
exit
```

## Checklist Frontend Installations & Updates

If NPM is not available on server (on hostpoint it isn't), run the following commands locally and afterwards copy all files in directory /public to the same directory on the server

IMPORTANT: If dist files are created locally make sure you have the same env file settings configured for the env variables starting with VITE\_ .

-> switch to application root directory and do the following commands:

1. `npm install` -- check on warnings and fix them (e.g. security vulnerabilities)
2. `npm run build` -- creates optimized smaller files, for debuging purpose do 'npm run dev'

## DEV - Requirements for local developments

1. Docker
   `curl -s https://laravel.build/example-app | bash` ==> Linux/Unix
   `curl -s https://laravel.build/example-app | bash` ==> windows
   `curl -s "https://laravel.build/example-app" | bash` ==> Macos

2. PHP
   `https://www.php.net/downloads`

3. Composer
   `https://getcomposer.org/Composer-Setup.exe` ==> For Windows
   `https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos` ==> For Linux/Unix/Macos

4. Node/NPM

## PROD - One-time settings for web server (tested on shared hosting of hostpoint.ch, might need adjustments on others) for a fresh install

# Cron jobs

setup cron job to handle scheduled jobs
Cron '\* \* \* \* \* php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1'

Example for PROD on hostpoint server
Cron job: '\* \* \* \* \* cd /home/chrigel/www/xtendum/projects/hilti/ordertool/prod && /usr/local/php81/bin/php artisan schedule:run >> /dev/null 2>&1'

### Checklist

1. `git clone git@bitbucket.org:xtendum-services/staff-companion.git dev`  
   (Note: public ssh/rsa key of server user needs to be set as access key in bitbucket.org for repository)
2. configure laravel .env file (see env.example)
3. install composer -- https://getcomposer.org/download/
4. `composer install` -- php composer.phar install (depending on environment you should run php composer.phar update)
5. `php artisan migrate`
6. `php artisan storage:link`
7. `php artisan key:generate`
8. `php artisan optimize`
9. `php artisan queue:work`
10. Check database index: e.g. add index to all foreign key

=> If database should contain some dummy data use:  
`php artisan db:seed`
