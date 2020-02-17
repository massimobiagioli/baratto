<?php
namespace App\Tests\Service\Authenticator;

use App\Entity\Utente;
use App\Repository\UtenteRepository;
use App\Service\Authenticator\AuthenticatorInternal;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class AuthenticatorTest extends TestCase
{
    private $objectManager;
    private $authenticator;

    protected function setUp()
    {
        $utente = new Utente();
        $utente->setId(1);
        $utente->setEmail('roger.green@gmail.com');
        $utente->setPassword('6a71bdc6d5e48a76804e7881d8221591078f18f13b13d62669d1b48d638422a4');
        $utente->setAmministratore(true);

        $utenteRepository = $this->createMock(UtenteRepository::class);
        $args = [
            [['email' => 'roger.green@gmail.com'], null, $utente],
            [['email' => 'wrong@gmail.com'], null, null],
        ];
        $utenteRepository->expects($this->any())
            ->method('findOneBy')
            ->will($this->returnValueMap($args));

        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($utenteRepository);

        $this->entityManager->expects($this->any())
            ->method('persist')
            ->willReturn(true);

        $this->entityManager->expects($this->any())
            ->method('flush')
            ->willReturn(true);

        $this->authenticator = new AuthenticatorInternal($this->entityManager);
    }

    public function test_internal_login_with_valid_credentials_returns_access_token()
    {
        $email = 'roger.green@gmail.com';
        $password = 'Zxc123.';
        $accessToken = $this->authenticator->login($email, $password);
        $ret = preg_match('/[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}/', $accessToken->getValue(), $matches);
        $this->assertNotNull($accessToken);
        $this->assertEquals(1, $ret);
        $this->assertEquals($accessToken->getValue(), $matches[0]);
    }

    public function test_internal_login_with_wrong_email_raise_exception()
    {
        $email = 'thisIsAWrongUser.green@gmail.com';
        $password = 'pAzZ123!$&';
        $this->expectException(\Exception::class);
        $this->authenticator->login($email, $password);
    }

    public function test_internal_login_with_wrong_password_raise_exception()
    {
        $email = 'roger.green@gmail.com';
        $password = 'thisIsAWrongPassword!';
        $this->expectException(\Exception::class);
        $this->authenticator->login($email, $password);
    }

    // TODO: Test logout
}
