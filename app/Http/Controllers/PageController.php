<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use Illuminate\Http\Request;

class PageController extends Controller
{
    // Constructor for authentication middleware if needed
    public function __construct()
    {
        $this->middleware('auth:sanctum'); // Ensure only authenticated users can access pages
    }

    // Display a listing of the pages
    public function index()
    {
        // Return all pages with their associated user and content
        $pages = Pages::with('user', 'pageContent')->get();
        return response()->json($pages, 200);
    }

    // Show the form for creating a new page
    public function create()
    {
        // This can be used for frontend to display form (optional for APIs)
        return response()->json(['message' => 'Show form to create a new page'], 200);
    }

    // Store a newly created page in storage
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
        ]);

        // Create a new page
        $page = Pages::create($validated);

        return response()->json(['message' => 'Page created successfully', 'data' => $page], 201);
    }

    // Display the specified page
    public function show($id)
    {
        // Find the page by ID and load its related content and user
        $page = Pages::with('user', 'pageContent')->findOrFail($id);

        return response()->json($page, 200);
    }

    // Show the form for editing the specified page (optional for API)
    public function edit($id)
    {
        // Can be used for frontend to display an edit form
        $page = Pages::findOrFail($id);
        return response()->json($page, 200);
    }

    // Update the specified page in storage
    public function update(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
        ]);

        // Find the page and update
        $page = Pages::findOrFail($id);
        $page->update($validated);

        return response()->json(['message' => 'Page updated successfully', 'data' => $page], 200);
    }

    // Remove the specified page from storage
    public function destroy($id)
    {
        // Find the page and delete
        $page = Pages::findOrFail($id);
        $page->delete();

        return response()->json(['message' => 'Page deleted successfully'], 200);
    }
}
