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
        $per_page = 12;
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

        return $this->render('blog/list.html.twig', [
            'posts' => $posts,
            'pages' => $pages,
            'page' => $page,
        ]);
    }

    /**
     * @Route("/blog/{slug}", name="blog_view", requirements={"slug": "[a-z0-9_\-]+"})
     */
    public function blogViewAction($slug)
    {
        $post = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->findOneBy(['slug' => $slug]);

        if(!$post) {
            throw new NotFoundHttpException();
        }

        return $this->render('blog/view.html.twig', [
            'post' => $post
        ]);
    }


    /**
     * @Route("/blog/category/{tag}/{page}", name="blog_taxonomy", requirements={"page": "\d+"})
     */
    public function blogListTaxonomyAction($tag, $page = 1)
    {
        $title = 'Category: '.$tag;
        
        $per_page = 12;
        $offset = $page * $per_page - $per_page;

        $repo = $this->getDoctrine()
            ->getRepository('AppBundle:Post');
        $qb = $repo->createQueryBuilder('c');
        $posts = $qb->select('c')
            ->where('c.taxonomy LIKE :tag')
            ->setParameter('tag', '%'.$tag.'%')
            ->getQuery()->getResult();

        if(!$posts) {
            throw new NotFoundHttpException();
        }

        $qb = $repo->createQueryBuilder('c');
        $count = $qb->select('count(c.id)')->where('c.taxonomy LIKE :tag')
            ->setParameter('tag', '%'.$tag.'%')
            ->getQuery()
            ->getSingleScalarResult();
        $pages = floor(--$count/$per_page)+1;

        return $this->render('blog/list.html.twig', [
            'title' => $title,
            'posts' => $posts,
            'pages' => $pages,
            'page' => $page,
        ]);
    }

}