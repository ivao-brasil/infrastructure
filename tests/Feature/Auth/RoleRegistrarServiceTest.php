<?php

namespace IvaoBrasil\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use IvaoBrasil\User\Contracts\RoleRegistrarInterface;
use IvaoBrasil\User\Data\UserRoles;
use IvaoBrasil\User\Entities\User;
use IvaoBrasil\User\Services\RoleRegistrarService;
use Tests\TestCase;

class RoleRegistrarServiceTest extends TestCase
{
    use RefreshDatabase;

    private RoleRegistrarService $roleRegistrar;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('user.division_code', 'BR');
        $this->roleRegistrar = app(RoleRegistrarInterface::class);
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
