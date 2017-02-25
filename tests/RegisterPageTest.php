<?php

use App\User;

class RegisterPageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        Session::regenerate(true);
        $this->visit('/register')
            ->press('Register')
            ->seePageIs('/register');

        $this->visit('/register')
            ->type('Test name', 'name')
            ->press('Register')
            ->seePageIs('/register');

        $this->visit('/register')
            ->type('Test name', 'name')
            ->type('testmail@gmail.com', 'email')
            ->press('Register')
            ->seePageIs('/register');

        $this->visit('/register')
            ->type('Test name', 'name')
            ->type('testmail@gmail.com', 'email')
            ->type('welcome', 'password')
            ->press('Register')
            ->seePageIs('/register');

        $this->visit('/register')
            ->type('Test name', 'name')
            ->type('testmail@gmail.com', 'email')
            ->type('welcome', 'password')
            ->press('Register')
            ->seePageIs('/register');

        $this->visit('/register')
            ->type('Test Name', 'name')
            ->type('testmail@gmail.com', 'email')
            ->type('welcome', 'password')
            ->type('welcome1', 'password_confirmation')
            ->press('Register')
            ->seePageIs('/register');

        $this->visit('/register')
            ->type('Test Name', 'name')
            ->type('testmail@gmail.com', 'email')
            ->type('welcome', 'password')
            ->type('welcome', 'password_confirmation')
            ->press('Register');

        $this->seeInDatabase('users', ['email' => 'testmail@gmail.com']);

        $user = User::where('email', 'testmail@gmail.com');

        $user->delete();

        $this->missingFromDatabase('users', ['email' => 'testmail@gmail.com']);

    }
}
