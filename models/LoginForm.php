<?php

namespace app\models;


use app\core\Application;
use app\core\Model;

/**
 * Class LoginForm
 *
 */
class LoginForm extends Model
{
    public string $username = '';
    public string $password = '';

    public function rules()
    {
        return [
            'username' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED],
        ];
    }

    public function labels()
    {
        return [
            'username' => 'Användarnamn',
            'password' => 'Lösenord'
        ];
    }

    public function login()
    {
        $user = User::findOne(['email' => $this->email]);
        if (!$user) {
            $this->addError('email', 'User does not exist with this email address');
            return false;
        }
        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', 'Password is incorrect');
            return false;
        }

        return Application::$app->login($user);
    }
}
