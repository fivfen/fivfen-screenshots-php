<?php
include_once 'Fivfen.php';

use FivFen\Fivfen;

assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 1);
assert_options(ASSERT_QUIET_EVAL, 1);

define('API_HOST', 'fivfen.com');

/*
 * php TestFivfen.php
 * */

testUrlEncoding();
testFormat();
testSimple();
testKitchenSink();


function testUrlEncoding()
{
  $fivfen = Fivfen::fromCredentials('API_KEY', 'API_SECRET');
  assertEqual(
    "~!%40%23%24%25%5E%26*()%7B%7D%5B%5D%3D%3A%2F%2C%3B%3F%2B'%22%5C",
    $fivfen->encodeURIComponent('~!@#$%^&*(){}[]=:/,;?+\'"\\')
  );
}

function testFormat()
{
  $fivfen = Fivfen::fromCredentials('API_KEY', 'API_SECRET');
  $options['format'] = 'jpg';
  $options['url'] = 'example.com';
  assertEqual(
    "https://" . API_HOST . "/api?v=v1&key=API_KEY&sec=da2dc2d51636e61b45d5f3af94884756cd166767&format=jpg&url=example.com",
    $fivfen->generateUrl($options)
  );
}

function testSimple()
{
  $fivfen = Fivfen::fromCredentials('API_KEY', 'API_SECRET');
  $options['url'] = 'example.com';
  assertEqual(
    "https://" . API_HOST . "/api?v=v1&key=API_KEY&sec=b1b9b4362a5044ff18718d4d9a961044ed0cc815&url=example.com",
    $fivfen->generateUrl($options)
  );
}

function testKitchenSink()
{
  $fivfen = Fivfen::fromCredentials('API_KEY', 'API_SECRET');
  $options['format'] = 'png';
  $options['url'] = 'https://app_staging.example.com/misc/template_preview.php?dsfdsfsdf&acc=79&cb=ba86b4c1&regions=%5B%7B%22id%22%3A%22dsfds%22%2C%22data%22%3A%7B%22html%22%3A%22It%20works!%22%7D%2C%22type%22%3A%22html%22%7D%5D&state=published&tid=7&sig=a642316f7e0ac9d783c30ef30a89bed3204252000319a2789851bc3de65ea216';
  $options['delay'] = 5000;
  $options['selector'] = '#trynow';
  $options['full_page'] = true;
  $options['width'] = 1280;
  $options['height'] = '1024';
  $options['cookie'] = ['ckplns=1', 'foo=bar'];
  $options['user_agent'] = 'Mozilla/5.0 (iPhone; CPU iPhone OS 10_0 like Mac OS X) AppleWebKit/602.1.32 (KHTML, like Gecko) Version/10.0 Mobile/14A5261v Safari/602.1';
  $options['retina'] = 'true';
  $options['thumb_width'] = '400';
  $options['crop_width'] = 500;
  $options['ttl'] = '604800';
  $options['force'] = true;
  $options['wait_for'] = '.someel';
  $options['click'] = '#tab-specs-trigger';
  $options['hover'] = 'a[href="https://google.com"]';
  $options['bg_color'] = '#bbbddd';
  $options['highlight'] = 'trump|inauguration';
  $options['highlightbg'] = '#11cc77';
  $options['highlightfg'] = 'green';
  $options['hide_selector'] = '.modal-backdrop, #email-roadblock-topographic-modal';
  $options['flash'] = 'true';
  $options['timeout'] = 40000;
  $options['s3_path'] = '/path/to/image with space';
  $options['use_s3'] = 'true';

  assertEqual(
    "https://" . API_HOST . "/api?v=v1&key=API_KEY&sec=d2a7084dd55f71069acfa254b4e897a0b2237ac9&format=png&url=https%3A%2F%2Fapp_staging.example.com%2Fmisc%2Ftemplate_preview.php%3Fdsfdsfsdf%26acc%3D79%26cb%3Dba86b4c1%26regions%3D%255B%257B%2522id%2522%253A%2522dsfds%2522%252C%2522data%2522%253A%257B%2522html%2522%253A%2522It%2520works!%2522%257D%252C%2522type%2522%253A%2522html%2522%257D%255D%26state%3Dpublished%26tid%3D7%26sig%3Da642316f7e0ac9d783c30ef30a89bed3204252000319a2789851bc3de65ea216&delay=5000&selector=%23trynow&full_page=true&width=1280&height=1024&cookie=ckplns%3D1&cookie=foo%3Dbar&user_agent=Mozilla%2F5.0%20(iPhone%3B%20CPU%20iPhone%20OS%2010_0%20like%20Mac%20OS%20X)%20AppleWebKit%2F602.1.32%20(KHTML%2C%20like%20Gecko)%20Version%2F10.0%20Mobile%2F14A5261v%20Safari%2F602.1&retina=true&thumb_width=400&crop_width=500&ttl=604800&force=true&wait_for=.someel&click=%23tab-specs-trigger&hover=a%5Bhref%3D%22https%3A%2F%2Fgoogle.com%22%5D&bg_color=%23bbbddd&highlight=trump%7Cinauguration&highlightbg=%2311cc77&highlightfg=green&hide_selector=.modal-backdrop%2C%20%23email-roadblock-topographic-modal&flash=true&timeout=40000&s3_path=%2Fpath%2Fto%2Fimage%20with%20space&use_s3=true",
    $fivfen->generateUrl($options)
  );
}

function assertEqual($v1, $v2, $tip = '')
{
  if ($v1 != $v2) {
    $_tip = 'assert fail,';
    if ($tip != '') {
      $_tip .= ',' . $tip;
    }
    $_tip .= $v1 . ' != ' . $v2 . "\r\n";
    print($_tip);
  } else {
    print('assert success' . "\r\n");
  }
}

