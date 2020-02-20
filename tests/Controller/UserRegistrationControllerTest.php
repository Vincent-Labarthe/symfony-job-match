<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRegistrationControllerTest extends WebTestCase
{

    public function testAnonymousPages()
    {

        // on crée le client virtuel
        $client = static::createClient();


        $client->request("GET", "/");

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
        $this->assertSelectorTextContains("h1", "Job-Match");
    }
    public function testLoginRedirect()
    {

        $client = static::createClient();
        $client->request("GET", "/user/home/16");
        $this->assertEquals(
            302,
            $client->getResponse()->getStatusCode()
        );
    }
}
