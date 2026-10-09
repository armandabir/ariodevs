<?php

namespace App\Http\Controllers;

use App\Models\ContactRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactRequestController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactRequest::create($validated);

        return response()->json(['message' => 'درخواست شما ثبت شد.'], 201);
    }

    public function index(): View
    {
        $requests = ContactRequest::latest()->paginate(25);

        return view('admin.contact-requests', compact('requests'));
    }
}