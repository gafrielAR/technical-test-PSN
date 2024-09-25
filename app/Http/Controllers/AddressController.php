<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Models
use App\Models\Address;

class AddressController extends Controller
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

    public function index($customer_id)
    {
        try {
            $addresses = Address::where('customer_id', $customer_id)->get();
            return $this->sendResponse($addresses, 'Addresses retrieved successfully');
        } catch (\Throwable $th) {
            return $this->sendResponse([], $th->getMessage(), $th->getCode() ?: 500);
        }
    }

    public function store(Request $request, $customer_id)
    {
        try {
            $validated = $request->validate([
                'address' => 'required|string',
                'district' => 'required|string',
                'city' => 'required|string',
                'province' => 'required|string',
                'postal_code' => 'required|integer',
            ]);

            $validated['customer_id'] = $customer_id;
            $address = Address::create($validated);
            return $this->sendResponse($address, 'Address created successfully', 201);
        } catch (\Throwable $th) {
            return $this->sendResponse([], $th->getMessage(), $th->getCode() ?: 500);
        }
    }

    public function show($customer_id, $id)
    {
        try {
            $address = Address::where('customer_id', $customer_id)->findOrFail($id);
            return $this->sendResponse($address, 'Address retrieved successfully');
        } catch (\Throwable $th) {
            return $this->sendResponse([], $th->getMessage(), $th->getCode() ?: 500);
        }
    }

    public function update(Request $request, $customer_id, $id)
    {
        try {
            $address = Address::where('customer_id', $customer_id)->findOrFail($id);
            $validated = $request->validate([
                'address' => 'string',
                'district' => 'string',
                'city' => 'string',
                'province' => 'string',
                'postal_code' => 'integer',
            ]);

            $address->update($validated);
            return $this->sendResponse($address, 'Address updated successfully');
        } catch (\Throwable $th) {
            return $this->sendResponse([], $th->getMessage(), $th->getCode() ?: 500);
        }
    }

    public function destroy($customer_id, $id)
    {
        try {
            Address::where('customer_id', $customer_id)->findOrFail($id)->delete();
            return $this->sendResponse(null, 'Address deleted successfully', 200);
        } catch (\Throwable $th) {
            return $this->sendResponse([], $th->getMessage(), $th->getCode() ?: 500);
        }
    }
}
