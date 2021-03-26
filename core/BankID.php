<?php

namespace app\core;

use Dimafe6\BankID\Model\CollectResponse;
use Dimafe6\BankID\Model\OrderResponse;
use Dimafe6\BankID\Service\BankIDService;

class BankID
{
    const TEST_PERSONAL_NUMBER = '199202271434';

    /**
     * @var BankIDService $bankIDService
     */
    private $bankIDService;

    public function setUp()
    {
        $this->bankIDService = new BankIDService(
            'https://appapi2.test.bankid.com/rp/v5/',
            isset($_SERVER["REMOTE_ADDR"]) ? $_SERVER["REMOTE_ADDR"] : '127.0.0.1',
            [
                'verify' => false,
                'cert'   => __DIR__ . '\bankId.pem',

            ]
        );
    }

    /**
     * @return OrderResponse
     */
    public function SignResponse($personalNumber)
    {
        $signResponse = $this->bankIDService->getSignResponse(
            $personalNumber,
            'userVisibleData',
            'userNonVisibleData'
        );
        return $signResponse;
    }

    /**
     * @depends SignResponse
     * @param OrderResponse $signResponse
     * @return \Dimafe6\BankID\Model\CollectResponse
     */
    public function CollectSignResponse($signResponse)
    {

        $attempts = 0;
        do {
            fwrite(STDOUT, "\nWaiting confirmation from BankID application...\n");
            sleep(10);

            $collectResponse = $this->bankIDService->collectResponse($signResponse->orderRef);
            $attempts++;
        } while ($collectResponse->status !== CollectResponse::STATUS_COMPLETED && $attempts <= 6);

        return $collectResponse;
    }

    /**
     * @return OrderResponse
     */
    public function SignResponseWithoutPersonalNumber()
    {
        $signResponse = $this->bankIDService->getSignResponse(
            null,
            'userVisibleData',
            'userNonVisibleData'
        );


        return $signResponse;
    }


    /**
     * @depends SignResponseWithoutPersonalNumber
     * @param OrderResponse $signResponse
     * @return \Dimafe6\BankID\Model\CollectResponse
     */
    public function CollectSignResponseWithoutPersonalNumber($signResponse)
    {

        $attempts = 0;
        do {
            fwrite(STDOUT, "\nWaiting confirmation from BankID application...\n");
            sleep(10);

            $collectResponse = $this->bankIDService->collectResponse($signResponse->orderRef);
            $attempts++;
        } while ($collectResponse->status !== CollectResponse::STATUS_COMPLETED && $attempts <= 6);

        return $collectResponse;
    }

    /**
     * @return OrderResponse
     */
    public function AuthResponse($personalNumber)
    {
        $authResponse = $this->bankIDService->getAuthResponse($personalNumber);

        return $authResponse;
    }

    /**
     * @depends AuthResponse
     * @param OrderResponse $authResponse
     * @return \Dimafe6\BankID\Model\CollectResponse
     */
    public function CollectAuthResponse($authResponse)
    {
        $attempts = 0;
        do {
            fwrite(STDOUT, "\nWaiting confirmation from BankID application...\n");
            sleep(10);

            $collectResponse = $this->bankIDService->collectResponse($authResponse->orderRef);
            $attempts++;
        } while ($collectResponse->status !== CollectResponse::STATUS_COMPLETED && $attempts <= 6);


        return $collectResponse;
    }

    /**
     * @return OrderResponse
     */
    public function AuthResponseWithoutPersonalNumber()
    {
        $authResponse = $this->bankIDService->getAuthResponse();

        return $authResponse;
    }

    /**
     * @depends AuthResponseWithoutPersonalNumber
     * @param OrderResponse $authResponse
     * @return \Dimafe6\BankID\Model\CollectResponse
     */
    public function CollectAuthResponseWithoutPersonalNumber($authResponse)
    {

        $attempts = 0;
        do {
            sleep(10);

            $collectResponse = $this->bankIDService->collectResponse($authResponse->orderRef);
            $attempts++;
        } while ($collectResponse->status !== CollectResponse::STATUS_COMPLETED && $attempts <= 6);

        return $collectResponse;
    }

    public function CancelResponse($personalNumber)
    {
        $authResponse = $this->bankIDService->getAuthResponse($personalNumber);

        sleep(3);

        $cancelResponse = $this->bankIDService->cancelOrder($authResponse->orderRef);

    }
}
