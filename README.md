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
