# GIS Project for Finding Disaster Prone Areas
Geographic Information System for finding disaster prone areas. It was created using [Laravel](https://laravel.com), [Oprenstreetmamp API](https://openstreetmap.org), and [Leaflet JS](https://leafletjs.com). 

## Demo
[http://gis-disaster-area.herokuapp.com](http://gis-disaster-area.herokuapp.com)

## Installation
Clone this repo to your computer:
```sh
git clone https://github.com/genstail24/GIS-Project.git
```
Change current directory to this project directory:
```sh
cd gis-project
```
Install dependencies and devDependencies:
```sh
composer install
npm install
npm run dev
```
Setup .env:
```sh
cp .env.example .env
php artisan key:generate
Set Database(MySQL) name, username, and password
```
Migrate and seed database:
```sh
php artisan migrate:fresh --seed
```
Run the server:
```sh
php artisan serve
```
Finish:
```sh
Now everything is ready to go!
```

## Default credentials and roles
| Email | Password | Role |
| ------ | ------ | ----- |
| admin@gmail.com | password | admin |
| user@gmail.com | password | user |