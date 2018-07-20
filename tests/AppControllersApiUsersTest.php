<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AppControllersApiUsersTest extends TestCase
{
    public function testIndex()
    {	
    	$response = $this->call('GET', 'users');
    	$content  = json_decode($response->content());
    	
    	$this->assertEquals(200, $response->status());
    	$this->assertEquals('All users', $content->message);
    }

    public function testShow()
    {
    	$user = factory(App\User::class)->create();
    	$response = $this->call('GET', sprintf('users/%d', $user->id));
    	$content  = json_decode($response->content());

    	$this->assertEquals(200, $response->status());
    	$this->assertEquals('All found', $content->message);
    	$this->assertEquals($user->id, $content->data->id);
    }

    public function testCreate()
    {
    	$params   = factory(App\User::class)->make();
    	$response = $this->response('POST', 'users', $params->toArray());
    	$content  = json_decode($response->content());

    	$this->assertEquals(201, $response->status());
    	$this->assertEquals('User created', $content->message);
    	$this->assertEquals($params->name, $content->data->name);
    }

    public function testUpdate()
    {
    	$user     = factory(App\User::class)->create();
    	$response = $this->response('PUT', sprintf('users/%d', $user->id), ['name' => 'Clemente josé']);
    	$content  = json_decode($response->content());

    	$userUp   = App\User::find($user->id);

    	$this->assertEquals(200, $response->status());
    	$this->assertEquals('User updated', $content->message);
    	$this->assertNotEquals($user->name, $userUp->name);
    }

    public function testDestroy()
    {
    	$user     = factory(App\User::class)->create();
    	$response = $this->response('DELETE', sprintf('users/%d', $user->id));
    	$find     = App\User::find($user->id);

    	$this->assertEquals(200, $response->status());
    	$this->assertEquals('User deleted', $response->message);
    	$this->assertTrue(empty($user));
    }
}
