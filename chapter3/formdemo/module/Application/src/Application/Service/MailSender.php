<?php

namespace Application\Service;

use Zend\Mail;

/**
 * This class is used to deliver an E-mail message to recipient.
 */
class MailSender {
  
    /**
     * Sends the mail message.
     * @param type $recipient
     * @param type $subject
     * @param type $text
     * @return boolean
     */
    public function sendMail($recipient, $subject, $text) {

        // Create E-mail message
        $mail = new Mail\Message();
        $mail->setBody('This is the text of the email.');
        $mail->setFrom('Freeaqingme@example.org', 'Sender\'s name');
        $mail->addTo('Matthew@example.com', 'Name o. recipient');
        $mail->setSubject('TestSubject');

        // Send E-mail message
        $transport = new Mail\Transport\Sendmail('-fno-reply@example.com');
        $transport->send($mail);
        
        return true;
    }
};
