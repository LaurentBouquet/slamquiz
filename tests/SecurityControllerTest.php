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
        // Request /login 
        $crawler = $this->client->request('GET', '/login');

        // Asserts that /login path exists and don't return an error
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        // Asserts that the phrase "Log in!" is present in the page's title
        $this->assertSelectorTextContains('html head title', 'Log in!');        

        // Asserts that the response content contains 'csrf token'
        $this->assertContains('type="hidden" name="_csrf_token"', $this->client->getResponse()->getContent());

        // Asserts that the response content contains 'input type="text" id="inputEmail"'
        $this->assertContains('<input type="email" value="" name="email" id="inputEmail" class="form-control" placeholder="Email" required autofocus>', $this->client->getResponse()->getContent());

        // Asserts that the response content contains 'input type="text" id="inputPassword"'
        $this->assertContains('<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>', $this->client->getResponse()->getContent());        
    }

    /**
     * Verify that the category list is not displayed to users who do not have the admin role
     */
    public function testNotShowCategory()
    {
        // Request /category 
        $this->client->request('GET', '/category');

        // Asserts that category path move to another path (login)
        $this->assertEquals(Response::HTTP_MOVED_PERMANENTLY, $this->client->getResponse()->getStatusCode());
    }

    /**
     * Create the Authentication Token¶
     */
    private function logIn($userName = 'user', $userRole = 'ROLE_USER')
    {
        $session = $this->client->getContainer()->get('session');

        $firewallName = 'main';
        // if you don't define multiple connected firewalls, the context defaults to the firewall name
        // See https://symfony.com/doc/current/reference/configuration/security.html#firewall-context
        $firewallContext = 'main';

        // you may need to use a different token class depending on your application.
        // for example, when using Guard authentication you must instantiate PostAuthenticationGuardToken
        $token = new UsernamePasswordToken($userName, null, $firewallName, [$userRole]);
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    /**
     * Check the logged-on user's path access with the ROLE_USER role
     */
    public function testSecuredRoleUser()
    {
        $this->logIn('user', 'ROLE_USER');
        $crawler = $this->client->request('GET', '/category/');

        // Asserts that /category path exists and don't return an error
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        // Asserts that the response content contains 'Category index' in 'h1' tag
        $this->assertSame('Category index', $crawler->filter('h1')->text()); // '_locale' 'en'

        $crawler = $this->client->request('GET', '/category/new');

        // Asserts that /category/new path exists and don't return an error
        $this->assertSame(Response::HTTP_FORBIDDEN, $this->client->getResponse()->getStatusCode());

    }

    
    /**
     * Check the logged-on user's path access with the ROLE_ADMIN role
     */
    public function testSecuredRoleAdmin()
    {
        $this->logIn('admin', 'ROLE_ADMIN');
        $crawler = $this->client->request('GET', '/category/new');

        // Asserts that /category/new path exists and don't return an error
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        // Asserts that the response content contains 'Create new category' in 'h1' tag
        $this->assertSame('Create new category', $crawler->filter('h1')->text()); // '_locale' 'en'
    }

}
