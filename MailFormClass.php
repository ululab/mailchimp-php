<?php

class MailForm {

  public $subject;

  public $template;

  public $from; // server/website

  public $to; // bussness

  public $reply_to; // customer

  public $headers = [
    'Content-type:text/html;charset=UTF-8',
    'MIME-Version: 1.0',
    'From: {NominativeFromMail} <{EmailFrom}>',
    'Reply-To: {NoReplay}',
    'X-Mailer: PHP/' . 'phpversion()',
  ];

  public $meta;

  public $content;

  public $is_send;

  public function getHeaders() {
    $headers = [
      'Content-type:text/html;charset=UTF-8',
      'MIME-Version: 1.0',
      'From: ' . $this->from[0] . '<' . $this->from[1] . '>',
      'Reply-To: ' . $this->reply_to,
      'X-Mailer: PHP/' . phpversion(),
    ];

    return implode(' \r\n', $headers);
  }

  public function getSubject()
  {
    return $this->subject;
  }

  public function setSubject($subject)
  {
    $this->subject = $subject;
  }

  public function setTo($to)
  {
    if(is_string($to))
      $to = explode(';', $to );

    $this->to = array_map('trim', $to);
  }

  public function getTo()
  {
    return  $this->to;
  }

  public function setReplyTo($replyTo)
  {
    $this->reply_to = $replyTo;
  }

  public function getReplyTo()
  {
    return  $this->reply_to;
  }

  public function setFrom($from)
  {
    $this->from = $from;
  }

  public function getFrom($from)
  {
    return $this->from;
  }

  public function setTemplate($template)
  {
    $this->template = $template;
  }

  public function getTemplate()
  {
    return $this->template;
  }

  public function setMessage($message)
  {
    $this->template = $message;
  }

  public function getMessage()
  {
    return $this->template;
  }

  public function setMeta($metaDataToReplaced)
  {
    $this->meta = [array_keys($metaDataToReplaced), array_values($metaDataToReplaced)];
  }

  public function getMeta()
  {
    return $this->meta;
  }

  public function prepareContent()
  {
    // Template della mail con meta data custum
    if ($this->meta) {
      // Associo ad ogni shortcode del meta del template mail una stringa hash univoca, da bcrypt di php
      // Esempio
      // {{metadata_1}} = {{$2y$10$2p3OL.j56SvanloyD4xp2.52BkUwjdGJNVAgLdpvK9f.14xof5CQ2}}
      $meta_shortcode_hash = [];
      foreach ($this->meta[0] as $key => $shortcode) {
        $meta_shortcode_hash[] = '{{' . password_hash($shortcode, PASSWORD_DEFAULT) . '}}';
      }
      $this->meta[2] = $meta_shortcode_hash;
      $template_with_hash = str_replace($this->meta[0], $meta_shortcode_hash, $this->template);
      $this->content = str_replace($meta_shortcode_hash, $this->meta[1], $template_with_hash);
    }
    else {
      // Template della mail statico
      $this->content = $this->template;
    }

    return $this->content;
  }

  public function getContent()
  {
    return $this->content;
  }

  public function send() {

    $this->prepareContent();

    $this->is_send = wp_mail( $this->getTo(), $this->getSubject(), $this->getContent(), $this->getHeaders() );

    if( $this->is_send ) {
      $this->message = [
        'it' => 'Grazie per averci contattato!',
        'en' => 'Thanks for contacting us!'
      ];
      $this->status = 200;
    }
    else {
      $this->message = [
        'it' => 'Si è verificato un errore durante l\'invio, per favore riprova più tardi',
        'en' => 'There was an error sending, please try again later'
      ];
      $this->status = 400;
    }

  }

}
