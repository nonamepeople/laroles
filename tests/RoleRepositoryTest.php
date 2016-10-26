<?php

use zehirpx\Laroles\RoleRepository;

class RoleRepositoryTest extends PHPUnit_Framework_TestCase
{
    public function test_can_update_user_roles()
    {
        $roles = Mockery::mock(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class);
        $roles->shouldReceive('detach')->with(['foo'])->once();
        $roles->shouldReceive('attach')->with(['baz'])->once();

        $user = Mockery::mock(\Illuminate\Contracts\Auth\Authenticatable::class);
        $user->shouldReceive('roles')->once()->andReturn($roles);

        $user->roles = collect([
            ['name' => 'foo'],
            ['name' => 'bar']
        ]);

        $repository = new RoleRepository;

        $repository->updateUserRoles($user, ['bar', 'baz']);
    }

    public function test_can_update_user_roles_to_empty()
    {
        $roles = Mockery::mock(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class);
        $roles->shouldReceive('detach')->with(['foo', 'bar'])->once();
        $roles->shouldReceive('attach')->with([])->once();

        $user = Mockery::mock(\Illuminate\Contracts\Auth\Authenticatable::class);
        $user->shouldReceive('roles')->once()->andReturn($roles);

        $user->roles = collect([
            ['name' => 'foo'],
            ['name' => 'bar']
        ]);

        $repository = new RoleRepository;

        $repository->updateUserRoles($user, []);
    }
}
