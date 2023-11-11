<?php

namespace IvaoBrasil\Infrastructure\Tests\Feature\Auth;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use IvaoBrasil\Infrastructure\Contracts\Auth\RoleRegistrarInterface;
use IvaoBrasil\Infrastructure\Data\Auth\UserRoles;
use IvaoBrasil\Infrastructure\Services\Auth\RoleRegistrarService;
use IvaoBrasil\Infrastructure\Tests\Feature\Auth\Fixtures\TestUser;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase;

class RoleRegistrarServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithWorkbench;

    private RoleRegistrarService $roleRegistrar;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->roleRegistrar = app(RoleRegistrarInterface::class);
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function defineEnvironment($app)
    {
        // Setup default database to use sqlite :memory:
        tap($app['config'], function (Repository $config) {
            $config->set('ivao-infrastructure.auth.division_code', 'BR');
            $config->set('auth.guards', [
                'web' => [
                    'driver' => 'session',
                    'provider' => 'users',
                ]
            ]);

            $config->set('auth.providers', [
                'users' => [
                    'driver' => 'eloquent',
                    'model' => TestUser::class,
                ],
            ]);

            $config->set('services.ivao-oauth', [
                'client_id' => 'ABC',
                'client_secret' => '123',
                'redirect' => '/auth/callback'
            ]);
        });
    }

    /**
     * @param string $division
     * @param array $staff
     * @param Collection $expected
     * @return void
     *
     * @dataProvider assignsRoleToUserProvider
     */
    public function testAssignsRoleToUser(string $division, array $staff, array $expected)
    {
        $result = $this->roleRegistrar->getRolesToAssign($division, $staff);

        $this->assertSame($expected, $result->toArray());
    }

    public function assignsRoleToUserProvider()
    {
        return [
            'User is not a Staff member' => [
                'division' => 'BR',
                'staff' => [],
                'expected' => []
            ],
            'Staff from another division' => [
                'division' => 'ZZ',
                'staff' => ['ZZ-DIR'],
                'expected' => []
            ],
            'User is Web dept. Coordinator' => [
                'division' => 'BR',
                'staff' => ['BR-WM'],
                'expected' => [UserRoles::WEB_COORDINATOR, UserRoles::STAFF]
            ],
            'User is from atc dept.' => [
                'division' => 'BR',
                'staff' => ['BR-AOA1'],
                'expected' => [UserRoles::ATC_OPS_ADVISOR, UserRoles::STAFF]
            ],
            'User is from pr dept.' => [
                'division' => 'BR',
                'staff' => ['BR-PRAC'],
                'expected' => [UserRoles::PUBLIC_RELATIONS_COORDINATOR, UserRoles::STAFF]
            ],
            'User is from Events dept.' => [
                'division' => 'BR',
                'staff' => ['BR-EA1'],
                'expected' => [UserRoles::EVENTS_ADVISOR, UserRoles::STAFF]
            ],
            'User is Events dept. Coordinator' => [
                'division' => 'BR',
                'staff' => ['BR-EC'],
                'expected' => [UserRoles::EVENTS_COORDINATOR, UserRoles::STAFF]
            ],
            'User is Training dept. Coordinator' => [
                'division' => 'BR',
                'staff' => ['SRTA16', 'BR-TC'],
                'expected' => [UserRoles::TRAINING_COORDINATOR, UserRoles::STAFF]
            ],
            'User is FIR Chef' => [
                'division' => 'BR',
                'staff' => ['SBCW-CH'],
                'expected' => [UserRoles::FIR_CHIEF, UserRoles::STAFF]
            ],
            'User has hq+div staff positions' => [
                'division' => 'BR',
                'staff' => ['SRTA1', 'BR-WM'],
                'expected' => [UserRoles::WEB_COORDINATOR, UserRoles::STAFF]
            ],
            'User is a Member dept. Coordinator' => [
                'division' => 'BR',
                'staff' => ['BR-MAC'],
                'expected' => [UserRoles::MEMBERS_COORDINATOR, UserRoles::STAFF]
            ],
            'User has multiple division staff positions' => [
                'division' => 'BR',
                'staff' => ['BR-TC', 'BR-MC', 'SBCW-ACH'],
                'expected' => [
                    UserRoles::TRAINING_COORDINATOR,
                    UserRoles::MEMBERS_COORDINATOR,
                    UserRoles::FIR_CHIEF,
                    UserRoles::STAFF,
                ]
            ],
            'User has only hq position' => [
                'division' => 'BR',
                'staff' => ['SRTA1'],
                'expected' => []
            ],
        ];
    }
}
