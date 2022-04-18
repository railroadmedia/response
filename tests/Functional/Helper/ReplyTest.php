<?php

namespace Railroad\Response\Tests\Functional\Helper;

use Illuminate\Testing\TestResponse;
use Illuminate\Http\JsonResponse;
use Railroad\Resora\Entities\Entity;
use Railroad\Response\Tests\TestCase;

class ReplyTest extends TestCase
{
	public function test_json_response_entity_single()
    {
        $entityData = [
            $this->faker->word => $this->faker->word,
            $this->faker->word => $this->faker->word,
            $this->faker->word => $this->faker->word
        ];

        $entity = new Entity();
        $entity->replace($entityData);

        $response = reply()->json($entity);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $testResponse = new TestResponse($response);

        $testResponse
            ->assertStatus(200)
            ->assertJson(['data' => [$entityData]]);
    }

    public function test_fractal_response_entities_array()
    {
        $entityOneData = [
            $this->faker->word => $this->faker->word,
            $this->faker->word => $this->faker->word,
            $this->faker->word => $this->faker->word
        ];

        $entityOne = new Entity();
        $entityOne->replace($entityOneData);

        $entityTwoData = [
            $this->faker->word => $this->faker->word,
            $this->faker->word => $this->faker->word,
            $this->faker->word => $this->faker->word
        ];

        $entityTwo = new Entity();
        $entityTwo->replace($entityTwoData);

        $response = reply()->json([$entityOne, $entityTwo]);

        $this->assertInstanceOf(JsonResponse::class, $response);

        $testResponse = new TestResponse($response);

        $testResponse
            ->assertStatus(200)
            ->assertJson(['data' => [$entityOneData, $entityTwoData]]);
    }

    public function test_fractal_response_meta_data()
    {
        $entityData = [
            $this->faker->word => $this->faker->word,
            $this->faker->word => $this->faker->word,
            $this->faker->word => $this->faker->word
        ];

        $entity = new Entity();
        $entity->replace($entityData);

        $metaData = [
            $this->faker->word => $this->faker->word,
            $this->faker->word => $this->faker->word,
            $this->faker->word => $this->faker->word
        ];

        $response = reply()->json(
            $entity,
            ['meta' => $metaData]
        );

        $this->assertInstanceOf(JsonResponse::class, $response);

        $testResponse = new TestResponse($response);

        $testResponse
            ->assertStatus(200)
            ->assertJson([
                'data' => [$entityData],
                'meta' => $metaData
            ]);
    }

    public function test_fractal_response_http_code()
    {
        $entityData = [
            $this->faker->word => $this->faker->word,
            $this->faker->word => $this->faker->word,
            $this->faker->word => $this->faker->word
        ];

        $entity = new Entity();
        $entity->replace($entityData);

        $response = reply()->json(
            $entity,
            ['code' => 202]
        );

        $this->assertInstanceOf(JsonResponse::class, $response);

        $testResponse = new TestResponse($response);

        $testResponse
            ->assertStatus(202)
            ->assertJson(['data' => [$entityData]]);
    }

    public function test_fractal_response_http_headers()
    {
        $entityData = [
            $this->faker->word => $this->faker->word,
            $this->faker->word => $this->faker->word,
            $this->faker->word => $this->faker->word
        ];

        $entity = new Entity();
        $entity->replace($entityData);

        $headerOneName = $this->faker->word;
        $headerOneValue = $this->faker->word;

        $headerTwoName = $this->faker->word;
        $headerTwoValue = $this->faker->word;

        $response = reply()->json(
            $entity,
            [
                'headers' => [
                    $headerOneName => $headerOneValue,
                    $headerTwoName => $headerTwoValue
                ]
            ]
        );

        $this->assertInstanceOf(JsonResponse::class, $response);

        $testResponse = new TestResponse($response);

        $testResponse
            ->assertStatus(200)
            ->assertJson(['data' => [$entityData]])
            ->assertHeader($headerOneName, $headerOneValue)
            ->assertHeader($headerTwoName, $headerTwoValue);
    }
}
