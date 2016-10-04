# Laravel Oauth2 Server

Laravel Oauth2 Server is a web application Developed for Laravel REST Api test with oauth2.

## Installation
~~~
step 1. git clone https://github.com/tejrajs/laravelOauthServer.git
step 2. cd laravelOauthServer
step 3. composer update
~~~

### step 4. add .env file with help of .env.example and modified

~~~
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
~~~

~~~
step 5. php artisan migrate
step 6. php artisan db:seed --class=UsersTableSeeder
step 7. php artisan db:seed --class=ClientsTableSeeder
step 8. php artisan db:seed --class=OauthClientsTableSeeder
~~~

# Test in postman

## Without Oauth
~~~
http://localhost:8000/api/clients
http://localhost:8000/api/clients/1
~~~ 

## Generate Access token

~~~
username=admin@admin.com
password = password
grant_type = password
client_id = clients_id.sddd3ed8fdsfdfgsdfge
client_secret = secret.sdRxg#@&!Dgdfffg@#%$fsdf
~~~
 
### URL to get access token
~~~
http://localhost:8000/api/oauth/access_token
~~~
 
### Test URL With access token

~~~
api/clients/<id> DELETE
api/clients/<id> PUT
api/clients POST
~~~