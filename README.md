# Array utils

[![Build Status](https://travis-ci.org/opxcore/array.svg?branch=master)](https://travis-ci.org/opxcore/array)
[![Coverage Status](https://coveralls.io/repos/github/opxcore/array/badge.svg?branch=master)](https://coveralls.io/github/opxcore/array?branch=master)
[![Latest Stable Version](https://poser.pugx.org/opxcore/array/v/stable)](https://packagist.org/packages/opxcore/array)
[![Total Downloads](https://poser.pugx.org/opxcore/array/downloads)](https://packagist.org/packages/opxcore/array)
[![License](https://poser.pugx.org/opxcore/array/license)](https://packagist.org/packages/opxcore/array)

## Installing
```
composer require opxcore/array
```
## Usage
Available methods:

For dot notation:
* `OpxCore\Arr\Arr::dot($array)`
* `OpxCore\Arr\Arr::get($array, $key, $default)`
* `OpxCore\Arr\Arr::set($array, $key, $value)`
* `OpxCore\Arr\Arr::has($array, $keys)`
* `OpxCore\Arr\Arr::forget($array, $keys)`
* `OpxCore\Arr\Arr::pull($array, $key, $default)`
* `OpxCore\Arr\Arr::push($array, $key, $value)`

Regular arrays only:
* `OpxCore\Arr\Arr::only($array, $keys)`
* `OpxCore\Arr\Arr::first($array, $callback, $default)`
* `OpxCore\Arr\Arr::last($array, $callback, $default)`

All `$default` values are optional and could be an instance of `\Closure` that returns value. By default they are always `null`.

_**Performance tips:** All methods for manipulating with dot notation are optimised for performance on dot notated
keys. **If you are care about performance** much it is better to use regular array manipulations on non dot notated arrays._

### Making a dot notated array
```php 
$dotNotated = Arr::dot($array);
```
Makes a dot notated array from any flat or multidimensional array.

```php
    $array = ['level1' => ['level2' => 'value']];
    
    $result = Arr::dot($array);
    // $result === ['level1.level2' => 'value']
```

### Getting a value using dot notation
```php
OpxCore\Arr\Arr::get($array, $key, $default = null)
```
Gets a value from the array using dot notation. If the given key is not existing 
in the array, this function will return default value.


```php
    use OpxCore\Arr\Arr;

    $array = ['level1' => ['level2' => 'value']];
    
    $result = Arr::get($array, 'level1.level2');
    // $result === 'value'

    $result = Arr::get($array, 'level1.level3');
    // $result === null

    $result = Arr::get($array, 'level1.level3', false);
    // $result === false

    $result = Arr::get($array, 'level1.level3', function(){return -1;});
    // $result === -1
```

### Setting a value using dot notation
```php
OpxCore\Arr\Arr::set($array, $key, $value): array
```
Sets the value into the array for the given key using dot notation. Function 
modifies given array directly, but also returns modified array for convenient usage.     

```php
    use OpxCore\Arr\Arr;
    
    $array = ['level1' => ['level2' => 'value']];
    
    $result = Arr::set($array, 'level1.level2_1', 'another value');
    // $result === ['level1' => ['level2' => 'value', 'level2_1' => 'another value']]
    // $array === $result
```

### Determining a key (or keys) existence in the array
```php
OpxCore\Arr\Arr::has($array, $keys)
```
Determines if the given key (or several keys) are existing in the array.
```php
    use OpxCore\Arr\Arr;
    
    $array = ['level1' => ['level2' => 'value', 'level2_1' => 'another value']];
    
    $result = Arr::has($array, 'level1.level2');
    // $result === true
    
    $result = Arr::has($array, ['level1.level2', 'level1.level2_2']);
    // $result === false
```
 
### Removing the values associated with the given keys
```php
OpxCore\Arr\Arr::forget($array, $keys)
```
Removes the given key (or several keys given as an array) from the array. If any of 
keys are not existing in the array nothing happens. Function modifies given array 
directly, but also returns modified array for convenient usage.
```php
    use OpxCore\Arr\Arr;
    
    $array = ['level1' => ['level2' => 'value', 'level2_1' => 'another value']];
    
    $result = Arr::forget($array, 'level1.level2');
    // $result === ['level1' => ['level2_1' => 'another value']]
    // $array === $result
``` 

### Pulling the value from the array
```php
OpxCore\Arr\Arr::pull($array, $key, $default)
```
Actually, this is combination of `Arr::get()` and `Arr::forget()` methods. This method
fetches the value and then removes it from the array. If the key is not exists in the 
array, default value will be returned.
```php
    use OpxCore\Arr\Arr;
    
    $array = ['level1' => ['level2' => 'value', 'level2_1' => 'another value']];
    
    $result = Arr::pull($array, 'level1.level2');
    // $result === 'value' 
    // $array === ['level1' => ['level2_1' => 'another value']]
```   

### Pushing the value into the array
```php
OpxCore\Arr\Arr::push($array, $key, $value)
```
Pushes the value into the given key in array. If given key is not existing, it will be 
created and the value will be set as item of unassociated array. If the key is existing,
value associated with this key will be casted as array and value will be added into it.
Function modifies given array  directly, but also returns modified array for convenient 
usage.
```php
        use OpxCore\Arr\Arr;
        
        $array = ['level1' => ['level2' => 'value']];
        
        $result = Arr::push($array, 'level1.level2', 'another value');
        // $result === ['level1' => ['level2' => ['value', 'another value']]] 
        // $array === $result
```