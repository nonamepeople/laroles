<?php

use zehirpx\Laroles\Role;
use zehirpx\Laroles\RoleRepository;

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Model as Eloquent;

class RoleRepositoryTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        Eloquent::unguard();

        $db = new DB;

        $db->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);

        $db->bootEloquent();
        $db->setAsGlobal();

        $this->schema()->create('users', function ($table) {
            $table->integer('id')->primary();
            $table->string('name');
            $table->timestamps();
        });

        $this->schema()->create('roles', function ($table) {
            $table->string('name')->primary();
            $table->string('title')->nullable();
            $table->text('abilities')->nullable();
            $table->timestamps();
        });

        $this->schema()->create('role_user', function ($table) {
            $table->integer('user_id');
            $table->string('role_id');
            $table->primary(['user_id', 'role_id']);
            $table->timestamps();
        });

        Role::create([
            'name' => 'foo',
        ]);

        Role::create([
            'name' => 'bar',
        ]);

        Role::create([
            'name' => 'baz',
        ]);
    }

    public function tearDown()
    {
        $this->schema()->dropIfExists('users');
        $this->schema()->dropIfExists('roles');
        $this->schema()->dropIfExists('role_user');
    }

    public function test_can_update_user_roles()
    {
        $user = User::create([
            'name' => 'Shin Greer'
        ]);

        $user->roles()->attach(['foo', 'bar']);

        $repository = new RoleRepository;

        $repository->updateUserRoles($user, ['bar', 'baz']);

        $this->assertNull($user->roles()->find('foo'));
        $this->assertNotNull($user->roles()->find('bar'));
        $this->assertNotNull($user->roles()->find('baz'));
    }

    protected function schema()
    {
        return Eloquent::getConnectionResolver()->connection()->getSchemaBuilder();
    }
}

class User extends \Illuminate\Database\Eloquent\Model
{
    use \zehirpx\Laroles\HasRoles;
}
