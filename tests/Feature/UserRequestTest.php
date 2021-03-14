<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserRequestTest extends TestCase
{
    /**
     * Test Required Fields
     *
     * @return void
     */
    public function testRequiredFields()
    {
        $response = $this->post('/api/users', []);
        $data = $response->decodeResponseJson();

        $fields = array_keys($data['errors']);

        $expected = ["name", "register_code", "type", "email", "amount"];
        foreach ($fields as $value) {
            $this->assertContains($value, $expected);
        }
        $this->assertEquals(5, count($data['errors']));
        $response->assertStatus(422);
    }
}
