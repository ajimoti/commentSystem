<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Resources\CommentResource;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
    }

    private function createComments(int $total = 3)
    {
        return factory(\App\Comment::class, $total)->create()
            ->each(function ($comment) {
                $comment->replies()->saveMany(factory(\App\Reply::class, rand(1,10))->make());
            });
    }

    /**
     * Fetch comments tests.
     * Ensure the right comment information is returned
     *
     * @return void
     */
    public function testFetchComments_canSeeCommentInformation()
    {
        $comment = factory(\App\Comment::class)->create();

        $response = $this->get('api/comments');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => 1,
                'user_name' => $comment->user_name,
                'body' => $comment->body,
                'created_at' => $comment->created_at->toDateTimeString(),
                'created_at_humanized' => $comment->updated_at->diffForHumans(),
                'updated_at' => $comment->updated_at->toDateTimeString(),
            ]);
    }

    /**
     * Fetch comments tests.
     * Ensure all comments created are returned
     *
     * @return void
     */
    public function testFetchComments_canGetAllCommentsCreated()
    {
        $this->createComments(10);

        $response = $this->get('api/comments');

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data.comments.data');
    }

    /**
     * Fetch comments tests.
     * Ensure a valid json structure is returned
     *
     * @return void
     */
    public function testFetchComments_getsValidJsonStructure()
    {
        $this->createComments(10);

        $response = $this->get('api/comments');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'comments' => [
                        'data' => [
                            '*' => [
                                'id',
                                'user_name',
                                'body',
                                'created_at',
                                'created_at_humanized',
                                'updated_at',
                                'replies'
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
            ]);
    }

    /**
     * Create comments.
     * Ensure validation error is thrown
     *
     * @return void
     */
    public function testCreateComment_validationErrors()
    {
        $response = $this->post('api/comments', [
            'user_name' => 'a',
            'body' => 'b',
        ]);

        $response->assertStatus(422)
            ->assertJsonFragment([
                'user_name' => ['The user name must be at least 2 characters.'],
                'body' => ['The body must be at least 3 characters.']
            ]);


        $response = $this->post('api/comments');
        $response->assertStatus(422)
            ->assertJsonFragment([
                'user_name' => ['The user name field is required.'],
                'body' => ['The body field is required.']
            ]);
    }

    /**
     * Create comments.
     *
     * @return void
     */
    public function testCreateComment_canCreateComment()
    {
        $comment = factory(\App\Comment::class)->make();

        $response = $this->post('api/comments', [
            'user_name' => $comment->user_name,
            'body' => $comment->body,
        ]);

        $commentResource = new CommentResource($comment);
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'comment' => [
                        'id',
                        'user_name',
                        'body',
                        'created_at',
                        'created_at_humanized',
                        'updated_at',
                        'replies'
                    ]
                ]
            ])
            ->assertJsonFragment([
                'user_name' => $commentResource->user_name,
                'body' => $commentResource->body,
                'replies' => [],
            ]);
    }
}
