<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class LuckyController extends Controller
{
    /**
     * @Route("/lucky/phpinfo")
     */
    public function phpinfoAction()
    {
        dump($translator->trans('Hello World'));
die();
        return $this->render(
            'lucky/phpinfo.html.twig',
            array('phpinfo' => phpinfo())
        );
    }

    /**
     * @Route("/lucky/hello/{name}", name="hello")
     */
    public function indexAction($name)
    {

        return new Response('<html><body>Hello '.$name.'!</body></html>');
    }

    /**
     * @Route("/api/lucky/number")
     */
    public function apiNumberAction()
    {
        $data = array(
            'lucky_number' => rand(0, 100),
        );

        // calls json_encode and sets the Content-Type header
        return new JsonResponse($data);
    }

    /**
     * @Route("/lucky/number/{count}")
     */
    public function numberAction($count)
    {
        return new Response(
            '<html><body>Lucky number: '.$count.'</body></html>'
        );
    }

    /**
     * @Route("/lucky/error/{count}")
     */
    public function errorAction($count)
    {
        //Page 404
        if ($count == "a") {
            throw $this->createNotFoundException('The product does not exist');
        } else if ($count == "b") { //Page 500
            throw new \Exception('Something went wrong!');
        }
        return new Response(
            '<html><body>Right</body></html>'
        );
    }

    /**
     * @Route("/lucky/arg")
     */
    public function argAction( Request $request)
    {
        $page = $request->query->get('page', 1);

        return new Response(
            '<html><body>page:'.$page.'</body></html>'
        );
    }

    /**
     * @Route("/lucky/session/{ses}")
     */
    public function sessionAction($ses, Request $request)
    {
        $session = $request->getSession();
        // set and get session attributes
        $session->set('name', $ses);
        echo $session->get('name');

        // set flash messages
        $session->getFlashBag()->add('notice', 'Profile updated');
        $html = '';
        // retrieve messages
        foreach ($session->getFlashBag()->get('notice', array()) as $message) {
            $html .= '<div class="flash-notice">'.$message.'</div>';
        }
        return new Response(
            '<html><body>page:'.$html.'</body></html>'
        );
    }
}