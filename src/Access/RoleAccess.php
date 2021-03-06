<?php

namespace Orchid\Access;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Core\Models\User;

trait RoleAccess
{
    /**
     * @return mixed
     */
    public function getRoleId(): int
    {
        return $this->getKey();
    }

    /**
     * @return mixed
     */
    public function getRoleSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @return mixed
     */
    public function delete(): bool
    {
        $isSoftDeleted = array_key_exists('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this));
        if ($this->exists && !$isSoftDeleted) {
            $this->users()->detach();
        }

        return parent::delete();
    }

    /**
     * The Users relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_users', 'role_id',
            'user_id')->withTimestamps();
    }
}
