<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Application
 *
 * @ORM\Table(name="application")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\ApplicationRepository")
 https://openclassrooms.com/courses/developpez-votre-site-web-avec-le-framework-symfony/les-relations-entre-entites-avec-doctrine2-1
@ORM\HasLifecycleCallbacks() */
class Application
{
      /**
   * @ORM\ManyToOne(targetEntity="OC\PlatformBundle\Entity\Advert", inversedBy="applications")
   * @ORM\JoinColumn(nullable=false)
   */
  private $advert;
  // onDelete="SET NULL"
  
  
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    
  /**

   * @ORM\Column(name="author", type="string", length=255)

   */

  private $author;


  /**

   * @ORM\Column(name="content", type="text")

   */

  private $content;


  /**

   * @ORM\Column(name="date", type="datetime")

   */

  private $date;

  

  public function __construct()

  {

    $this->date = new \Datetime();

  }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Application
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Application
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Application
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set advert
     *
     * @param \OC\PlatformBundle\Entity\Advert $advert
     *
     * @return Application
     */
    public function setAdvert(\OC\PlatformBundle\Entity\Advert $advert)
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * Get advert
     *
     * @return \OC\PlatformBundle\Entity\Advert
     */
    public function getAdvert()
    {
        return $this->advert;
    }
    
    
    
      /**

   * @ORM\PrePersist

   */

  public function increase()

  {

    $this->getAdvert()->increaseApplication();

  }


  /**

   * @ORM\PreRemove

   */

  public function decrease()

  {

    $this->getAdvert()->decreaseApplication();

  }

/**
 * @ORM\Column( type="string", nullable=true)
 */
  private $email2;

    /**
     * Set email2
     *
     * @param string $email2
     *
     * @return Application
     */
    public function setEmail2($email2)
    {
        $this->email2 = $email2;

        return $this;
    }

    /**
     * Get email2
     *
     * @return string
     */
    public function getEmail2()
    {
        return $this->email2;
    }
}
