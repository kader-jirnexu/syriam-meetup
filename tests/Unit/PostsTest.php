<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Post;

class PostsTest extends TestCase
{
    // make sure you are using a different DB for testing 
    use RefreshDatabase;

    /** @test */
    public function a_user_can_get_all_posts()
    {
        // mock 
        $post = factory(Post::class)->create();

        // run 
        $response = $this->get(route('posts.index'));

        // assertions
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'title' => $post->title,
                'body' => $post->body,
            ]);
    }

    /** @test */
    function a_user_can_create_a_post()
    {
        $header = [
            "Accept" => "application/json"
        ];

        $payload = [
            "title" => "Understanding software testing",
            "body" => "Software testing is an investigation conducted to provide stakeholders with information about the quality of the software product or service under test. Software testing can also provide an objective, independent view of the software to allow the business to appreciate and understand the risks of software implementation. Test techniques include the process of executing a program or application with the intent of finding software bugs"
        ];

        $response = $this->post(route('posts.store'), $payload, $header);

        $response
            ->assertStatus(201)
            ->assertJsonFragment([
                'title' => $payload['title'],
                'body' => $payload['body'],
            ]);

        $this->assertDatabaseHas('posts', [
            'title' => $payload['title']
        ]);
    }

    /** @test */
    function a_user_can_not_create_an_empty_post()
    {
        $payload = [];

        $response = $this->json('post', route('posts.store'), $payload);

        $response
            ->assertStatus(422)
            ->assertJsonFragment([
                "title" => ["The title field is required."],
                "body" => ["The body field is required."]
            ]);
    }
}
