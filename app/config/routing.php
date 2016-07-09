<?php
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();
$collection->add('blog_test', new Route('/blog/test', array(
    '_controller' => 'AppBundle:Blog:test',
)));

return $collection;