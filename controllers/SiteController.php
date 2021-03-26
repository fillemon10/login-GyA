<?php

namespace app\controllers;


use app\core\Application;
use app\core\BankID;
use app\core\Controller;
use app\core\middlewares\AuthMiddleware;
use app\core\Request;
use app\core\Response;
use app\models\BankIDUser;
use app\models\LoginForm;
use app\models\User;
use Dimafe6\BankID\Model\CollectResponse;
use Dimafe6\BankID\Service\BankIDService;

/**
 * Class SiteController
 *
 */
class SiteController extends Controller
{
    public function home()
    {
        return $this->render('home');
    }
    public function mobilt()
    {
        return $this->render('mobilt');
    }
    public function otherDevice()
    {
        $user = new BankIDUser();

        return $this->render('other-device', [
            'model' => $user,
        ]);
    }

    public function otherDevicePost(Request $request)
    {
        $user = new BankIDUser();
        if ($request->isPost()) {
            $user->loadData($request->getData());
        }

        $bankID = new BankID();
        $bankID->setUp();

            $response = $bankID->AuthResponse($user->{"personalNumber"});

            $authResponse = $bankID->CollectAuthResponse($response);

            if ($authResponse->status == CollectResponse::STATUS_COMPLETED) {
                $user->login($authResponse->completionData->user->personalNumber);
                Application::$app->response->redirect('/');
            }

        return $this->render('other-device', [
            'model' => $user,
        ]);
    }

    public function sameDevice()
    {
        return $this->render('same-device');
    }

    public function bankid()
    {
        $login = new LoginForm();
        return $this->render('bankid', [
            'model' => $login,]);
    }
}
