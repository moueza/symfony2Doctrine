<?php

namespace OC\PlatformBundle\Email;

use OC\PlatformBundle\Entity\Application;

class ApplicationMailer {

    /**

     * @var \Swift_Mailer

     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer) {

        $this->mailer = $mailer;
    }

    public function sendNewNotification(Application $application) {

        $message = new \Swift_Message(
                'Nouvelle candidature', 'Vous avez reçu une nouvelle candidature.'
        );

//TODO
//        $message
//                ->addTo($application->getAdvert()->getAuthor()) // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
//                ->addFrom('admin@votresite.com')

                   $message
                ->addTo($application->getAdvert()->getEmail()) // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
                ->addFrom('mouezapeter@gmail.com')

        ;


        $this->mailer->send($message);
    }

}
