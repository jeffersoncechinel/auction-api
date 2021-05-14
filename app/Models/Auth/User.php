<?php

namespace App\Models\Auth;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

/**
 * Class User
 * @package App\Models\Auth
 * @property integer $id
 * @property string $name
 * @property string $token
 */
class User implements AuthenticatableContract
{
    private $username;
    private $password;

    protected function getUsers()
    {
        return [
            [
                'id' => 1,
                'name' => 'User 1',
                'username' => 'user1',
                'password' => 'user1',
                'token' => '8632361b1d633c2583e24d41fb92cc76',
            ],
            [
                'id' => 2,
                'name' => 'User 2',
                'username' => 'user2',
                'password' => 'user2',
                'token' => '3f08f6e7cbb31db4e259d847b4e3c724',
            ],
        ];
    }

    /**
     * @param $identifier
     * @param array $credentials
     * @return $this
     */
    public function fetchUserByCredentials($identifier, array $credentials)
    {
        $user = $this->findUser($identifier, $credentials['username']);

        if ($user) {
            $this->username = $user['username'];
            $this->password = $user['password'];
            $this->name = $user['name'];
            $this->id = $user['id'];
            $this->token = $user['token'];
        }

        return $this;
    }

    /**
     * @param $identifier
     * @param $token
     * @return $this
     */
    public function fetchUserByToken($identifier, $token)
    {
        if (! $user = $this->findUser($identifier, $token)) {
            return null;
        }

        $this->username = $user['username'];
        $this->password = $user['password'];
        $this->name = $user['name'];
        $this->id = $user['id'];
        $this->token = $user['token'];

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return "username";
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Contracts\Auth\Authenticatable::getAuthIdentifier()
     */
    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    /**
     * {@inheritDoc}
     * @see \Illuminate\Contracts\Auth\Authenticatable::getAuthPassword()
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
    }

    public function setRememberToken($value)
    {
    }

    public function getRememberTokenName()
    {
    }

    /**
     * @param $identifier
     * @param $value
     * @return array|false|mixed
     */
    protected function findUser($identifier, $value)
    {
        //identifier: username or token
        foreach ($this->getUsers() as $user) {
            if ($user[$identifier] == $value) {
                return $user;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function safeData()
    {
        return [
            'name' => $this->name,
            'token' => $this->token,
        ];
    }
}
