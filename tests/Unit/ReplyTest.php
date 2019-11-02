<?php

namespace Tests\Unit;

use App\Post;
use App\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_read_all_replies_associated_with_post()
    {
        // mock 
        $post = factory(Post::class)->create();

        factory(Reply::class)->create(['post_id' => $post->id]);

        // run 
        $response = $this->get("api/posts/" . $post->id);

        // assertions
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'replies',
            ]);
    }
}
