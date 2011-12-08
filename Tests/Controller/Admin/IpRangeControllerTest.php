<?php

namespace Yitznewton\FreermsBundle\Tests\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IpRangeControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

//         $crawler = $client->request('GET', '/hello/Fabien');
// 
//         $this->assertTrue($crawler->filter('html:contains("Hello Fabien")')->count() > 0);
    }
}
