<?php

namespace app\models;


use app\core\Application;
use app\core\Model;

/**
 * Class OtherDevice
 *
 */
class BankIDUser extends Model
{
    public string $personalNumber = '';

    public function rules()
    {
    }

    public function labels()
    {
        return [
            'personalNumber' => 'Personnummer (YYYYMMDDXXXX)',
        ];
    }

    public function login($personalNumberFromBankId)
    {
        return Application::$app->session->set('bankiduser', $personalNumberFromBankId);
    }
}
