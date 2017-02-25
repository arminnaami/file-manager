<?php

class LoginPageTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->visit('/login')
            ->press('Login')
            ->seePageIs('/login');

        $this->visit('/login')
            ->type('ynmehmedov@gmail.com', 'email')
            ->press('Login')
            ->seePageIs('/login');

        $this->visit('/login')
            ->type('welcome', 'password')
            ->press('Login')
            ->seePageIs('/login');

        $this->visit('/login')
            ->type('wrongmail@gmail.com', 'email')
            ->type('wrongpass', 'password')
            ->press('Login')
            ->seePageIs('/login');

        $this->visit('/login')
            ->type('ynmehmedov@gmail.com', 'email')
            ->type('welcome2', 'password')
            ->press('Login')
            ->seePageIs('/login');

        $this->visit('/login')
            ->type('ynmehmedov@', 'email')
            ->type('welcome', 'password')
            ->press('Login')
            ->seePageIs('/login');

        $this->visit('/login')
            ->type('ynmehmedov@gmail.com', 'email')
            ->type('welcome', 'password')
            ->check('remember')
            ->press('Login')
            ->seePageIs('/home')
            ->see('FileManager');
    }
}
