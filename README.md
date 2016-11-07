# la-roles

A light permission management for Laravel.

## Requirements

- Laravel >= 5.0

## Installation

To get started, install the package via the Composer package manager:

    composer require zehirpx/laroles
   
Next, register the service provider in the `providers` array of your `config/app.php`:

    zehirpx\Laroles\LarolesServiceProvider::class,
    
Now, publish and migrate the migrations:

    php artisan vendor:publish
    php artisan migrate

After running the commands, addd the `zehirpx\Laroles\HasRoles` trait to your `App\User` model.
The trait will provide a few method to your model which allow you inspect the roles and permissions of the user.

```php
<?php

namespace App;

use zehirpx\Laroles\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasRoles;
}
```

## Quickstart

#### Create a role

You can create a role by using the `create` method of the `RoleRepository`:

```php
$roles = new zehirpx\Laroles\RoleRepository;

$roles->create('customer-support', 'Customer Support', [
            'create-servers', 'update-servers']);
```

#### Assign roles to a User

You can assign or re-assign roles for a user by using the `updateUserRoles` method of the `RoleRepository`:

```php
$roles->updateUserRoles($user, ['customer-support']);
```

> Note: A user can be assigned to multiple roles.

#### Check permissions on a User

Since we have used the `HasRoles` trait to the `App\User` model, so we can use the `rolesCan` method to check
if the user's roles has the given permission.

```php
$user->rolesCan('update-servers');      // true
$user->rolesCan('delete-servers');      // false
```

> Note: The `roleCan` method will checking on all the roles that assigned to the user.

#### Check permissions on a Role

You may also wish to check for the permissions on a `Role` model by using the `can` method of the model:

```php
$role->can('create-servers');       // true
$role->can('delete-servers');       // false
```