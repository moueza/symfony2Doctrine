<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OC\PlatformBundle\Antispam;

/**
 * Description of OCAntispam
 *
 * @author peter
 */
class OCAntispam {

    private $mailer;
    private $locale;
    private $minLength;

    /**typage**/
    public function __construct(\Swift_Mailer $mailer, $locale, $minLength) {

        $this->mailer = $mailer;

        $this->locale = $locale;

        $this->minLength = (int) $minLength;
    }

    /**

     * Vérifie si le texte est un spam ou non

     *

     * @param string $text

     * @return bool

     */
    public function isSpam($text) {

       // return strlen($text) < 50;
       return strlen($text) < $this->minLength;
       }

}
