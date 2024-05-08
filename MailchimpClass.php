<?php

class Mailchimp {

  private $debug = false;

  private $api_key = MAILCHIMP_API_KEY;

  private $list_id = MAILCHIMP_LIST_ID;

  public $status;

  // La GET verifica la POST inserisce
  public $method;

  public $messages = [
    'GET' => [
      200 => [
        'it' => 'Questa email è già iscritta alla nostra newsletter',
        'en' => 'This email is already subscribed to our newsletter'
      ],
      400 => [
        'it' => 'Risorsa non valida',
        'en' => 'Invalid resource'
      ],
      401 => [
        'it' => 'La chiave API non è valida o è disabilitata',
        'en' => 'The API key is invalid or it is disabled'
      ],
      403 => [
        'it' => 'Account disabilitato',
        'en' => 'Account disabled'
      ],
      404 => [
        'it' => 'Email pronta per essere iscritta', // title: 'La risorsa richiesta non è stata trovata'
        'en' => 'Email ready to be subscribed', // title: 'The requested resource could not be found'
      ],
    ],

    'POST' => [
      400 => [
        'it' => 'Qualcosa è andato storto, si prega di riporvare più tardi',
        'en' => 'Something went wrong, please check back later',
      ],
      200 => [
        'it' => 'Grazie per esserti iscritto alla newsletter',
        'en' => 'Thank you for your newsletter subscription',
      ],
    ],

    '_GENERAL_' => [
      400 => [
        'it' => 'Qualcosa è andato storto, si prega di riporvare più tardi',
        'en' => 'Something went wrong, please check back later',
      ],
      405 => [
        'it' => 'La richiesta non è consentita',
        'en' => 'The requested not allowed'
      ],
      429 => [
        'it' => 'Limite di 10 connessioni simultanee. L\'API Marketing imposta un limite di 10 richieste di elaborazione simultanea',
        'en' => 'Limit of 10 simultaneous connections.The Marketing API sets a limit of 10 simultaneously processing requests'
      ],
      500 => [
        'it' => 'Si è verificato un errore interno profondo durante l\'elaborazione della richiesta',
        'en' => 'A deep, internal error has occurred during the processing of your request',
      ]
    ]
   ];

  public $curl = [];

  private function successful(){
    return $this->status == 200;
  }

  public function failed() {
    return $this->status >= 400 && $this->status < 600;
  }

  private function dataCenter(){
    return substr( $this->api_key, strpos($this->api_key,'-')+1 );
  }

  private function md5Email($email){
    return md5( strtolower($email) );
  }

  /*
    return true if email is already registered
  */
  public function verifyUser($email){

    $this->method = 'GET';
    $mch_check = curl_init();
    curl_setopt($mch_check, CURLOPT_URL, 'https://' . $this->dataCenter() . '.api.mailchimp.com/3.0/lists/' . $this->list_id . '/members/' . $this->md5Email($email) );
    curl_setopt($mch_check, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic ' . base64_encode('user:' . $this->api_key) ) );
    curl_setopt($mch_check, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($mch_check, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($mch_check, CURLOPT_TIMEOUT, 10);
    curl_setopt($mch_check, CURLOPT_POST, true);
    curl_setopt($mch_check, CURLOPT_SSL_VERIFYPEER, false);

    $check = curl_exec($mch_check);
    $httpcode = curl_getinfo( $mch_check, CURLINFO_HTTP_CODE );

    $this->status = $httpcode;

    if ($this->debug)
      $this->curl[] = ['exec' => $check, 'info' => curl_getinfo( $mch_check )];

    return $this->successful();

  }

  /*
    return true if user is correctly registered
  */
  public function subscribeUser($user){

    if ($this->verifyUser($user['email'])) {
      return;
    }

    $this->method = 'POST';

    $data = array(
      'apikey'        => $this->api_key,
      'email_address' => $user['email'],
      'status'        => 'subscribed',
      'merge_fields'  =>  [
        'FNAME' => $user['fname'],
        'LNAME' => $user['lname']
        ]
    );

    $mch_api = curl_init();
    curl_setopt($mch_api, CURLOPT_URL, 'https://' . $this->dataCenter() . '.api.mailchimp.com/3.0/lists/' . $this->list_id . '/members' );
    curl_setopt($mch_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:' . $this->api_key )));
    curl_setopt($mch_api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($mch_api, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($mch_api, CURLOPT_TIMEOUT, 10);
    curl_setopt($mch_api, CURLOPT_POST, true);
    curl_setopt($mch_api, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($mch_api, CURLOPT_POSTFIELDS, json_encode($data) );

    $result = curl_exec($mch_api);
    $httpcode = curl_getinfo( $mch_api, CURLINFO_HTTP_CODE );

    $this->status = $httpcode;

    if ($this->debug)
      $this->curl[] = ['exec' => $result, 'info' => curl_getinfo( $mch_api )];

    return $this->successful();

  }

  public function getMessages() {
    if ($this->method && $this->status) {
      if (isset($this->messages[$this->method][$this->status])) {
        return $this->messages[$this->method][$this->status];
      } else if(isset($this->messages['_GENERAL_'][$this->status])) {
        return $this->messages['_GENERAL_'][$this->status];
      } else {
        return $this->messages['_GENERAL_'][400];
      }
    }
    return ['it' => '', 'en' => ''];
  }

  public function getArray() {
    return [
      'message' => $this->getMessages(),
      'status' => $this->status,
      'method' => $this->method,
      'curl'   => $this->debug ? $this->curl : [],
     ];
  }

} //  end of class
