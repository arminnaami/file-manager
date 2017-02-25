<?php

class LandingTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->visit('/')
            ->see('Laravel')
            ->see('LOGIN')->click('Login')->seePageIs('/login')
            ->see('REGISTER')->click('Register')->seePageIs('/register');
    }
}
