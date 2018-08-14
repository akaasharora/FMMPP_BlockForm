<?php

namespace Drupal\dino_roar\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class RoarController
{
    public function roar()
    {
        //return new Response("ROOOOAAAAAAAR");
        $build = array(
            '#type' => 'markup',
            '#markup' => '<p>Success! Web Service information is currently being synchronized and should be available on ola.org shortly.</p>',
        );
        return $build;
    }

}