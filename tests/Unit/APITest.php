<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;

class APITest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUserCreation()
    {
        $response = $this->json('POST', '/api/register', [
            'name' => 'Demo User',
            'email' => Str::random(10) . '@demo.com',
            'password' => '12345',
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'success' => ['token', 'name']
        ]);
    }

    public function testLoginUser(){

        $response = $this->json('POST','/api/login', [
            'email' => 'admin@gmail.com',
            'password' => 'admin',
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'success' => ['token']
        ]);
    }


    public function testFetchingAllCategories(){

        $this->withoutMiddleware();
        $response = $this->json('GET','/api/categories');

        $response->assertStatus(200)->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'created_at',
                'updated_at',
                'deleted_at'
            ]
        ]);
    }

    public function testCategoryCreation()
    {
        $this->withoutMiddleware();

        $response = $this->json('POST', '/api/categories', [
            'name' => Str::random(10),
        ]);

        $response->assertStatus(200)->assertJson([
            'status' => true,
            'message' => 'Category Created'
        ]);
    }

    public function testCategoryDeletion()
    {
       // $this->withoutMiddleware();
        $user = User::find(1);

        $category = Category::create(['name' => 'To be deleted1']);

        $response = $this->actingAs($user, 'api')
            ->json('DELETE', "/api/categories/{$category->id}")
            ->assertStatus(200)->assertJson([
                'status' => true,
                'message' => 'Category Deleted'
            ]);
    }
}
