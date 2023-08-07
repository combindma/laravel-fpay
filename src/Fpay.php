<?php

namespace Combindma\Fpay;

use Combindma\Fpay\Exceptions\InvalidConfiguration;
use Combindma\Fpay\Exceptions\InvalidRequest;

class Fpay
{
    private string $baseUri;

    private string $merchantId;

    private string $merchantKey;

    private string $merchantUrl;

    private string $callbackUrl;

    private string $amount;

    private string $currency;

    private string $oid;

    private string $email;

    private ?string $customerFirstName;

    private ?string $customerLastName;

    private ?string $tel;

    private string $tranType;

    private string $tranMode;

    private string $tranCapture;

    private string $lang;

    private string $messageVersion;

    /**
     * @throws InvalidConfiguration
     */
    public function __construct()
    {
        $this->baseUri = config('fpay.baseUri');
        $this->merchantId = config('fpay.merchantId');
        $this->merchantKey = config('fpay.merchantKey');
        $this->tranType = config('fpay.tranType');
        $this->tranMode = config('fpay.tranMode');
        $this->lang = config('fpay.lang');
        $this->currency = config('fpay.currency');
        $this->merchantUrl = config('fpay.merchantUrl');
        $this->callbackUrl = config('fpay.callbackUrl');
        $this->tranCapture = config('fpay.tranCapture');
        $this->customerLastName = null;
        $this->customerFirstName = null;
        $this->tel = null;
        $this->messageVersion = '4';
        $this->guardAgainstInvalidConfiguration();
    }

    public function getBaseUri(): ?string
    {
        return $this->baseUri;
    }

    public function getShopUrl(): ?string
    {
        return $this->merchantUrl;
    }

    public function setShopUrl(string $shopUrl): void
    {
        $this->merchantUrl = $shopUrl;
    }

    public function setCallbackUrl(string $callbackUrl): void
    {
        $this->callbackUrl = $callbackUrl;
    }

    public function setOid($oid): void
    {
        $this->oid = (string) $oid;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setAmount($amount): void
    {
        $this->amount = (string) $amount * 100;
    }

    public function setCustomerFirstName(string $firstName): void
    {
        $this->customerFirstName = $firstName;
    }

    public function setCustomerLastName(string $lastName): void
    {
        $this->customerLastName = $lastName;
    }

    public function setTel(string $tel): void
    {
        $this->tel = $tel;
    }

    public function setLang(string $lang): void
    {
        $this->lang = $lang;
    }

    public function setCurrency($currency): void
    {
        $this->currency = (string) $currency;
    }

    public function prepareRequest(array $customData = null): array
    {
        return [
            'FPAY_MESSAGE_VERSION' => $this->messageVersion,
            'MERCHANT_ID' => $this->merchantId,
            'AMOUNT' => $this->amount,
            'CURRENCY_CODE' => $this->currency,
            'TRANSACTION_TYPE' => $this->tranType,
            'TRANSACTION_MODE' => $this->tranMode,
            'ORDER_ID' => $this->oid,
            'MERCHANT_URL' => $this->merchantUrl,
            'CUSTOMER_EMAIL' => $this->email,
            'FPAY_URLREPAUTO' => $this->callbackUrl,
            'MESSAGE_SIGNATURE' => $this->getFpayMessageSignature($customData),
        ];
    }

    private function getFpayMessageSignature(array $customData = null): string
    {
        $message = $this->messageVersion.$this->merchantId.$this->amount.$this->currency.$this->tranCapture.$this->tranType.$this->tranMode.$customData.$this->oid.$this->merchantUrl.$this->customerLastName.$this->customerFirstName.$this->tel.$this->email.$this->lang.$this->callbackUrl;

        return strtoupper(hash_hmac('sha256', $message, $this->merchantKey));
    }

    public function guardAgainstInvalidRequest(): void
    {
        //amount
        if (! $this->amount) {
            throw InvalidRequest::amountNotSpecified();
        }

        if (! preg_match('/^\d+(\.\d{2})?$/', $this->amount)) {
            throw InvalidRequest::amountValueInvalid();
        }

        //currency
        if (! $this->currency) {
            throw InvalidRequest::currencyNotSpecified();
        }

        if (! is_string($this->currency) || strlen($this->currency) != 3) {
            throw InvalidRequest::currencyValueInvalid();
        }

        //oid
        if (! $this->oid) {
            throw InvalidRequest::attributeNotSpecified('identifiant de la commande (oid)');
        }

        if (! is_string($this->oid) || preg_match('/\s/', $this->oid)) {
            throw InvalidRequest::attributeInvalidString('identifiant de la commande (oid)');
        }

        //email
        if (! $this->email) {
            throw InvalidRequest::attributeNotSpecified('adresse email du client (email)');
        }

        if (! filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw InvalidRequest::emailValueInvalid();
        }
    }

    private function guardAgainstInvalidConfiguration(): void
    {
        //merchantId
        if (! $this->merchantId) {
            throw InvalidConfiguration::merchantIdNotSpecified();
        }

        if (preg_match('/\s/', $this->merchantId)) {
            throw InvalidConfiguration::merchantIdInvalid();
        }

        //merchantKey
        if (! $this->merchantKey) {
            throw InvalidConfiguration::merchantKeyNotSpecified();
        }

        if (preg_match('/\s/', $this->merchantKey)) {
            throw InvalidConfiguration::merchantKeyInvalid();
        }

        //tranType
        if (! $this->tranType) {
            throw InvalidConfiguration::attributeNotSpecified('Type de la transaction (tranType)');
        }

        if (preg_match('/\s/', $this->tranType)) {
            throw InvalidConfiguration::attributeInvalidString('Type de la transaction (tranType)');
        }

        //lang
        if (! in_array($this->lang, ['fr', 'ar', 'en'])) {
            throw InvalidConfiguration::langValueInvalid();
        }

        //baseUri
        if (! $this->baseUri) {
            throw InvalidConfiguration::attributeNotSpecified('gateway de paiement (baseUri)');
        }

        if (preg_match('/\s/', $this->baseUri)) {
            throw InvalidConfiguration::attributeInvalidString('gateway de paiement (baseUri)');
        }

        if (! preg_match("/\b(?:(?:https):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $this->baseUri)) {
            throw InvalidConfiguration::attributeInvalidUrl('gateway de paiement (baseUri)');
        }

        //merchantUrl
        if (! $this->merchantUrl) {
            throw InvalidConfiguration::attributeNotSpecified('shopUrl');
        }

        if (preg_match('/\s/', $this->merchantUrl)) {
            throw InvalidConfiguration::attributeInvalidString('shopUrl');
        }

        if (! preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $this->merchantUrl)) {
            throw InvalidConfiguration::attributeInvalidUrl('shopUrl');
        }

        //callbackUrl
        if (! $this->callbackUrl) {
            throw InvalidConfiguration::attributeNotSpecified('callbackUrl');
        }

        if (preg_match('/\s/', $this->callbackUrl)) {
            throw InvalidConfiguration::attributeInvalidString('callbackUrl');
        }

        if (! preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $this->callbackUrl)) {
            throw InvalidConfiguration::attributeInvalidUrl('callbackUrl');
        }
    }
}
