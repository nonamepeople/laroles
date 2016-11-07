<?php

namespace zehirpx\Laroles;

trait HasRoles
{
    /**
     * The roles that the user belongs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Determine if the user's roles have the given permission.
     *
     * @param string $permission
     *
     * @return bool
     */
    public function rolesCan($permission)
    {
        return $this->roles->contains(function ($role) use ($permission) {
            return $role->can($permission);
        });
    }

    /**
     * Determine if the user's roles do not have the given permission.
     *
     * @param string $permission
     *
     * @return bool
     */
    public function rolesCant($permission)
    {
        return ! $this->rolesCan($permission);
    }

    /**
     * Determine if the user belongs to the given role.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasRole($name)
    {
        return $this->roles->contains('name', $name);
    }
}