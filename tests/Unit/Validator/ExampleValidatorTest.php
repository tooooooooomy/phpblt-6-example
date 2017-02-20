<?php
namespace Tests\Unit\Validator;

use Tests\TestCase;

class ExampleValidatorTest extends TestCase
{
    function test_validate_when_valid()
    {
        $t = $this->app->make('App\Validator\ExampleValidator');

        $result = $t->validate('application/json', json_encode([
            'id' => 1,
            'string' => 'hoge',
            'object' => [
                'hoge' => 'aa',
                'fuga' => 'bb',
            ],
            'array' => [
                'a', 'b', 'c'
            ]
        ]));

        $this->assertTrue($result);
    }

    function test_validate_invalid_content_type()
    {
        $t = $this->app->make('App\Validator\ExampleValidator');

        $result = $t->validate('hoge', json_encode([
            'id' => 1,
            'string' => 'hoge',
            'object' => [
                'hoge' => 'aa',
                'fuga' => 'bb',
            ],
            'array' => [
                'a', 'b', 'c'
            ]
        ]));

        $this->assertFalse($result);
    }

    function test_validate_not_json()
    {
        $t = $this->app->make('App\Validator\ExampleValidator');

        $result = $t->validate('application/json', 'hogehoge');

        $this->assertFalse($result);
    }

    function test_validate_invalid_json()
    {
        $t = $this->app->make('App\Validator\ExampleValidator');

        $result = $t->validate('application/json', json_encode([
            'fugafuga' => 1,
        ]));

        $this->assertFalse($result);
    }
}