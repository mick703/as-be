
## About the repo
This is a standard Laravel 8 project created by the artisan cli. It was built with a local Mysql database.

## APIs

Routes are defined in the api.php to meet the requirements
- Add a new property. 
- Add/Update an analytic to a property.
- Get all analytics for an inputted property.
- Get a summary of all property analytics for an inputted suburb (min value, max value, median value, percentage properties with a value, percentage properties without a value)
- Get a summary of all property analytics for an inputted state (min value, max value, median value, percentage properties with a value, percentage properties without a value)
- Get a summary of all property analytics for an inputted country (min value, max value, median value, percentage properties with a value, percentage properties without a value)
 
The API response is in JSON format for all endpoints. For list responses eg, all properties, analytics for given
property, the result is paginated with 15 items per page. 


```php
$CURRENT_VERSION = '2020-11';

Route::get("/$CURRENT_VERSION/properties", [PropertyController::class, 'index']);
Route::post("/$CURRENT_VERSION/properties", [PropertyController::class, 'store']);
Route::get("/$CURRENT_VERSION/properties/{property}", [PropertyController::class, 'show']);
Route::get("/$CURRENT_VERSION/properties/{property_id}/analytics", [PropertyAnalyticController::class, 'showByProperty']);
Route::post("/$CURRENT_VERSION/properties/{property_id}/analytics", [PropertyAnalyticController::class, 'store']);
Route::put("/$CURRENT_VERSION/properties/{property_id}/analytics/{id}", [PropertyAnalyticController::class, 'update']);

Route::get("/$CURRENT_VERSION/analytics/summary", [PropertyAnalyticController::class, 'summary']);
```

## Set up

- Set up database in the database.php file 
- Run database migrations and seed the database
```php
 php artisan migrate:fresh --seed
```
- Run with the local php server
```php
php artisan serve
```
This should get the app running. 

## Known limitations/todos
- Need to add tests with a test database. 
