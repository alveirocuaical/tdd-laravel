<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RepositoryControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_guest()
    {
        $this->get('repositories')->assertRedirect('login'); // index
        $this->get('repositories/1')->assertRedirect('login'); // show
        $this->get('repositories/1/edit')->assertRedirect('login'); // edit
        $this->put('repositories/1')->assertRedirect('login'); // update
        $this->delete('repositories/1')->assertRedirect('login'); // destroy
        $this->get('repositories/create')->assertRedirect('login');     // create
        $this->post('repositories')->assertRedirect('login'); // store

    }
    public function test_index_empty()
    {
        Repository::factory()->create();

        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->get('repositories')
            ->assertStatus(200)
            ->assertSee('No hay repositorios');
    }

    public function test_index_with_data()
    {

        $user = User::factory()->create();
        $repository = Repository::factory()->create(
            ['user_id' => $user->id]
        );

        $this
            ->actingAs($user)
            ->get('repositories')
            ->assertStatus(200)
            ->assertSee($repository->id);
    }

    // test metodo create
    public function test_create()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get("repositories/create")
            ->assertStatus(200);
    }


    // test metodo store
    public function test_store()
    {
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,
        ];
        $user = User::factory()->create();
        $this->actingAs($user)
            ->post('repositories', $data)
            ->assertRedirect('repositories');
        $this->assertDatabaseHas('repositories', $data);
    }

    public function test_update()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create(
            ['user_id' =>$user->id]
        );
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,
        ];

        $this->actingAs($user)
            ->put("repositories/$repository->id", $data)
            ->assertRedirect("repositories/$repository->id");

        $this->assertDatabaseHas('repositories', $data);
    }

    public function test_update_policy()
    {
        $user = User::factory()->create();// user id = 1
        $repository = Repository::factory()->create();
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,
        ];

        $this->actingAs($user)
            ->put("repositories/$repository->id", $data)
            ->assertStatus(403);

    }

    // test de validaciones


    public function test_validate_store()
    {
        //al usar los FormRequest, no retorna una redireccion, sino una respuesta
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('repositories', [])
            ->assertSessionHasErrors(['url', 'description']);
    }

    public function test_validate_update()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create(
            ['user_id' => $user->id]
        );

        $this->actingAs($user)
            ->put("repositories/$repository->id", [])
            ->assertSessionHasErrors(['url', 'description'])
            ;

    }

    public function test_delete()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create([
            'user_id' => $user->id
        ]);
        $this->actingAs($user)
            ->delete("repositories/$repository->id")
            ->assertRedirect('repositories');
        $this->assertDatabaseMissing('repositories', $repository->toArray());
    }

    public function test_delete_policy()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create();

        $this->actingAs($user)
            ->delete("repositories/$repository->id")
            ->assertStatus(403);

    }

    // test metodo show
    public function test_show()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create(
            ['user_id' =>$user->id]
        );

        $this->actingAs($user)
            ->get("repositories/$repository->id")
            ->assertStatus(200);
    }

    public function test_show_policy()
    {
        $user = User::factory()->create();// user id = 1
        $repository = Repository::factory()->create();

        $this->actingAs($user)
            ->get("repositories/$repository->id")
            ->assertStatus(403);

    }

    // test metodo edit
    public function test_edit()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create(
            ['user_id' =>$user->id]
        );

        $this->actingAs($user)
            ->get("repositories/$repository->id/edit")
            ->assertStatus(200)
            ->assertSee($repository->url)
            ->assertSee($repository->description);
    }

    public function test_edit_policy()
    {
        $user = User::factory()->create();// user id = 1
        $repository = Repository::factory()->create();

        $this->actingAs($user)
            ->get("repositories/$repository->id/edit")
            ->assertStatus(403);

    }





}
