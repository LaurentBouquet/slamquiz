<?php

namespace App\Tests;

use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityControllerTest extends WebTestCase
{

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * Login form show username and password input
     */
    public function testShowLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        // asserts that login path exists and don't return an error
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        // asserts that the response content contains csrf token
        $this->assertContains('type="hidden" name="_csrf_token"', $client->getResponse()->getContent());

        // // asserts that the response content contains input type="text" id="inputEmail"
        $this->assertContains('<input type="email" value="" name="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>', $client->getResponse()->getContent());

        // // asserts that the response content contains input type="text" id="inputPassword"
        $this->assertContains('<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>', $client->getResponse()->getContent());
    }

    /**
     * Create the Authentication Token¶
     */
    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        $firewallName = 'main';
        // if you don't define multiple connected firewalls, the context defaults to the firewall name
        // See https://symfony.com/doc/current/reference/configuration/security.html#firewall-context
        $firewallContext = 'main';

        // you may need to use a different token class depending on your application.
        // for example, when using Guard authentication you must instantiate PostAuthenticationGuardToken
        $token = new UsernamePasswordToken('admin', null, $firewallName, ['ROLE_ADMIN']);
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    /**
     * Login ROLE_ADMIN
     */
    public function testSecuredHello()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', '/category/');// '_locale' 'en'

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Category index', $crawler->filter('h1')->text());
    }

}
