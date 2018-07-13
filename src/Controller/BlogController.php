<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends Controller 
{
	/**	
	 *  @Route("/blog/{page}/category", name="blog_list", requirements={"page"="\d+"})
	 */
	public function list($page, $category = 'Symfony') {

        return $this->render('blog/blog.html.twig', array(
            'page'=> $page,
            'category' => $category
        ));
	}

}