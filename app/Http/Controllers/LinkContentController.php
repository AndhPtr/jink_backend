<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LinkContent;

class LinkContentController extends Controller
{
    /**
     * Store a new link content.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url',
            'label' => 'required|string|max:255',
        ]);

        $linkContent = LinkContent::create($validated);

        return response()->json($linkContent, 201);
    }

    /**
     * Get all link content.
     */
    public function index()
    {
        $linkContents = LinkContent::all();
        return response()->json($linkContents);
    }

    /**
     * Update link content.
     */
    public function update(Request $request, $id)
    {
        $linkContent = LinkContent::findOrFail($id);

        $validated = $request->validate([
            'url' => 'sometimes|url',
            'label' => 'sometimes|string|max:255',
        ]);

        $linkContent->update($validated);

        return response()->json($linkContent);
    }

    /**
     * Delete link content.
     */
    public function destroy($id)
    {
        $linkContent = LinkContent::findOrFail($id);

        // Delete associated PageContent
        $linkContent->pageContent()->delete(); // Assuming the relationship is set up in the model

        // Delete the LinkContent record
        $linkContent->delete();

        return response()->json(['message' => 'Link content and associated PageContent deleted successfully.']);
    }
}
