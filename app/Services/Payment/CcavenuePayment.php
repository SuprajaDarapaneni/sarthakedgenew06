<?php

namespace App\Services\Payment;

use Exception;

class CcavenuePayment implements PaymentInterface {
    private string $workingKey;
    private string $accessCode;
    private string $merchantId;
    private string $currencyCode;

    public function __construct($workingKey, $accessCode, $merchantId, $currencyCode) {
        $this->workingKey = $workingKey;
        $this->accessCode = $accessCode;
        $this->merchantId = $merchantId;
        $this->currencyCode = $currencyCode;
    }

    public function createPaymentIntent($amount, $customMetaData) {
        $merchant_data = "";
        
        // Basic required fields for CCAvenue
        $merchant_data .= 'merchant_id=' . $this->merchantId . '&';
        $merchant_data .= 'amount=' . $amount . '&';
        $merchant_data .= 'currency=' . $this->currencyCode . '&';
        
        // Append all custom metadata
        foreach ($customMetaData as $key => $value) {
            $merchant_data .= $key . '=' . $value . '&';
        }

        // Ensure order_id is present
        if (!str_contains($merchant_data, 'order_id=')) {
            $merchant_data .= 'order_id=' . ($customMetaData['order_id'] ?? uniqid()) . '&';
        }

        $encrypted_data = $this->encrypt($merchant_data, $this->workingKey);
        $url = 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction';

        return [
            'url' => $url,
            'payment_link' => $url, // Fallback
            'encRequest' => $encrypted_data,
            'access_code' => $this->accessCode,
            'order_id' => $customMetaData['order_id'] ?? null
        ];
    }

    public function prepare($params) {
        return $this->createPaymentIntent($params['amount'], $params);
    }

    public function createAndFormatPaymentIntent($amount, $customMetaData): array {
        $data = $this->createPaymentIntent($amount, $customMetaData);
        return [
            'id' => $customMetaData['order_id'] ?? uniqid(),
            'amount' => $amount,
            'currency' => $this->currencyCode,
            'status' => 'pending',
            'payment_data' => $data
        ];
    }

    public function retrievePaymentIntent($paymentId): array {
        // CCAvenue doesn't support retrieving by ID in the same way Stripe does
        // This would usually be handled in the response callback
        return [];
    }

    public function minimumAmountValidation($currency, $amount) {
        return $amount > 0 ? $amount : 1;
    }

    public function formatPaymentIntent($id, $amount, $currency, $status, $metadata, $paymentIntent): array {
        return [
            'id' => $id,
            'amount' => $amount,
            'currency' => $currency,
            'status' => $status,
            'metadata' => $metadata
        ];
    }

    /**
     * @param $plainText
     * @param $key
     * @return string
     */
    public function encrypt($plainText, $key) {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        $encryptedText = bin2hex($openMode);
        return $encryptedText;
    }

    /**
     * @param $encryptedText
     * @param $key
     * @return string
     */
    public function decrypt($encryptedText, $key) {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText = $this->hextobin($encryptedText);
        $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        return $decryptedText;
    }

    private function hextobin($hexString) {
        $length = strlen($hexString);
        $binString = "";
        $count = 0;
        while ($count < $length) {
            $subString = substr($hexString, $count, 2);
            $packedString = pack("H*", $subString);
            if ($count == 0) {
                $binString = $packedString;
            } else {
                $binString .= $packedString;
            }
            $count += 2;
        }
        return $binString;
    }
}
