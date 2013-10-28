<?php

namespace Application\Service;

use Zend\Mail;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;

/**
 * This class is used to deliver an E-mail message to recipient.
 */
class MailSender {
  
    /**
     * Sends the mail message.
     * @param string $sender Sender's E-mail address.
     * @param string $recipient Recipient's E-mail address.
     * @param string $subject Subject of the message.
     * @param string $text Message body.
     * @return boolean
     */
    public function sendMail($sender, $recipient, $subject, $text) {

        $result = false;
        try {
        
            // Create E-mail message
            $mail = new Message();            
            $mail->setFrom($sender);
            $mail->addTo($recipient);
            $mail->setSubject($subject);
            $mail->setBody($text);

            // Send E-mail message
            $transport = new Sendmail('-f'.$sender);
            $transport->send($mail);
            $result = true;
        } catch(\Exception $e) {
            $result = false;
        }
        
        // Return status 
        return $result;
    }
}