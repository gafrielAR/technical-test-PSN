<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Models
use App\Models\Customer;

class CustomerController extends Controller
{
    private function sendResponse($data, $message, $code = 200, $totalItems = 1)
    {
        return response()->json([
            'code' => $code,
            'content' => $data,
            'totalItems' => $totalItems,
            'message' => $message,
        ], $code);
    }

    public function index(Request $request)
    {
        try {
            $limit = $request->input('limit', 10);

            if (is_null($limit) || $limit == 0) {
                $data = Customer::all();
                $totalItems = $data->count();
                return $this->sendResponse($data, 'Success get customer data', 200, $totalItems);
            }

            $data = Customer::paginate($limit);
            return $this->sendResponse($data->items(), 'Success get customer data', 200, $data->total());
        } catch (\Throwable $th) {
            return $this->sendResponse([], $th->getMessage(), 500, 0);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string',
                'name' => 'required|string',
                'gender' => 'required|in:male,female',
                'phone_number' => 'required|string',
                'email' => 'required|email|unique:customers',
            ]);

            $customer = Customer::create($validated);

            return $this->sendResponse($customer, 'Customer created successfully', 201);
        } catch (\Throwable $th) {
            return $this->sendResponse([], $th->getMessage(), 500, 0);
        }
    }

    public function show($id)
    {
        try {
            $customer = Customer::with('addresses')->findOrFail($id);
            return $this->sendResponse($customer, 'Customer retrieved successfully', 200);
        } catch (\Throwable $th) {
            $errorCode = $th->getCode() ? $th->getCode() : 500;
            return $this->sendResponse([], $th->getMessage(), 500, 0);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'title' => 'nullable|string',
                'name' => 'nullable|string',
                'gender' => 'nullable|in:male,female',
                'phone_number' => 'nullable|string',
                'email' => 'nullable|email|unique:customers,email,' . $id,
            ]);

            $customer = Customer::findOrFail($id);
            $customer->update($validated);

            return $this->sendResponse($customer, 'Customer updated successfully', 200);
        } catch (\Throwable $th) {
            $errorCode = $th->getCode() ? $th->getCode() : 500;
            return $this->sendResponse([], $th->getMessage(), 500, 0);
        }
    }

    public function destroy($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();

            return $this->sendResponse([], 'Customer deleted successfully', 200);
        } catch (\Throwable $th) {
            $errorCode = $th->getCode() ? $th->getCode() : 500;
            return $this->sendResponse([], $th->getMessage(), 500, 0);
        }
    }
}
