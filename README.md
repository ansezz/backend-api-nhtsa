# Backend API NHTSA
Modus Create - Bak-end PHP API Exercise using Laravel

## Requirements
* PHP     : ^7.1.3
* Laravel : 5.6.*

## Installation

```bash
git clone git@github.com:ansezz/backend-api-nhtsa.git
```

```bash
cd backend-api-nhtsa
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

## Deploy System
Setup deploy System using [Capistrano](http://capistranorb.com)

### Requirements

- Install Ruby
- Install Bundler `gem install bundler`
- Install capistrano and some dependencies :
```
bundle install
```
Now you should be able to execute :
```
cap -T
```
### Update nginx vhosts
```bash
cap dev nginx:vhosts  
```
#### Run Deploy
```bash
cap dev deploy
```

## Demo 
You can try API in this URL : http://nhtsa.laravel-vuejs.com

####Requirement 1
```bash
GET http://nhtsa.laravel-vuejs.com/vehicles/<MODEL YEAR>/<MANUFACTURER>/<MODEL>/
```
Example : http://nhtsa.laravel-vuejs.com/vehicles/2015/Audi/A3
####Requirement 2
```bash
POST http://nhtsa.laravel-vuejs.com/vehicles
```
Which, when called with an application/JSON body as follows:
```bash
{
 "modelYear": 2015,
 "manufacturer": "Audi",
 "model": "A3"
}
```

####Requirement 3
```bash
GET http://nhtsa.laravel-vuejs.com/vehicles/<MODEL YEAR>/<MANUFACTURER>/<MODEL>?withRating=true
```
Example : http://nhtsa.laravel-vuejs.com/vehicles/2015/Audi/A3?withRating=true

### API Doc 
generate api json documentation using [Swagger](http://zircote.com/swagger-php/)
```bash
./vendor/bin/openapi ./app -o ./public/penapi.json  --format json
```
#### References : 
* [DigitalOcean](https://m.do.co/c/bb2d64a88148) : get cloud server.
* [How To Install Linux, Nginx, MySQL, PHP (LEMP stack) in Ubuntu 16.04](https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-in-ubuntu-16-04/)
* [ How To Use Capistrano to Automate Deployments: Getting Started ](https://www.digitalocean.com/community/tutorials/how-to-use-capistrano-to-automate-deployments-getting-started)
* [ Deploying a Rails App on Ubuntu 14.04 with Capistrano, Nginx, and Puma](https://www.digitalocean.com/community/tutorials/deploying-a-rails-app-on-ubuntu-14-04-with-capistrano-nginx-and-puma)
