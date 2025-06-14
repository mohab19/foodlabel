<?php

namespace Tests\Unit\Auth;

use App\Domains\Auth\Repositories\UserRepository;
use App\Domains\Auth\Services\UserService;
use PHPUnit\Framework\TestCase;
use App\Models\User;
use Mockery;

class UserUnitTest extends TestCase
{
    protected UserService $user_service;
    protected $mock_repo;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mock_repo = Mockery::mock(UserRepository::class);

        $this->mock_repo
             ->shouldReceive('create')
             ->once()
             ->with(Mockery::on(function ($input) {
                 return $input['email'] === 'test@gmail.com';
             }))
             ->andReturn(new User([
                 'name'  => 'Test User',
                 'email' => 'test@gmail.com',
             ]));

        $this->user_service = new UserService($this->mock_repo);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_user_can_be_registered_via_service()
    {
        $user = $this->user_service->register([
            'name'     => 'Test User',
            'email'    => 'test@gmail.com',
            'password' => 'password123',
        ]);

        $this->assertIsArray($user);
        $this->assertEquals(201, $user['response_code']);
        $this->assertEquals('test@gmail.com', $user['response_data']['email']);
    }

}
