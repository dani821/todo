### Requirments
* Docker (latest version)
### How to run the solution?
First you have to clone the repository to your local machine.
```
git clone git@github.com:dani821/todo.git
```
Copy ```.env.example``` file and paste it as ```.env```
### Docker
```
docker compose up -d
```
If face error that default ports are already being used you can modify the port using these two env variables
```
APP_PORT (Web server port)
FORWARD_DB_PORT (MYSQL port)
```
### Install Composer
```
docker compose exec laravel.test composer install
```
### Run Laravel Sail
```
sail up -d
```

### Run database migrations
```
sail php artisan migrate
```

### Run PHP Unit
```
sail php artisan test
```

Visit [http://localhost](http://localhost) for default ```8080``` port but if you are using custom port then [http://localhost:{port}](http://localhost)
