<?php

namespace IvaoBrasil\Infrastructure\Tests\Feature\Auth;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use IvaoBrasil\Infrastructure\Contracts\Auth\RoleRegistrarInterface;
use IvaoBrasil\Infrastructure\Data\Auth\UserRoles;
use IvaoBrasil\Infrastructure\Models\Core\User;
use IvaoBrasil\Infrastructure\Services\Auth\RoleRegistrarService;
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
    public function testAssignsRoleToUser(string $division, array $staff, Collection $expected)
    {
        /** @var User */
        $user = User::factory()->createOne([
            'division' => $division, 'staff' => $staff
        ]);

        $this->roleRegistrar->assignRoles($user);

        $this->assertSame($expected->pluck('value')->toArray(), $user->getRoleNames()->toArray());
    }

    public function assignsRoleToUserProvider()
    {
        return [
            'User is not a Staff member' => [
                'division' => 'BR',
                'staff' => [],
                'expected' => collect()
            ],
            'Staff from another division' => [
                'division' => 'ZZ',
                'staff' => ['ZZ-DIR'],
                'expected' => collect()
            ],
            'User is Web dept. Coordinator' => [
                'division' => 'BR',
                'staff' => ['BR-WM'],
                'expected' => collect([UserRoles::WEB_COORDINATOR, UserRoles::STAFF])
            ],
            'User is from atc dept.' => [
                'division' => 'BR',
                'staff' => ['BR-AOA1'],
                'expected' => collect([UserRoles::ATC_OPS_ADVISOR, UserRoles::STAFF])
            ],
            'User is from pr dept.' => [
                'division' => 'BR',
                'staff' => ['BR-PRAC'],
                'expected' => collect([UserRoles::PUBLIC_RELATIONS_COORDINATOR, UserRoles::STAFF])
            ],
            'User is from Events dept.' => [
                'division' => 'BR',
                'staff' => ['BR-EA1'],
                'expected' => collect([UserRoles::EVENTS_ADVISOR, UserRoles::STAFF])
            ],
            'User is Events dept. Coordinator' => [
                'division' => 'BR',
                'staff' => ['BR-EC'],
                'expected' => collect([UserRoles::EVENTS_COORDINATOR, UserRoles::STAFF])
            ],
            'User is Training dept. Coordinator' => [
                'division' => 'BR',
                'staff' => ['SRTA16', 'BR-TC'],
                'expected' => collect([UserRoles::TRAINING_COORDINATOR, UserRoles::STAFF])
            ],
            'User is FIR Chef' => [
                'division' => 'BR',
                'staff' => ['SBCW-CH'],
                'expected' => collect([UserRoles::FIR_CHIEF, UserRoles::STAFF])
            ],
            'User has hq+div staff positions' => [
                'division' => 'BR',
                'staff' => ['SRTA1', 'BR-WM'],
                'expected' => collect([UserRoles::WEB_COORDINATOR, UserRoles::STAFF])
            ],
            'User is a Member dept. Coordinator' => [
                'division' => 'BR',
                'staff' => ['BR-MAC'],
                'expected' => collect([UserRoles::MEMBERS_COORDINATOR, UserRoles::STAFF])
            ],
            'User has multiple division staff positions' => [
                'division' => 'BR',
                'staff' => ['BR-TC', 'BR-MC', 'SBCW-ACH'],
                'expected' => collect([
                    UserRoles::TRAINING_COORDINATOR,
                    UserRoles::MEMBERS_COORDINATOR,
                    UserRoles::FIR_CHIEF,
                    UserRoles::STAFF,
                ])
            ],
            'User has only hq position' => [
                'division' => 'BR',
                'staff' => ['SRTA1'],
                'expected' => collect()
            ],
        ];
    }
}