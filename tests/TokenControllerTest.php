<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class TokenControllerTest
 */
class TokenControllerTest extends WebTestCase
{
    /**
     * Test token creation.
     */
    public function testCreateToken(): void
    {
        $client = static::createClient();
        $client->setServerParameter('CONTENT_TYPE', 'application/json');
        $client->request(
            'POST',
            '/api/get-token',
            [],
            [],
            [],
            json_encode([
                'username' => 'test',
                'password' => 'testpass',
            ])
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('token', $data);
    }
}
