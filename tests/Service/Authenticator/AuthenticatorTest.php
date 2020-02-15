<?php
namespace App\Tests\Service\Authenticator;

use App\Entity\Utente;
use App\Repository\UtenteRepository;
use App\Service\Authenticator\AuthenticatorInternal;
use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;

class AuthenticatorTest extends TestCase
{
    private $objectManager;
    private $authenticator;

    protected function setUp()
    {
        $utente = new Utente();
        $utente->setEmail('roger.green@gmail.com');
        $utente->setPassword('6a71bdc6d5e48a76804e7881d8221591078f18f13b13d62669d1b48d638422a4');

        $utenteRepository = $this->createMock(UtenteRepository::class);
        $utenteRepository->expects($this->any())
            ->method('find')
            ->willReturn($utente);

        $this->objectManager = $this->createMock(ObjectManager::class);
        $this->objectManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($utenteRepository);

        $this->authenticator = new AuthenticatorInternal($this->objectManager);
    }

    public function testLoginValidCredentials()
    {
        $email = 'roger.green@gmail.com';
        $password = 'Zxc123.';
        $accessToken = $this->authenticator->login($email, $password);
        $this->assertNotNull($accessToken);
    }

    public function testLoginWrongCredentials()
    {
        $email = 'roger.green@gmail.com';
        $password = 'thisIsAWrongPassword!';
        $this->expectException(\Exception::class);
        $this->authenticator->login($email, $password);
    }
    
}
