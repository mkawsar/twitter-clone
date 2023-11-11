## Twitter Clone

It's twitter clone project

### System requirements
* PHP 7.2 or higher (We have used PHP 7.4 for development)
* [Composer](https://getcomposer.org/Composer)
* [Node](https://nodejs.org/en/) (We have used Node 18.18.2 for development)
* [Npm](https://www.npmjs.com/) (We have used NPM 9.8.1 for development)
* [Git](https://git-scm.com/)

### Installation
* Clone the repository
* Checkout the `master` branch
* Make sure `PHP`, `Composer`, `Node` and `NPM` is installed in system
### Backend
* Go to the `backend` directory
* Run `composer install` to install the dependencies
* Make a copy for local environment and setup all configurations
    ```bash
  cp .env.example .env
  ```
* Need to modify environment for database
* Run the command line for migrate all table
  ```bash
  php artisan migrate
  ```
* Run the command line for storage directory make publicly
  ```bash
  php artisan storage:link
  ```
### Frontend
* Go to the `frontend` directory
* Run `npm install` to install the dependencies
* Need to modify environment for backend server url `frontend/src/env.js` and need to store only base path

### Project Structure
* Our solution have two parts
    * Backend
    * Frontend
* REST Api parts are include `Controllers`, `Models` and `Routes` directory

### Run the Solutions
* First of all run the backend server `php artisan serve`
* Finally run the frontend server `npm run build`/`npm run dev`

### Note
* I have attached postman collection in root directory

### Support

If you have any questions or confusion please email me at **kawsar.diu888@gmail.com** or open an issue in the repository.