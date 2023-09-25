<?php


namespace Tests;


use GuzzleHttp\ClientInterface;
use IvaoSocialite\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_make_user()
    {
        $apiResponse = json_decode('{"result":1,"vid":"385415","firstname":"Joao Pedro","lastname":"Henrique","rating":2,"ratingatc":5,"ratingpilot":5,"division":"BR","country":"BR","skype":"","hours_atc":862153,"hours_pilot":12859731,"staff":"BR-AWM:WD9","va_staff_ids":"","va_staff":0,"va_staff_icaos":"","isNpoMember":1,"va_member_ids":"19770","hq_pilot":0}', true);

        $user = new User($apiResponse);

        $this->assertEquals(385415, $user->getId());
        $this->assertEquals("Joao Pedro Henrique", $user->getName());
        $this->assertEquals(false, $user["isHqPilot"]);
        $this->assertEquals(true, $user["isNpoMember"]);
        $this->assertEquals(862153, $user['secondsAsAtc']);
        $this->assertEquals(12859731, $user['secondsAsPilot']);
    }
}