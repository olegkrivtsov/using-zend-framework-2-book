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
    public function sendMail($sender, $recipient, $subject, $text) {

        $result = false;
        try {
        
            // Create E-mail message
            $mail = new Mail\Message();
            $mail->setBody($text);
            $mail->setFrom($sender);
            $mail->addTo($recipient);
            $mail->setSubject($subject);

            // Send E-mail message
            $transport = new Mail\Transport\Sendmail('-f'.$sender);
            $transport->send($mail);
            $result = true;
        } catch(\Exception $e) {
            $result = false;
        }
        
        return $result;
    }
};