# Backend API NHTSA
Modus Create - Bak-end PHP API Exercise using Laravel

NHTSA API : [https://one.nhtsa.gov/webapi/Default.aspx?SafetyRatings/API/5](https://one.nhtsa.gov/webapi/Default.aspx?SafetyRatings/API/5)

## Requirements
* PHP     : ^7.1.3
* Laravel : 5.6.*

## Installation

```bash
git clone git@github.com:ansezz/backend-api-nhtsa.git
```

```bash
cd backend-api-nhtsa
# Install dependencies
composer install
```
#### Run tests
```bash
./vendor/bin/phpunit
```

#### Run development server
```bash
php artisan serv
```
Or use [Laravel Homestead](https://laravel.com/docs/5.6/homestead) is better

## Development System
Setup deploy System using [Capistrano](http://capistranorb.com)

### Requirements
- Server (Ubuntu /CentOs) with PHP, Nginx, Mysql (LEMP stack)
- Install Ruby
- Install Bundler `gem install bundler`
- Install capistrano and some dependencies :
```bash
cd backend-api-nhtsa/deploy/deploy
# Install dependencies
bundle install
```
Now you should be able to execute :
```bash
cap -T
```
### Update nginx vhosts
before this command, you need to change your server name and you IP server 
* IP here  : `deploy/deploy/config/deploy/dev.rb`
* Server name here : `deploy/ops/nginx/sites-available/nhtsa.laravel-vuejs.com`
```bash
cap dev nginx:vhosts  
```
### Restart nginx service
```bash
cap dev nginx:restart  
```
### Available command 
```bash
# Reload nginx service
cap dev nginx:reload  

# Restart php fpm service
cap dev php:restart  
```

#### Run Deploy
```bash
cap dev deploy
```

## Demo 
Example API URL : http://local.nhtsa.com

#### Requirement 1
```bash
GET http://local.nhtsa.com/vehicles/<MODEL YEAR>/<MANUFACTURER>/<MODEL>/
```
Example : http://local.nhtsa.com/vehicles/2015/Audi/A3

#### Requirement 2
```bash
POST http://local.nhtsa.com/vehicles
```
Which, when called with an application/JSON body as follows:
```bash
{
 "modelYear": 2015,
 "manufacturer": "Audi",
 "model": "A3"
}
```

#### Requirement 3
```bash
GET http://local.nhtsa.com/vehicles/<MODEL YEAR>/<MANUFACTURER>/<MODEL>?withRating=true
```
Example : http://local.nhtsa.com/vehicles/2015/Audi/A3?withRating=true

### API Doc 
generate api json documentation using [Swagger](http://zircote.com/swagger-php/)
```bash
./vendor/bin/openapi ./app -o ./public/penapi.json  --format json
```
You can see api DOC in [PetStore.swagger.io](http://petstore.swagger.io/),

Use Generated json : http://local.nhtsa.com/penapi.json.

#### References : 
* [DigitalOcean cloud server](https://m.do.co/c/bb2d64a88148).
* [How To Install Linux, Nginx, MySQL, PHP (LEMP stack) in Ubuntu 16.04](https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-in-ubuntu-16-04/)
* [ How To Use Capistrano to Automate Deployments: Getting Started ](https://www.digitalocean.com/community/tutorials/how-to-use-capistrano-to-automate-deployments-getting-started)
* [ Deploying a Rails App on Ubuntu 14.04 with Capistrano, Nginx, and Puma](https://www.digitalocean.com/community/tutorials/deploying-a-rails-app-on-ubuntu-14-04-with-capistrano-nginx-and-puma)
* [NHTSA API ](https://one.nhtsa.gov/webapi/Default.aspx?SafetyRatings/API/5)


Thank you for your time, if you have any question let me know.

Made by :heart:
