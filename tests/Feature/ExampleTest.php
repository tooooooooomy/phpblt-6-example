<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    function test_success()
    {
        $response = $this->json('POST', '/api/example', [
            'id' => 1,
            'string' => 'hoge',
            'object' => [
                'hoge' => 'aa',
                'fuga' => 'bb',
            ],
            'array' => [
                'a', 'b', 'c'
            ]
        ]);

        $response->assertStatus(200);
    }

    function test_validation_error()
    {
        $response = $this->json('POST', '/api/example', [
            'id' => 1,
        ]);

        $response->assertStatus(400);
        $this->assertEquals('validation error', $response->getContent());
    }

    function test_exception_error()
    {
        $response = $this->json('POST', '/api/example', [
            'id' => 1,
            'string' => 'fuga',
            'object' => [
                'hoge' => 'aa',
                'fuga' => 'bb',
            ],
            'array' => [
                'a', 'b', 'c'
            ]
        ]);

        $response->assertStatus(500);
        $this->assertEquals('fugafuga', $response->getContent());
    }
}
