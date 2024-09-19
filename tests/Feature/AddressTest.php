<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// Models
use App\Models\Address;
use App\Models\Customer;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_get_all_addresses()
    {
        $customer = Customer::factory()->create();
        $addresses = Address::factory()->count(3)->create(['customer_id' => $customer->id]);

        $response = $this->get("/api/customers/{$customer->id}/addresses");

        $response->assertStatus(200);
        $response->assertJson([
            'code' => 200,
            'message' => 'Addresses retrieved successfully',
        ]);
        foreach ($addresses as $address) {
            $response->assertJsonFragment(['address' => $address->address]);
        }
    }

    public function test_it_can_create_an_address()
    {
        $customer = Customer::factory()->create();
        $addressData = [
            'address' => '123 Main St',
            'district' => 'Central',
            'city' => 'Metropolis',
            'province' => 'Province X',
            'postal_code' => 12345,
        ];

        $response = $this->post("/api/customers/{$customer->id}/addresses", $addressData);

        $response->assertStatus(201);
        $response->assertJson([
            'code' => 201,
            'message' => 'Address created successfully',
        ]);
        $this->assertDatabaseHas('addresses', array_merge($addressData, ['customer_id' => $customer->id]));
    }

    public function test_it_can_get_a_single_address()
    {
        $customer = Customer::factory()->create();
        $address = Address::factory()->create(['customer_id' => $customer->id]);

        $response = $this->get("/api/customers/{$customer->id}/addresses/{$address->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'code' => 200,
            'message' => 'Address retrieved successfully',
        ]);
        $response->assertJsonFragment(['address' => $address->address]);
    }

    public function test_it_can_update_an_address()
    {
        $customer = Customer::factory()->create();
        $address = Address::factory()->create(['customer_id' => $customer->id]);
        $updateData = ['address' => '456 Elm St'];

        $response = $this->put("/api/customers/{$customer->id}/addresses/{$address->id}", $updateData);

        $response->assertStatus(200);
        $response->assertJson([
            'code' => 200,
            'message' => 'Address updated successfully',
        ]);
        $this->assertDatabaseHas('addresses', array_merge(['id' => $address->id, 'customer_id' => $customer->id], $updateData));
    }

    public function test_it_can_delete_an_address()
    {
        $customer = Customer::factory()->create();
        $address = Address::factory()->create(['customer_id' => $customer->id]);

        $response = $this->delete("/api/customers/{$customer->id}/addresses/{$address->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('addresses', ['id' => $address->id]);
    }
}
