<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class DisableAccountControllerTest extends TestCase
{
    public function testDisableAccount()
    {
        $user = factory(User::class)->create();

        $this->postJson(route('api.account.disable', [$user->email_token_disable_account]))
            ->assertSuccessful()
            ->assertSeeText('Your account was successfully disabled');
    }

    public function testDisableAccountWillFailBecauseMethodNotAllowed()
    {
        $user = factory(User::class)->create();

        $this->putJson(route('api.account.disable', [$user->email_token_disable_account]))
            ->assertStatus(405)
            ->assertSeeText('Method not allowed');
    }

    public function testTooManyRequests()
    {
        $user = factory(User::class)->create();

        $this->postJson(route('api.account.disable', [$user->email_token_disable_account]))
            ->assertSuccessful();

        $this->postJson(route('api.account.disable', [$user->email_token_disable_account]))
            ->assertStatus(429)
            ->assertSeeText('Too many Requests');
    }
}
