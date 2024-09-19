<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// Models
use App\Models\Customer;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_get_all_customers()
    {
        $customers = Customer::factory()->count(3)->create();

        $response = $this->get('/api/customers');

        $response->assertStatus(200);
        $response->assertJson([
            'code' => 200,
            'totalItems' => 3,
            'message' => 'Success get customer data'
        ]);
        foreach ($customers as $customer) {
            $response->assertJsonFragment(['name' => $customer->name]);
        }
    }

    public function test_it_can_create_a_customer()
    {
        $customerData = [
            'title' => 'Mr',
            'name' => 'John Doe',
            'gender' => 'male',
            'phone_number' => '123456789',
            'email' => 'john.doe@example.com',
        ];

        $response = $this->post('/api/customers', $customerData);

        $response->assertStatus(201);
        $response->assertJson([
            'code' => 201,
            'message' => 'Customer created successfully'
        ]);
        $this->assertDatabaseHas('customers', $customerData);
    }

    public function test_it_can_get_a_single_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->get('/api/customers/' . $customer->id);

        $response->assertStatus(200);
        $response->assertJson([
            'code' => 200,
            'message' => 'Customer retrieved successfully'
        ]);
        $response->assertJsonFragment(['name' => $customer->name]);
    }

    public function test_it_can_update_a_customer()
    {
        $customer = Customer::factory()->create();
        $updateData = ['name' => 'Jane Doe'];

        $response = $this->put('/api/customers/' . $customer->id, $updateData);

        $response->assertStatus(200);
        $response->assertJson([
            'code' => 200,
            'message' => 'Customer updated successfully'
        ]);
        $this->assertDatabaseHas('customers', array_merge(['id' => $customer->id], $updateData));
    }

    public function test_it_can_delete_a_customer()
    {
        $customer = Customer::factory()->create();

        $response = $this->delete('/api/customers/' . $customer->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }
}
