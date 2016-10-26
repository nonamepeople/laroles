<?php

use zehirpx\Laroles\Role;
use zehirpx\Laroles\HasRoles;

class UserTest extends PHPUnit_Framework_TestCase
{
    public function test_roles_permissions_can_be_determined()
    {
        $user = new TestUser;

        $this->assertTrue($user->rolesCan('posts'));
        $this->assertTrue($user->rolesCan('users'));
        $this->assertFalse($user->rolesCan('something'));
        $this->assertTrue($user->rolesCant('something'));
    }

    public function test_roles_can_be_determined()
    {
        $user = new TestUser;

        $this->assertTrue($user->hasRole('admin'));
        $this->assertTrue($user->hasRole('support'));
        $this->assertFalse($user->hasRole('something'));
    }
}

class TestUser
{
    use HasRoles;

    public function roles() {
        //
    }

    public function __get($name)
    {
        if ($name === 'roles') {
            return collect([
                new Role(['name' => 'support', 'abilities' => ['posts']]),
                new Role(['name' => 'admin', 'abilities' => ['users']])
            ]);
        }

        return parent::__get($name);
    }
}