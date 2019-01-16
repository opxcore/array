# Array utils

## Usage
### Make a dot notated array
```php
$dotNotated = Arr::dot($array);
```
Makes a dot notated array from multidimentional array.
#### Example:
```php
    $array = ['level1' => ['level2' => 'value']];
    $dotNotated = Arr::dot($array);
    // $dotNotated = ['level1.level2' => 'value']
```
### Geting a value using dot notation
```php
Arr::get($array, $key, $default = null)
```
Gets a value from an array using dot notation. If given key is not existing in array, function returns `null` (for default) or given default value (or result of closure).

_**Notice:** `Arr::get()` is optimised for performance on dot notated keys. If you are not using dot-notation it is better (for performance) to use regular array manipulations._
#### Examples:
```php
    $array = ['level1' => ['level2' => 'value']];
    $result = Arr::get($array, 'level1.level2');
    // $result = 'value'
```
```php
    $array = ['level1' => ['level2' => 'value']];
    $result = Arr::get($array, 'level1.level3');
    // $result = null
```
```php
    $array = ['level1' => ['level2' => 'value']];
    $result = Arr::get($array, 'level1.level3', false);
    // $result = false
```
```php
    $array = ['level1' => ['level2' => 'value']];
    $result = Arr::get($array, 'level1.level3', function(){return -1;});
    // $result = -1
```

### Setting a value using dot notation
```php
Arr::set($array, $key, $value): array
```
Sets a value in array for given key using dot notation. Function modifies given array directly, but also returns modified array for convenient usage.     

_**Notice:** `Arr::set()` is optimised for performance on dot notated keys. If you are not using dot-notation it is better (for performance) to use regular array manipulations._
### Examples:
```php
    $array = ['level1' => ['level2' => 'value']];
    $result = Arr::set($array, 'level1.level2_1', 'another value');
    // $result = ['level1' => ['level2' => 'value', 'level2_1' => 'another value']]
    // $array is same as $result
```

## TODO:
Arr::only for dot notation

Arr::pull for multiple keys
