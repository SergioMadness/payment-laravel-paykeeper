<?php namespace professionalweb\payment\drivers\paykeeper;

use Illuminate\Http\Response;
use professionalweb\payment\contracts\Form;
use professionalweb\payment\contracts\Receipt;
use professionalweb\payment\contracts\PayService;
use professionalweb\payment\contracts\PayProtocol;
use professionalweb\payment\models\PayServiceOption;
use professionalweb\payment\interfaces\PaykeeperService;

class PaykeeperDriver implements PayService, PaykeeperService
{
    /**
     * Module config
     *
     * @var array
     */
    private $config;

    public function __construct(array $config = [])
    {
        $this->setConfig($config);
    }

    /**
     * Get name of payment service
     *
     * @return string
     */
    public function getName(): string
    {
        return self::PAYMENT_PAYKEEPER;
    }

    /**
     * Pay
     *
     * @param mixed $orderId
     * @param mixed $paymentId
     * @param float $amount
     * @param string $currency
     * @param string $paymentType
     * @param string $successReturnUrl
     * @param string $failReturnUrl
     * @param string $description
     * @param array $extraParams
     * @param Receipt $receipt
     *
     * @return string
     */
    public function getPaymentLink($orderId, $paymentId, float $amount, string $currency = self::CURRENCY_RUR, string $paymentType = self::PAYMENT_TYPE_CARD, string $successReturnUrl = '', string $failReturnUrl = '', string $description = '', array $extraParams = [], Receipt $receipt = null): string
    {
        $payment_parameters = http_build_query(
            [
                'clientid'     => $extraParams['email'],
                'orderid'      => $orderId,
                'sum'          => $amount,
                'client_phone' => $extraParams['phone'] ?? '',
                'cart'         => json_encode($receipt->toArray()),
            ]
        );
        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $payment_parameters,
            ],
        ];
        $context = stream_context_create($options);

        return file_get_contents('https://demo.paykeeper.ru/order/inline/', FALSE, $context);
    }

    /**
     * Payment system need form
     * You can not get url for redirect
     *
     * @return bool
     */
    public function needForm(): bool
    {
        return false;
    }

    /**
     * Generate payment form
     *
     * @param mixed $orderId
     * @param mixed $paymentId
     * @param float $amount
     * @param string $currency
     * @param string $paymentType
     * @param string $successReturnUrl
     * @param string $failReturnUrl
     * @param string $description
     * @param array $extraParams
     * @param Receipt $receipt
     *
     * @return Form
     */
    public function getPaymentForm($orderId, $paymentId, float $amount, string $currency = self::CURRENCY_RUR, string $paymentType = self::PAYMENT_TYPE_CARD, string $successReturnUrl = '', string $failReturnUrl = '', string $description = '', array $extraParams = [], Receipt $receipt = null): Form
    {
        throw new \Exception();
    }

    /**
     * Validate request
     *
     * @param array $data
     *
     * @return bool
     */
    public function validate(array $data): bool
    {
        return isset($data['clientid'], $data['sum'], $data['orderid'], $data['client_phone']);
    }

    /**
     * Parse notification
     *
     * @param array $data
     *
     * @return $this
     */
    public function setResponse(array $data): PayService
    {
//        $this->response = $data;

        return $this;
    }

    /**
     * Get order ID
     *
     * @return string
     */
    public function getOrderId(): string
    {
        // TODO: Implement getOrderId() method.
    }

    /**
     * Get payment id
     *
     * @return string
     */
    public function getPaymentId(): string
    {
        // TODO: Implement getPaymentId() method.
    }

    /**
     * Get operation status
     *
     * @return string
     */
    public function getStatus(): string
    {
        // TODO: Implement getStatus() method.
    }

    /**
     * Is payment succeed
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        // TODO: Implement isSuccess() method.
    }

    /**
     * Get transaction ID
     *
     * @return string
     */
    public function getTransactionId(): string
    {
        // TODO: Implement getTransactionId() method.
    }

    /**
     * Get transaction amount
     *
     * @return float
     */
    public function getAmount(): float
    {
        // TODO: Implement getAmount() method.
    }

    /**
     * Get error code
     *
     * @return string
     */
    public function getErrorCode(): string
    {
        // TODO: Implement getErrorCode() method.
    }

    /**
     * Get payment provider
     *
     * @return string
     */
    public function getProvider(): string
    {
        return self::PAYMENT_PAYKEEPER;
    }

    /**
     * Get PAN
     *
     * @return string
     */
    public function getPan(): string
    {
        // TODO: Implement getPan() method.
    }

    /**
     * Get payment datetime
     *
     * @return string
     */
    public function getDateTime(): string
    {
        // TODO: Implement getDateTime() method.
    }

    /**
     * Get payment currency
     *
     * @return string
     */
    public function getCurrency(): string
    {
        // TODO: Implement getCurrency() method.
    }

    /**
     * Get card type. Visa, MC etc
     *
     * @return string
     */
    public function getCardType(): string
    {
        // TODO: Implement getCardType() method.
    }

    /**
     * Get card expiration date
     *
     * @return string
     */
    public function getCardExpDate(): string
    {
        // TODO: Implement getCardExpDate() method.
    }

    /**
     * Get cardholder name
     *
     * @return string
     */
    public function getCardUserName(): string
    {
        // TODO: Implement getCardUserName() method.
    }

    /**
     * Get card issuer
     *
     * @return string
     */
    public function getIssuer(): string
    {
        // TODO: Implement getIssuer() method.
    }

    /**
     * Get e-mail
     *
     * @return string
     */
    public function getEmail(): string
    {
        // TODO: Implement getEmail() method.
    }

    /**
     * Get payment type. 'GooglePay' for example
     *
     * @return string
     */
    public function getPaymentType(): string
    {
        // TODO: Implement getPaymentType() method.
    }

    /**
     * Set transport/protocol wrapper
     *
     * @param PayProtocol $protocol
     *
     * @return $this
     */
    public function setTransport(PayProtocol $protocol): PayService
    {
        // TODO: Implement setTransport() method.
    }

    /**
     * Prepare response on notification request
     *
     * @param int $errorCode
     *
     * @return Response
     */
    public function getNotificationResponse(int $errorCode = null): Response
    {
        // TODO: Implement getNotificationResponse() method.
    }

    /**
     * Prepare response on check request
     *
     * @param int $errorCode
     *
     * @return Response
     */
    public function getCheckResponse(int $errorCode = null): Response
    {
        // TODO: Implement getCheckResponse() method.
    }

    /**
     * Get last error code
     *
     * @return int
     */
    public function getLastError(): int
    {
        // TODO: Implement getLastError() method.
    }

    /**
     * Get param by name
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getParam(string $name)
    {
        // TODO: Implement getParam() method.
    }

    /**
     * Get pay service options
     *
     * @return array
     */
    public static function getOptions(): array
    {
        return [
            (new PayServiceOption())->setType(PayServiceOption::TYPE_STRING)->setLabel('Url')->setAlias('apiUrl'),
        ];
    }

    /**
     * Set driver configuration
     *
     * @param array $config
     *
     * @return $this
     */
    public function setConfig(array $config): self
    {
        $this->config = $config;

        return $this;
    }
}