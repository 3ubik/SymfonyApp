<?php

namespace App\Tests\Functional\Users\Infrastructure\Controller;

use App\Tests\Tools\FixtureTools;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetUserInformationTest extends WebTestCase
{
    use FixtureTools;

    public function test_get_user_information(): void
    {
        $client = static::createClient();
        $user = $this->loadUserFixture();
        $client->request(
            'POST',
            '/api/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'email' => $user->getEmail(),
                'password' => $user->getPassword(),
            ])
        );
        $data = json_decode($client->getResponse()->getContent(), true);
        var_dump($data);
        $client->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $data['token']));
        // act
        $client->request('GET', '/users/me');

        // assert
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($user->getEmail(), $response['email']);
    }
}
