<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class BlogController extends Controller
{

    /**
         * @Route("/blog/{page}", name="blog_list", requirements={"page": "\d+"})
     */
    public function blogListAction($page = 1)
    {
        $per_page = 10;
        $offset = $page * $per_page - $per_page;

        $repo = $this->getDoctrine()
            ->getRepository('AppBundle:Post');
        $posts = $repo->findBy([], ['createdOn' => 'DESC'], $per_page, $offset);

        if(!$posts) {
            throw new NotFoundHttpException();
        }

        $qb = $repo->createQueryBuilder('c');
        $count = $qb->select('count(c.id)')->getQuery()->getSingleScalarResult();
        $pages = floor(--$count/$per_page)+1;

        return $this->render('default/blogs.html.twig', [
            'posts' => $posts,
            'pages' => $pages,
            'page' => $page,
        ]);
    }

    /**
     * @Route("/blog/{slug}", name="blog_view", requirements={"slug": "[a-z_\-]+"})
     */
    public function blogViewAction($slug)
    {
        $post = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->findOneBy(['slug' => $slug]);

        if(!$post) {
            throw new NotFoundHttpException();
        }

        return $this->render('default/blog.html.twig', [
            'post' => $post
        ]);
    }


}