<?php
/**
 * Created by PhpStorm.
 * User: kristina
 * Date: 5/6/18
 * Time: 1:54 PM
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MainController extends Controller {

    /**
     * @Route("/blog/{slug}", name="blog_show")
     */
    public function show($slug) {

        return $this->render('blog/main.html.twig', array('slug' => $slug));
    }
}
