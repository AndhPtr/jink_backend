<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TextContent;

class TextContentController extends Controller
{
    /**
     * Store a new text content.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $textContent = TextContent::create($validated);

        return response()->json($textContent, 201);
    }

    /**
     * Get all text content.
     */
    public function index()
    {
        $textContents = TextContent::all();
        return response()->json($textContents);
    }

    /**
     * Update text content.
     */
    public function update(Request $request, $id)
    {
        $textContent = TextContent::findOrFail($id);

        $validated = $request->validate([
            'content' => 'sometimes|string',
        ]);

        $textContent->update($validated);

        return response()->json($textContent);
    }

    /**
     * Delete text content.
     */
    public function destroy($id)
    {
        $textContent = TextContent::findOrFail($id);

        // Delete associated PageContent
        $textContent->pageContent()->delete(); // Assuming the relationship is set up in the model

        // Delete the TextContent record
        $textContent->delete();

        return response()->json(['message' => 'Text content and associated PageContent deleted successfully.']);
    }
}
