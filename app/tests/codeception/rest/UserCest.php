<?php

class UserCest
{
    private $faker;

    private $username;
    private $password;
    private $email;
    private $id;

    public function _before(RestTester $I)
    {
        $this->faker = Faker\Factory::create();

        $this->username = $this->faker->username;
        $this->email = $this->faker->safeEmail;
        $this->password = $this->faker->password;
    }

    public function _after(RestTester $I)
    {
    }

    // tests
    public function registerAsUser(RestTester $I)
    {
        $I->wantTo('POST /users');

        $I->sendPOST(
            'users.json',
            [
                'username' => $this->username,
                'email' => $this->email,
                'password' => $this->password
            ]
        );

        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['email' => $this->email]);

        // $this->id = (string) $I->grabDataFromResponseByJsonPath("$['id']");
    }

    public function editUser(RestTester $I)
    {
//        $I->wantTo('PUT /users');
//
//        $I->sendPOST(
//            'users.json',
//            [
//                'username' => $this->username,
//                'email' => $this->email,
//                'password' => $this->password
//            ]
//        );
//
//        $I->seeResponseIsJson();
//        $I->seeResponseContainsJson(['email' => $this->email]);
    }

    public function checkRegistered(RestTester $I)
    {
//        $id = (string)$I->grabDataFromResponseByJsonPath('@id');
//
//        $I->sendGET(sprintf('user/%s.json', $id));
//        $I->seeResponseIsJson();
//        $I->seeResponseContainsJson(['email' => $this->email]);
    }
}
