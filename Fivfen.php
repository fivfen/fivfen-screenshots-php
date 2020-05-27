<?php

namespace FivFen;

class Fivfen
{
  private $api_key;
  private $api_secret;
  private $api_host;

  public function __construct($api_key, $api_secret, $api_host = 'fivfen.com')
  {
    $this->api_key = $api_key;
    $this->api_secret = $api_secret;
    $this->api_host = $api_host;
  }

  public static function fromCredentials($api_key, $api_secret, $api_host = 'fivfen.com')
  {
    return new self($api_key, $api_secret, $api_host);
  }

  public function generateUrl($options)
  {
    $_parts = [];
    foreach ($options as $key => $values) {
      $values = is_array($values) ? $values : [$values];
      foreach ($values as $value) {
        if (!empty($value)) {
          $encodedValue = $this->sanitizeValue($value);
          $_parts[] = "$key=$encodedValue";
        }
      }
    }
    $query_string = implode("&", $_parts);
    $TOKEN = hash_hmac("sha1", $query_string, $this->api_secret);
    return 'https://' . $this->api_host . '/api?v=v1&key=' . $this->api_key . '&sec=' . $TOKEN .'&'. $query_string;
  }

  private function sanitizeValue($val)
  {
    $type = gettype($val);
    if ($type == 'string') {
      return $this->encodeURIComponent($val);
    }
    return var_export($val, true);
  }

  public function encodeURIComponent2($val)
  {
    $result = rawurlencode($val);
    $result = str_replace('+', '%20', $result);
    $result = str_replace('%21', '!', $result);
    $result = str_replace('%2A', '*', $result);
    $result = str_replace('%27', '\'', $result);
    $result = str_replace('%28', '(', $result);
    $result = str_replace('%29', ')', $result);
    return $result;
  }

  public function encodeURIComponent($val)
  {
    $revert = array('%21' => '!', '%2A' => '*', '%27' => "'", '%28' => '(', '%29' => ')');
    return strtr(rawurlencode($val), $revert);
  }
}