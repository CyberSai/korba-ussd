<?php


namespace Korba;


class XChangeV1 extends API
{

    private $secret_key;
    private $client_key;
    private $client_id;
    private static $url = 'https://xchange.korbaweb.com/api/v1.0';

    public function __construct($secret_key, $client_key, $client_id, $proxy = null)
    {
        $headers = array(
            'Cache-Control: no-cache',
            'Content-Type: application/json'
        );
        parent::__construct(XChangeV1::$url, $headers, $proxy);
        $this->secret_key = $secret_key;
        $this->client_key = $client_key;
        $this->client_id = $client_id;
    }

    private function getHMACHeader($data) {
        $data = (gettype($data) == 'string') ? json_decode($data, true) : $data;
        $data = array_merge($data, ['client_id' => $this->client_id]);
        $message = '';
        $i = 0;
        ksort($data);
        foreach ($data as $key => $value) {
            $message .= ($i == 0) ? "{$key}={$value}" : "&{$key}={$value}";
            $i++;
        }
        $hmac_signature = hash_hmac('sha256', $message, $this->secret_key);
        return ["Authorization: HMAC {$this->client_key}:{$hmac_signature}"];
    }

    protected function call($endpoint, $data, $extra_headers = null)
    {
        $data = array_merge($data, ['client_id' => $this->client_id]);
        $extra_headers = ($extra_headers) ? array_merge($extra_headers, $this->getHMACHeader($data)) : $this->getHMACHeader($data);
        return parent::call($endpoint, $data, $extra_headers);
    }

    protected function add_optional_data(&$data, $optional_data) {
        foreach ($optional_data as $key => $value) {
            if ($optional_data[$key]) {
                $data[$key] = $value;
            }
        }
    }

    public function collect(
        $customer_number, $amount, $transaction_id, $network_code, $callback_url,
        $vodafone_voucher_code = null, $description = null, $payer_name = null, $extra_info = null) {
        $data = [
            'customer_number' => $customer_number,
            'amount' => $amount,
            'transaction_id' => $transaction_id,
            'network_code' => $network_code,
            'callback_url' => $callback_url
        ];
        $opt_data = [
            'vodafone_voucher_code' => $vodafone_voucher_code,
            'description' => $description,
            'payer_name' => $payer_name,
            'extra_info' => $extra_info
        ];
        $this->add_optional_data($data, $opt_data);
        return $this->call('collect/', $data);
    }

    public function disburse(
        $customer_number, $amount, $transaction_id, $network_code, $callback_url,
        $description = null, $extra_info = null, $bank_account_number = null,
        $bank_name = null, $bank_branch_name = null, $payer_name = null, $payer_mobile = null) {
        $data = [
            'customer_number' => $customer_number,
            'amount' => $amount,
            'transaction_id' => $transaction_id,
            'network_code' => $network_code,
            'callback_url' => $callback_url
        ];
        $opt_data = [
            'description' => $description,
            'extra_info' => $extra_info,
            'bank_account_number' => $bank_account_number,
            'bank_name' => $bank_name,
            'bank_branch_name' => $bank_branch_name,
            'payer_name' => $payer_name,
            'payer_mobile' => $payer_mobile
        ];
        $this->add_optional_data($data, $opt_data);
        return $this->call('disburse/', $data);
    }

    public function top_up(
        $customer_number, $amount, $transaction_id, $network_code, $callback_url,
        $description = null, $payer_name = null, $extra_info = null) {
        $data = [
            'customer_number' => $customer_number,
            'amount' => $amount,
            'transaction_id' => $transaction_id,
            'network_code' => $network_code,
            'callback_url' => $callback_url
        ];
        $opt_data = [
            'description' => $description,
            'payer_name' => $payer_name,
            'extra_info' => $extra_info
        ];
        $this->add_optional_data($data, $opt_data);
        return $this->call('topup/', $data);
    }

    private function internet_data(
        $customer_number, $transaction_id, $bundle_id, $amount, $callback_url,
        $description = null, $payer_name = null, $extra_info = null) {
        $data = [
            'customer_number' => $customer_number,
            'transaction_id' => $transaction_id,
            'bundle_id' => $bundle_id,
            'amount' => $amount,
            'callback_url' => $callback_url
        ];
        $opt_data = [
            'description' => $description,
            'payer_name' => $payer_name,
            'extra_info' => $extra_info
        ];
        $this->add_optional_data($data, $opt_data);
        return $data;
    }

    public function surfline_purchase(
        $customer_number, $transaction_id, $bundle_id, $amount, $callback_url,
        $description = null, $payer_name = null, $extra_info = null) {
        $data = $this->internet_data(
            $customer_number, $transaction_id, $bundle_id, $amount, $callback_url,
            $description, $payer_name, $extra_info);
        return $this->call('purchase_surfline_bundle/', $data);
    }

    public function surfline_bundles($customer_number) {
        $data = [
            'customer_number' => $customer_number
        ];
        return $this->call('get_surfline_bundles/', $data);
    }

    public function busy_purchase(
        $customer_number, $transaction_id, $bundle_id, $amount, $callback_url,
        $description = null, $payer_name = null, $extra_info = null) {
        $data = $this->internet_data(
            $customer_number, $transaction_id, $bundle_id, $amount, $callback_url,
            $description, $payer_name, $extra_info);
        return $this->call('purchase_busy_bundle/', $data);
    }

    public function busy_bundles($customer_number) {
        $data = [
            'customer_number' => $customer_number
        ];
        return $this->call('get_busy_bundles/', $data);
    }

    public function telesol_purchase(
        $customer_number, $transaction_id, $bundle_id, $amount, $callback_url,
        $description = null, $payer_name = null, $extra_info = null) {
        $data = $this->internet_data(
            $customer_number, $transaction_id, $bundle_id, $amount, $callback_url,
            $description, $payer_name, $extra_info);
        return $this->call('purchase_telesol_bundle/', $data);
    }

    public function telesol_bundles() {
        return $this->call('get_telesol_bundles/', []);
    }

    public function ecg_pay(
        $customer_number, $transaction_id, $amount, $callback_url,
        $description = null, $payer_name = null, $extra_info = null) {
        $data = [
            'customer_number' => $customer_number,
            'transaction_id' => $transaction_id,
            'amount' => $amount,
            'callback_url' => $callback_url
        ];
        $opt_data = [
            'description' => $description,
            'payer_name' => $payer_name,
            'extra_info' => $extra_info
        ];
        $this->add_optional_data($data, $opt_data);
        return $this->call('ecg_pay_bill/', $data);
    }

    public function gwcl_lookup($customer_number, $account_number, $transaction_id) {
        $data = [
            'customer_number' => Util::number233Format($customer_number),
            'account_number' => $account_number,
            'transaction_id' => $transaction_id
        ];
        return $this->call('gwcl_customer_lookup/', $data);
    }

    public function gwcl_pay($gwcl_transaction_id, $amount, $callback_url, $description = null) {
        $data = [
            'transaction_id' => $gwcl_transaction_id,
            'amount' => $amount,
            'callback_url' => $callback_url,
            'description' => $description
        ];
        return $this->call('gwcl_pay_bill/', $data);
    }
}
