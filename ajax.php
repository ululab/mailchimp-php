<?php

add_action( 'wp_ajax_RequestGeneralPostMail', 'RequestGeneralPostMail' );
add_action( 'wp_ajax_nopriv_RequestGeneralPostMail', 'RequestGeneralPostMail' );

function RequestGeneralPostMail(){

  deny_access();

  if( !wp_verify_nonce( $_POST['wp_nonce'], NONCE_KEY ) ) :
    wp_send_json(['message' => ['it' => 'Sessione scaduta, ricarica la pagina', 'en' => 'Session expired, reload the page']], 400);
  endif;

  require get_template_directory() . '/assets/php/MailchimpClass.php';
  require get_template_directory() . '/assets/php/MailFormClass.php';

  switch ($_POST['type_form']) {
    case 'newsletter':
      $mailchimp = new Mailchimp();
      $mailchimp->subscribeUser($_POST['dataUser']);
      wp_send_json( $mailchimp->getArray(), $mailchimp->status);
      break;

    case 'single':
    case 'footer':

      $mailForm = new MailForm();


      $mailForm->setTo( get_field('email_form', 'option') ); // bussness
      $mailForm->setReplyTo($_POST['dataUser']['email']); // customer
      $mailForm->setFrom(['Sito-Cliente', 'noreply@sito-cliente.it']); // server
      $mailForm->setTemplate( file_get_contents( get_template_directory() . '/assets/html/preventivo.html'));
      $mailForm->setSubject('Nuova richiesta dal sito idraulicatrento.it');
      $meta = [
        '{{Nome}}' => $_POST['dataUser']['name_1'],
        '{{Cognome}}' =>$_POST['dataUser']['name_2'],
        '{{Email}}' => $_POST['dataUser']['email'],
        '{{Oggetto}}' => $_POST['dataUser']['object_message'],
        '{{Categoria}}' => $_POST['dataUser']['category'],
        '{{Testo_Messaggio}}' => $_POST['dataUser']['message'],
        '{{Link_Prodotto}}' => $_POST['dataUser']['link_page']
      ];
      $mailForm->setMeta($meta);
      $mailForm->send();

      wp_send_json(['message' => $mailForm->message, 'data' => $mailForm], $mailForm->status);

      default:
        wp_send_json(['message' => ['it' => 'Richiesta non trovata']], 200);
      break;
  }





	wp_die();

}
