<?php
class Mailin
{
    public $api_key;
    public $base_url;
    public $timeout;
    public $curl_opts = array();
    public function __construct($base_url, $api_key, $timeout='')
    {
        if (!function_exists('curl_init')) {
            throw new \Exception('Mailin requires CURL module');
        }
        $this->base_url = $base_url;
        $this->api_key = $api_key;
        $this->timeout = $timeout;
    }
    private function do_request($resource, $method, $input)
    {
        $called_url = $this->base_url."/".$resource;
        $ch = curl_init($called_url);
        $auth_header = 'api-key:'.$this->api_key;
        $content_header = "Content-Type:application/json";
        $timeout = ($this->timeout!='')?($this->timeout):30000; //default timeout: 30 secs
        if ($timeout!='' && ($timeout <= 0 || $timeout > 60000)) {
            throw new \Exception('value not allowed for timeout');
        }
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows only over-ride
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($auth_header,$content_header));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $input);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new \RuntimeException('cURL error: ' . curl_error($ch));
        }
        if (!is_string($data) || !strlen($data)) {
            throw new \RuntimeException('Request Failed');
        }
        curl_close($ch);
        return json_decode($data, true);
    }
    public function post($resource, $input)
    {
        return $this->do_request($resource, "POST", $input);
    }
    public function send_email($data)
    {
        return $this->post("email", json_encode($data));
    }
}