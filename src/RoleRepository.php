<?php

namespace zehirpx\Laroles;

class RoleRepository
{
    /**
     * Find the role by the given name.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function findByName($name)
    {
        return Role::find($name);
    }

    /**
     * Create a new role.
     *
     * @param string $name
     * @param string $title
     * @param array $abilities
     *
     * @return Role
     */
    public function create($name, $title = null, array $abilities = null)
    {
        return Role::forceCreate([
            'name' => $name,
            'title' => $title,
            'abilities' => $abilities ?: ['*']
        ]);
    }

    /**
     * Update the given role.
     *
     * @param Role $role
     * @param string $name
     * @param string $title
     * @param array $abilities
     *
     * @return void
     */
    public function update(Role $role, $name, $title = null, array $abilities = null)
    {
        $role->forceFill([
            'name' => $name,
            'title' => $title,
            'abilities' => $abilities ?: ['*']
        ])->save();
    }

    /**
     * Delete the given role.
     *
     * @param Role $role
     *
     * @throws \Exception
     * @return void
     */
    public function delete(Role $role)
    {
        $role->delete();
    }

    /**
     * Update the roles of the given user.
     *
     * @param HasRoles $user
     * @param array $roles
     *
     * @return void
     */
    public function updateUserRoles($user, array $roles = [])
    {
        $current = $user->roles;

        $user->roles()->detach(
            $current->pluck('name')->diff($roles)->values()->toArray()
        );

        $user->roles()->attach(
            collect($roles)->diff($current->pluck('name'))->values()->toArray()
        );
    }
}