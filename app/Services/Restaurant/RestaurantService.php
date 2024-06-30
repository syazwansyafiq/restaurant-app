<?php

namespace App\Services\Restaurant;

use App\Models\Restaurant;

class RestaurantService
{
    public function index()
    {
        return Restaurant::all();
    }

    public function query($request)
    {
        // add filter and pagination
        $limit = $request->has('limit') ? $request->limit : 10;
        $page = $request->has('page') ? $request->page : 1;

        $offset = ($page - 1) * $limit;

        $query = $this->filter($request);
        $query = $query->offset($offset)->limit($limit);
        $query = $query->get();
        return $query;
    }

    public function filter($request)
    {
        $query = Restaurant::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->has('country')) {
            $query->where('country', 'like', '%' . $request->country . '%');
        }

        if ($request->has('address')) {
            $query->where('address', 'like', '%' . $request->address . '%');
        }

        if ($request->has('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->has('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->has('description')) {
            $query->where('description', 'like', '%' . $request->description . '%');
        }

        if($request->category) {
            $query->where('category', 'like', '%' . $request->category . '%');
        }

        return $query;
    }

    public function show($id)
    {
        return Restaurant::findOrFail($id);
    }

    public function store($request)
    {
        return Restaurant::create($request->all());
    }

    public function update($request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->update($request->all());
        return $restaurant;
    }


    public function destroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->delete();
        return $restaurant;
    }

    public function approveRestaurant($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->update(['status' => 'active']);
        return response()->json(['message' => 'Restaurant approved successfully.']);
    }


    public function banRestaurant($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->update(['status' => 'banned']);
        return response()->json(['message' => 'Restaurant banned successfully.']);
    }
}
