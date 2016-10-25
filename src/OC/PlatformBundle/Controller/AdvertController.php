<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace OC\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use OC\PlatformBundle\Entity\Advert;
use OC\PlatformBundle\Entity\Image;
use OC\PlatformBundle\Entity\Application;
use OC\PlatformBundle\Entity\AdvertSkill;
use Symfony\Component\HttpFoundation\Response;

// use Symfony\Component\Validator\Constraints\DateTime;
//use Symfony\Component\Validator\Constraints\Date;


class AdvertController extends Controller {

    public function indexAction() {
        // Notre liste d'annonce en dur

        $listAdverts = array(
            array(
                'title' => 'Recherche développpeur Symfony',
                'id' => 1,
                'author' => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
                'date' => new \Datetime()),
            array(
                'title' => 'Mission de webmaster',
                'id' => 2,
                'author' => 'Hugo',
                'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'date' => new \Datetime()),
            array(
                'title' => 'Offre de stage webdesigner',
                'id' => 3,
                'author' => 'Mathieu',
                'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
                'date' => new \Datetime())
        );




        return $this->render('OCPlatformBundle:Advert:index.html.twig', array(
                    'listAdverts' => $listAdverts));
    }

    public function viewAction($id) {
        $em = $this->getDoctrine()->getManager();


        // On récupère l'annonce $id

        $advert = $em
                ->getRepository('OCPlatformBundle:Advert')
                ->find($id)

        ;


        if (null === $advert) {

            throw new NotFoundHttpException("L'annonce d'id " . $id . " n'existe pas.");
        }


        // On avait déjà récupéré la liste des candidatures

        $listApplications = $em
                ->getRepository('OCPlatformBundle:Application')
                ->findBy(array('advert' => $advert))

        ;


        // On récupère maintenant la liste des AdvertSkill

        $listAdvertSkills = $em
                ->getRepository('OCPlatformBundle:AdvertSkill')
                ->findBy(array('advert' => $advert))

        ;


        return $this->render('OCPlatformBundle:Advert:view.html.twig', array(
                    'advert' => $advert,
                    'listApplications' => $listApplications,
                    'listAdvertSkills' => $listAdvertSkills
        ));
    }

    /** http://localhost/OpenclassroomsSYMFONY/symfony2Doctrine/web/app_dev.php/platform/add platform++++ */
    public function addAction(Request $request) {
        // On récupère l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Création de l'entité Advert
        $advert = new Advert();
        $advert->setTitle('Recherche développeur Symfony.');
        $advert->setAuthor('Alexandre');
        $advert->setContent("Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…");
        // $advert->sete
        //moi
        $cat = new \OC\PlatformBundle\Entity\Category;
        $cat->setName("Développeur");
        $advert->addCategory($cat);
        $advert->setEmail("mouezapeter@gmail.com");


        $advert2 = new Advert();
        $advert2->setTitle('search développeur Symfony. intégrateur');
        $advert2->setAuthor('Alexandre');
        $advert2->setContent("search  développeur-intégrateur Symfony débutant sur Lyon. Blabla…");
        //moi
        $cat = new \OC\PlatformBundle\Entity\Category;
        $cat->setName("Développeur");
        $cat2 = new \OC\PlatformBundle\Entity\Category;
        $cat2->setName("Intégrateur");
        $advert2->addCategory($cat);
        $advert2->addCategory($cat2);
        $advert2->setEmail("mouezapeter@gmail.com");


        $app1 = new Application();
        $app1->setContent("Je suis debutant");
        $app1->setAuthor("Peter");
        $date1 = new \DateTime();
        $date1->setDate(2016, 01, 01);
        $app1->setDate($date1);
        $app1->setAdvert($advert);

        $app2 = new Application();
        $app2->setContent("Je suis expert");
        $app2->setAuthor("Peter");
        $date2 = new \DateTime();
        $date1->setDate(2016, 02, 01);
        $app2->setDate($date2);
        $app2->setAdvert($advert);


        $app3 = new Application();
        $app3->setContent("Je suis neo");
        $app3->setAuthor("Peter");
        $date3 = new \DateTime();
        $date3->setDate(2016, 01, 31);
        $app3->setDate($date3);
        $app3->setAdvert($advert2);

        $app4 = new Application();
        $app4->setContent("Je suis junior");
        $app4->setAuthor("Pit");
        $date4 = new \DateTime();
        $date4->setDate(2016, 12, 01); //http://stackoverflow.com/questions/32607641/set-datetime-and-time-in-symfony2-from-string
        $app4->setDate($date4);
        $app4->setAdvert($advert2);



// On récupère toutes les compétences possibles
        $listSkills = $em->getRepository('OCPlatformBundle:Skill')->findAll();

        // Pour chaque compétence
        foreach ($listSkills as $skill) {
            /*             * fixtures remplissage automatique https://openclassrooms.com/courses/developpez-votre-site-web-avec-le-framework-symfony/les-relations-entre-entites-avec-doctrine2-1 */
            // On crée une nouvelle « relation entre 1 annonce et 1 compétence »
            $advertSkill = new AdvertSkill();

            // On la lie à l'annonce, qui est ici toujours la même
            $advertSkill->setAdvert($advert);
            // On la lie à la compétence, qui change ici dans la boucle foreach
            $advertSkill->setSkill($skill);

            // Arbitrairement, on dit que chaque compétence est requise au niveau 'Expert'
            $advertSkill->setLevel('Expert');

            // Et bien sûr, on persiste cette entité de relation, propriétaire des deux autres relations
            $em->persist($advertSkill);
        }

        // Doctrine ne connait pas encore l'entité $advert. Si vous n'avez pas défini la relation AdvertSkill
        // avec un cascade persist (ce qui est le cas si vous avez utilisé mon code), alors on doit persister $advert
        $em->persist($advert);
        $em->persist($advert2);
        $em->persist($app1);
        $em->persist($app2);
        $em->persist($app3);
        $em->persist($app4);

        // On déclenche l'enregistrement
        $em->flush();

        // … reste de la méthode
        // … reste de la méthode
        // Reste de la méthode qu'on avait déjà écrit

        if ($request->isMethod('POST')) {

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');


            // Puis on redirige vers la page de visualisation de cettte annonce

            return $this->redirectToRoute('oc_platform_view', array('id' => $advert->getId()));
        }


        // Si on n'est pas en POST, alors on affiche le formulaire

        return $this->render('OCPlatformBundle:Advert:add.html.twig');
    }

    public function editAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();


        // On récupère l'annonce $id
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);
        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id " . $id . " n'existe pas.");
        }

        // La méthode findAll retourne toutes les catégories de la base de données
        $listCategories = $em->getRepository('OCPlatformBundle:Category')->findAll();
        // On boucle sur les catégories pour les lier à l'annonce
        foreach ($listCategories as $category) {
            $advert->addCategory($category);
        }


        // Pour persister le changement dans la relation, il faut persister l'entité propriétaire
        // Ici, Advert est le propriétaire, donc inutile de la persister car on l'a récupérée depuis Doctrine
        // Étape 2 : On déclenche l'enregistrement
        $em->flush();

        // … reste de la méthode
