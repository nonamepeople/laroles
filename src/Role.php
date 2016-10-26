<?php

namespace zehirpx\Laroles;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The model's primary key.
     *
     * @var string
     */
    protected $primaryKey = 'name';

    /**
     * Fillable attributes.
     *
     * @var array
     */
    protected $fillable = ['name', 'title', 'abilities'];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Attributes casting.
     *
     * @var array
     */
    protected $casts = [
        'abilities' => 'array',
    ];

    /**
     * Determine if the role has the given permission.
     *
     * @param string $permission
     *
     * @return bool
     */
    public function can($permission)
    {
        if (is_array($this->abilities)
            && count($this->abilities) > 0
            && $this->abilities[0] == '*') {

            return true;
        }

        return array_key_exists($permission, array_flip($this->abilities));
    }

    /**
     * Determine if the role does not has the given permission.
     *
     * @param string $permission
     *
     * @return bool
     */
    public function cant($permission)
    {
        return ! $this->can($permission);
    }
}
