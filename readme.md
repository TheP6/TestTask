## Instalation

- **Requirements**: PHP 7, MySQL 5.5, composer
- Clone project to directory;
- Run command to upload all dependencies 
```
    composer install
```
- Rename .env_example file to .env
- Create empty database
- Open .env file and change database connection options to your local settings;
- Run following commands to set up database;
```
    php artisan migrate
    php artisan db:seed
```
- Run following command to run the project in built-in server:
```
   php artisan serve
```
- After that on localhost:8000 project will be running;

## POSTMAN collection

- There is postman collection and postman enviroment in project for demonstation of project functionality.
 
## Notes
- I didn't write automated tests;
- Project is done using Laravel framework;
- Main code is in **domain** directory;
- I tried to make business logic indepdent of third-party libraries and frameworks as much as possible