//        $advert = array(
//            'title' => 'Recherche développpeur Symfony',
//            'id' => $id,
//            'author' => 'Alexandre',
//            'content' => 'Nous recherchons un développeur Symfony débutant sur Lyon. Blabla…',
//            'date' => new \Datetime()
//        );


        return $this->render('OCPlatformBundle:Advert:edit.html.twig', array(
                    'advert' => $advert
        ));
    }

    public function deleteAction($id) {

        // Ici, on récupérera l'annonce correspondant à $id
        // Ici, on gérera la suppression de l'annonce en question

        $em = $this->getDoctrine()->getManager();


        // On récupère l'annonce $id

        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);


        if (null === $advert) {

            throw new NotFoundHttpException("L'annonce d'id " . $id . " n'existe pas.");
        }


        // On boucle sur les catégories de l'annonce pour les supprimer

        foreach ($advert->getCategories() as $category) {

            $advert->removeCategory($category);
        }


        // Pour persister le changement dans la relation, il faut persister l'entité propriétaire
        // Ici, Advert est le propriétaire, donc inutile de la persister car on l'a récupérée depuis Doctrine
        // On déclenche la modification

        $em->flush();

        return $this->render('OCPlatformBundle:Advert:delete.html.twig');
    }

    public function menuAction($limit) {

        // On fixe en dur une liste ici, bien entendu par la suite
        // on la récupérera depuis la BDD !

        $listAdverts = array(
            array('id' => 2, 'title' => 'Recherche développeur Symfony'),
            array('id' => 5, 'title' => 'Mission de webmaster'),
            array('id' => 9, 'title' => 'Offre de stage webdesigner')
        );

        return $this->render('OCPlatformBundle:Advert:menu.html.twig', array(
                    // Tout l'intérêt est ici : le contrôleur passe
                    // les variables nécessaires au template !
                    'listAdverts' => $listAdverts
        ));
    }

    //https://openclassrooms.com/courses/developpez-votre-site-web-avec-le-framework-symfony/les-relations-entre-entites-avec-doctrine2-1
    // Dans un contrôleur, celui que vous voulez
    public function editImageAction($advertId) {

        $em = $this->getDoctrine()->getManager();


        // On récupère l'annonce

        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($advertId);


        // On modifie l'URL de l'image par exemple

        $advert->getImage()->setUrl('test.png');


        // On n'a pas besoin de persister l'annonce ni l'image.
        // Rappelez-vous, ces entités sont automatiquement persistées car
        // on les a récupérées depuis Doctrine lui-même
        // On déclenche la modification

        $em->flush();


        return new Response('OK');
    }

    // Depuis un contrôleur
    public function listAction() {

        $listAdverts = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('OCPlatformBundle:Advert')
                ->getAdvertWithApplications()

        ;


        foreach ($listAdverts as $advert) {

            // Ne déclenche pas de requête : les candidatures sont déjà chargées !
            // Vous pourriez faire une boucle dessus pour les afficher toutes

            $advert->getApplications();
        }
    }

    public function exo1Action() {
        //pas besoin de flush car des donnees sont deja ds bdd par /addAction et remplisseur auto
        $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('OCPlatformBundle:Advert');
        // $objectCategoriesBelongs = $repository->getAdvertWithCategories(array('Développeur', 'Intégrateur'));
        //     $objectCategoriesBelongs = $repository->getAdvertWithCategories(array('Développeur'));
        $objectCategoriesBelongs = $repository->getAdvertWithCategories(array('Développeur', 'Intégrateur'));
        echo 'lbl589';
        $m = 33;
//        $contenu = $this->renderView('OCPlatformBundle:Advert:exo1.html.twig', array(
//            'objectCategoriesBelongs' => $objectCategoriesBelongs,
//            'm' => $m));
        return $this->render('OCPlatformBundle:Advert:exo1.html.twig', array(
                    'objectCategoriesBelongs' => $objectCategoriesBelongs,
                    'm' => $m));
    }

    public function exo2Action() {
        $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('OCPlatformBundle:Application');
        $applicationsLimited = $repository->getApplicationsWithAdvert(2);
        return $this->render('OCPlatformBundle:Advert:exo2.html.twig', array(
                    'applicationsLimited' => $applicationsLimited));
    }

    /*     * pr voir si exo1 qui ne marche pas car vide vient de Advert non rempli=initialisé */

    public function poubaddAction() {
        $em = $this
                ->getDoctrine()
                ->getManager();
//        $em->remove('Poub'); //https://openclassrooms.com/courses/developpez-votre-site-web-avec-le-framework-symfony/manipuler-ses-entites-avec-doctrine2-1
//        $em->flush();

        $poub1 = new \OC\PlatformBundle\Entity\Poub;
        $poub1->setMem(99);
        $getmem = $poub1->getMem();

        $poub2 = new \OC\PlatformBundle\Entity\Poub;
        $poub2->setMem(100099);


        $em->persist($poub1);
        $em->persist($poub2);
        $em->flush(); //https://openclassrooms.com/courses/developpez-votre-site-web-avec-le-framework-symfony/manipuler-ses-entites-avec-doctrine2-1
        // $repository->getAdvertWithCategories(array('Développeur', 'Intégrateur'));
        $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('OCPlatformBundle:Poub');
        $mems = $repository->getMemsMoi();
        $exists = isset($mems);
        $m = 33;
        return $this->render('OCPlatformBundle:Advert:poub.html.twig', array(
                    'mems' => $mems,
                    'm' => $m,
                    'getmem' => $getmem,
                    'exists' => $exists));
    }

    public function testAction() {

        $advert = new Advert();

        $advert->setTitle("Recherche développeur !");
        $advert->setAuthor("Sogeti"); //moi

        $advert->setContent("notre societe...vous bac+5"); //moi
        $advert->setEmail("mouezapeter@gmail.com");

        $em = $this->getDoctrine()->getManager();

        $em->persist($advert);

        $em->flush(); // C'est à ce moment qu'est généré le slug


        return new Response('Slug généré : ' . $advert->getSlug());

        // Affiche « Slug généré : recherche-developpeur »
    }

}
