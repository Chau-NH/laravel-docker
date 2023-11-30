# Swagger + Passport

## Set up Swagger

### Install L5-Swagger library
```sh
composer require "darkaonline/l5-swagger"
```

### Publish Swagger’s configuration
```sh
php artisan vendor:publish --provider  "L5Swagger\L5SwaggerServiceProvider"
```

### Modify server name for Swagger
```
L5_SWAGGER_CONST_HOST="${APP_URL}"
```

### Write code to generate API document
Create a Controller inside `Http\Controller` folder and write code to generate API document as below

```php
/**
 * @OA\Get(
 *  path="/api/profile",
 *  summary="Get User Profile Details",
 *  description="Get Authorized User Details",
 *  operationId="authorizedUserDetails",
 *  tags={"Profile"},
 *  security={ {"bearer_token": {} }}, // Authentication
 *  @OA\Response(
 *      response=200,
 *      description="Successfully",
 *      @OA\JsonContent()
 *  ),
 *  @OA\Response(response=400, description="Bad request"),
 *  @OA\Response(response=403, description="Unauthenticated"),
 *  @OA\Response(response=404, description="Resource Not Found")
 * )
 */
```

### Generate Swagger
Go to `Http\Controllers\Controller.php` add below code
```php
/**
 * @OA\Info(
 *  title="My Application API",
 *  version="1.0.0"
 * )
 * 
 * @OA\Server(
 *  url=L5_SWAGGER_CONST_HOST,
 *  description="Demo API Server"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
```

Then run command
```sh
php artisan l5-swagger:generate
```

### Visit Documentation
```
http://<your url>/api/documentation
```

### Enable authentication for API documentation (Bearer <token>)
Go to `config\l5-swagger.php` add below code under `securitySchemes` secction
```php
'securitySchemes' => [
    'bearer_token' => [
        'type' => 'http',
        'scheme' => 'bearer',
        'description' => 'Enter token here'
    ]
]
```
OR add `@OA\SecurityScheme` to main Controller `Http\Controllers\Controller.php`
```php
/**
 * @OA\SecurityScheme(
 *  securityScheme="bearer_token",   // you can name it whatever you want, but not forget to use the same in your request
 *  type="http",
 *  scheme="bearer",
 *  description="Enter token here"
 * )
 */
```
Then add this row to API documentation
```php
/**
 * @OA\Get(
 *  path="/api/profile",
 *  summary="Get User Profile Details",
 *  description="Get Authorized User Details",
 *  operationId="authorizedUserDetails",
 *  tags={"Profile"},
 *  security={ {"bearer_token": {} }}, // This row
```

## Set up Laravel Passport 

### Installation
Install library
```sh
composer require laravel/passport
```

Run database migration for passport
```sh
php artisan migrate
```

Execute below command to generate "personal access" and "password grant" clients in `oauth_client` table
```sh
php artisan passport:install

# Result after executing
Encryption keys generated successfully.
Personal access client created successfully.
Client ID: 1
Client secret: y2eo0bfQvvY74qYQKfxuZt7HoUxmNEsesQ2ZO8QX
Password grant client created successfully.
Client ID: 2
Client secret: Rd8iYDvLdEKLh6QiM5aqcWsnFPkHYhoWz4OwgFxx
```

### Update User Model
Replace `Sanctum\HasApiTokens` to `Passport\HasApiTokens`

```php
// app\Models\User.php

// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    ...
}
```
### Update Service Provide
```php
// app\Providers\AuthServiceProvider.php
class AuthServiceProvider extends ServiceProvider
{
    ...
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies(); // Add this row
    }
}
```

### Set driver
```php
// config\auth.php
return [
    ...
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'passport', // set this to passport
            'provider' => 'users',
            'hash' => false,
        ],
    ],
    ...
];
```

### Apply passport to API routes
```php 
// routes\api.php
Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [ProfileController::class, 'get']);
    ...
});
```

### Usage
Get `access token` and `refresh token` by using credentials
```sh
curl --location 'http://localhost:8080/oauth/token' \
--form 'grant_type="password"' \
--form 'client_id="2"' \
--form 'client_secret="Rd8iYDvLdEKLh6QiM5aqcWsnFPkHYhoWz4OwgFxx"' \
--form 'username="hoangchau@mail.com"' \
--form 'password="admin123456"' \
--form 'scope=""'
```

Get new access token by refresh token
```sh
curl --location 'http://localhost:8080/oauth/token' \
--form 'grant_type="refresh_token"' \
--form 'refresh_token="<refresh token get from above CURL>"' \
--form 'client_id="2"' \
--form 'client_secret="Rd8iYDvLdEKLh6QiM5aqcWsnFPkHYhoWz4OwgFxx"' \
--form 'scope=""'
```

Pass access token to header
```sh
curl -X 'GET' \
  'http://localhost:8080/api/profile' \
  -H 'accept: application/json' \
  -H 'Authorization: Bearer <access token>' \
  -H 'X-CSRF-TOKEN: '
```
