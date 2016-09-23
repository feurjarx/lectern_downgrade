<?php

/**
 * Created by PhpStorm.
 * Date: 28.05.2016
 * Time: 22:42
 */
class Letter
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Swift_Message
     */
    private $message;

    /**
     * Letter constructor.
     */
    public function __construct()
    {
        $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
            ->setUsername('rabota.ivtib@gmail.com')
            ->setPassword('9037n6zx')
//            ->setUsername('yakoann03@gmail.com')
//            ->setPassword('Pm4h1nCkCZd4')
        ;


        $this->mailer = Swift_Mailer::newInstance($transport);

        $this->message = Swift_Message::newInstance();

        return $this;
    }

    /**
     * @param array $to
     * @return $this
     */
    public function setTo(array $to)
    {
        $this->message->setTo($to);
        return $this;
    }

    /**
     * @param $from
     * @param null $name
     * @return $this
     */
    public function setFrom($from, $name = null)
    {
        $this->message->setFrom($from, $name);
        return $this;
    }

    /**
     * @param $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->message->setSubject($subject);
        return $this;
    }

    /**
     * @param $body
     * @param $mime
     * @return $this
     */
    public function setBody($body, $mime = 'text/html')
    {
        $this->message->setBody($body, $mime);
        return $this;
    }

    /**
     * @return int
     */
    public function send()
    {
        return $this->mailer->send($this->message);
    }
}