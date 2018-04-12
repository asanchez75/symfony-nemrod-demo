<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }

    public function nemrodSimpleAction(Request $request)
    {
        $products = $this->container->get('rm')->getRepository('skos:Concept')->findAll();
        dump($products);
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));

    }
   public function nemrodQueryBuilderAction(Request $request)
    {
        $qb = $this->container->get('rm')->getRepository('skos:Concept')->getQueryBuilder();
        $qb->select('?s ?label')
           ->where('?s text:query (skos:prefLabel \'Arch*\' 25)')
           ->andWhere('?s skos:prefLabel ?label')
           ->andWhere('filter (lang(?label) = \'en\')');
        $result = $qb->getQuery()->execute();
        dump($result);
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));

    }

    public function nemrodFindByAction(Request $request)
    {
        $products = $this->container->get('rm')->getRepository('skos:Concept')->findBy(array('skos:prefLabel' => '"Architecture"@en'));;
        foreach ($products as $product) {
            dump($product);
        }
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));

    }

}
