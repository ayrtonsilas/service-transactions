<?php

namespace Tests\Feature;

use Tests\TestCase;

class TransactionRequestTest extends TestCase
{
    /**
     * Test Required Fields
     *
     * @return void
     */
    public function testRequiredFields()
    {
        $response = $this->post('/api/transactions', []);
        $data = $response->decodeResponseJson();

        $fields = array_keys($data['errors']);

        $expected = ["payer", "payee", "value"];
        foreach ($fields as $value) {
            $this->assertContains($value, $expected);
        }
        $this->assertEquals(3, count($data['errors']));
        $response->assertStatus(422);
    }
}
