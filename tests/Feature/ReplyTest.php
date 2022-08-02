<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    private function createComments(int $total = 3)
    {
        return factory(\App\Comment::class, $total)->create()
            ->each(function ($comment) {
                $comment->replies()->saveMany(factory(\App\Reply::class, rand(1,10))->make());
            });
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * Get comment replies.
     *
     * @return void
     */
    public function testGetCommentReplies()
    {
        $comment = $this->createComments()->random();

        $response = $this->get("api/comments/{$comment->id}/replies");

        $randomReply = $comment->replies->random();
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'replies' => [
                        'data' => [
                            '*' => [
                                'id',
                                'user_name',
                                'body',
                                'created_at',
                                'created_at_humanized',
                                'updated_at',
                                'sub_replies'
                            ]
                        ],
                        'links' => [
                            'current_page',
                            'first_page_url',
                            'last_page',
                            'last_page_url',
                            'next_page_url',
                            'per_page',
                            'previous_page_url',
                            'current',
                            'total',
                        ]
                    ]
                ]
            ])
            ->assertJsonFragment([
                'user_name' => $randomReply->user_name,
                'body' => $randomReply->body,
                'sub_replies' => $randomReply->subReplies,
            ]);
    }

    /**
     * Create comment replies.
     *
     * @return void
     */
    public function testCreateCommentReplies_validationErrors()
    {
        $comment = factory(\App\Comment::class)->create();

        $response = $this->post("api/comments/{$comment->id}/replies", [
            'user_name' => 's',
            'body' => 'q',
        ]);

        $response->assertStatus(422)
            ->assertJsonFragment([
                'user_name' => ['The user name must be at least 2 characters.'],
                'body' => ['The body must be at least 3 characters.']
            ]);

        $response = $this->post("api/comments/{$comment->id}/replies");
        $response->assertStatus(422)
        ->assertJsonFragment([
            'user_name' => ['The user name field is required.'],
            'body' => ['The body field is required.']
        ]);
    }

    /**
     * Create comment replies.
     *
     * @return void
     */
    public function testCreateCommentReplies()
    {
        $comment = factory(\App\Comment::class)->create();
        $reply = factory(\App\Reply::class)->make();

        $response = $this->post("api/comments/{$comment->id}/replies", [
            'user_name' => $reply->user_name,
            'body' => $reply->body,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'reply' => [
                        'id',
                        'user_name',
                        'body',
                        'created_at',
                        'created_at_humanized',
                        'updated_at',
                        'sub_replies'
                    ]
                ]
            ])
            ->assertJsonFragment([
                'user_name' => $reply->user_name,
                'body' => $reply->body,
                'sub_replies' => $reply->subReplies,
            ]);
    }
}
