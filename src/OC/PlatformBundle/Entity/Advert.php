<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Advert
 *
 * @ORM\Table(name="advert")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\AdvertRepository")
 @ORM\HasLifecycleCallbacks()*/
class Advert {
    /*     * **vient de fin https://openclassrooms.com/courses/developpez-votre-site-web-avec-le-framework-symfony/la-couche-metier-les-entites-1 */

   
    /**

     * @ORM\OneToMany(targetEntity="OC\PlatformBundle\Entity\Application", mappedBy="advert")

     */
    private $applications; // Notez le « s », une annonce est liée à plusieurs candidatures

    // … vos autres attributs

    public function __construct() {
        //https://openclassrooms.com/courses/developpez-votre-site-web-avec-le-framework-symfony/les-relations-entre-entites-avec-doctrine2-1
        $this->date = new \Datetime();
        $this->categories = new ArrayCollection();

        //https://openclassrooms.com/courses/developpez-votre-site-web-avec-le-framework-symfony/les-relations-entre-entites-avec-doctrine2-1
        $this->applications = new ArrayCollection();

        // ...
    }

    public function addApplication(Application $application) {

        $this->applications[] = $application;


        // On lie l'annonce à la candidature

        $application->setAdvert($this);


        return $this;
    }

    public function getApplications() {

        return $this->applications;
    }

    // Notez le singulier, on ajoute une seule catégorie à la fois

    public function addCategory(Category $category) {

        // Ici, on utilise l'ArrayCollection vraiment comme un tableau

        $this->categories[] = $category;
    }

    public function removeCategory(Category $category) {

        // Ici on utilise une méthode de l'ArrayCollection, pour supprimer la catégorie en argument

        $this->categories->removeElement($category);
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * 
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=255)
     */
    private $content;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Advert
     */
    public function setDate($date) {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Advert
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Advert
     */
    public function setAuthor($author) {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param text $content
     *
     * @return Advert
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return text
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = true;

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Advert
     */
    public function setPublished($published) {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished() {
        return $this->published;
    }

    /**
     * @ORM\OneToOne(targetEntity="OC\PlatformBundle\Entity\Image", cascade={"persist"})
      @ORM\JoinColumn(onDelete="SET NULL") */
    private $image;

//http://stackoverflow.com/questions/7241406/doctrine-2-deleting-row-contraint-fails
    /**
     * Set image
     *
     * @param \OC\PlatformBundle\Entity\Image $image
     *
     * @return Advert
     */
    public function setImage(\OC\PlatformBundle\Entity\Image $image = null) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \OC\PlatformBundle\Entity\Image
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * @ORM\ManyToMany(targetEntity="OC\PlatformBundle\Entity\Category", cascade={"persist"})
      @ORM\JoinTable(name="oc_advert_category")
     * https://openclassrooms.com/courses/developpez-votre-site-web-avec-le-framework-symfony/les-relations-entre-entites-avec-doctrine2-1 */
    private $categories;

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories() {
        return $this->categories;
    }

    public function removeApplication(Application $application) {

        $this->applications->removeElement($application);


        // Et si notre relation était facultative (nullable=true, ce qui n'est pas notre cas ici attention) :        
        // $application->setAdvert(null);
    }

   
/**
 * @ORM\Column(name="updated_at", type="datetime", nullable=true)
 */
private $updatedAt;

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Advert
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    
/**

 * @ORM\PreUpdate

 */
  public function updateDate()

  {

    $this->setUpdatedAt(new \Datetime());

  }
  
  
   /**

   * @ORM\Column(name="nb_applications", type="integer")

   */

  private $nbApplications = 0;


  public function increaseApplication()

  {

    $this->nbApplications++;

  }


  public function decreaseApplication()

  {

    $this->nbApplications--;

  }
  
  


    /**
     * Set nbApplications
     *
     * @param integer $nbApplications
     *
     * @return Advert
     */
    public function setNbApplications($nbApplications)
    {
        $this->nbApplications = $nbApplications;

        return $this;
    }

    /**
     * Get nbApplications
     *
     * @return integer
     */
    public function getNbApplications()
    {
        return $this->nbApplications;
    }

   /**
     @ORM\Column(name="email", type="string")*/
    private $email;
//https://openclassrooms.com/courses/developpez-votre-site-web-avec-le-framework-symfony/les-evenements-et-extensions-doctrine-1
    

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Advert
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
