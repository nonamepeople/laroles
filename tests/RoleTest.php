<?php

use zehirpx\Laroles\Role;

class RoleTest extends PHPUnit_Framework_TestCase
{
    public function test_permissions_can_be_determined()
    {
        $role = new Role(['abilities' => ['posts']]);

        $this->assertTrue($role->can('posts'));
        $this->assertFalse($role->can('something'));
        $this->assertTrue($role->cant('something'));
    }

    public function test_wildcard_permissions_can_be_determined()
    {
        $role = new Role(['abilities' => ['*']]);

        $this->assertTrue($role->can('posts'));
        $this->assertTrue($role->can('something'));
    }
}
