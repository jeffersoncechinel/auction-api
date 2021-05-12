<?php

namespace App\Extensions;

use App\Models\Auth\User;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class DummyUserProvider implements UserProvider
{
    /**
     * The Mongo User Model
     */
    private $model;

    /**
     *
     * @param User $userModel
     */
    public function __construct(User $userModel)
    {
        $this->model = $userModel;
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials)) {
            return null;
        }

        return $this->model->fetchUserByCredentials('username', $credentials);
    }

    public function retrieveByToken($identifier, $token)
    {
        if (! $token) {
            return null;
        }

        return $this->model->fetchUserByToken('token', $token);
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param array $credentials  Request credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return ($credentials['username'] == $user->getAuthIdentifier() &&
            $credentials['password'] == $user->getAuthPassword());
    }

    public function retrieveById($identifier)
    {
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
    }
}
