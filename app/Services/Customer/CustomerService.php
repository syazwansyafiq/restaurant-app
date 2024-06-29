<?php

namespace App\Services\Restaurant;

use App\Models\User;

class CustomerService
{
    public function __construct()
    {

    }

    public function index()
    {
        return User::where('role', 'customer')->get();
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
        $query = User::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
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

        if ($request->has('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->has('address')) {
            $query->where('address', 'like', '%' . $request->address . '%');
        }

        if ($request->has('description')) {
            $query->where('description', 'like', '%' . $request->description . '%');
        }

        return $query;
    }
}
