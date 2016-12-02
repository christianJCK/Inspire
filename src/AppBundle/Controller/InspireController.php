<?php
/**
 * Created by PhpStorm.
 * User: apprenti
 * Date: 02/12/16
 * Time: 22:40
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InspireController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:Inspire:index.html.twig');
    }
}