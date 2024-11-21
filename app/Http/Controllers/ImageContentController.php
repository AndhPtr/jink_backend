<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImageContent;

class ImageContentController extends Controller
{
    /**
     * Store a new image content.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url',
            'alt_text' => 'required|string|max:255',
        ]);

        $imageContent = ImageContent::create($validated);

        return response()->json($imageContent, 201);
    }

    /**
     * Get all image content.
     */
    public function index()
    {
        $imageContents = ImageContent::all();
        return response()->json($imageContents);
    }

    /**
     * Update image content.
     */
    public function update(Request $request, $id)
    {
        $imageContent = ImageContent::findOrFail($id);

        $validated = $request->validate([
            'url' => 'sometimes|url',
            'alt_text' => 'sometimes|string|max:255',
        ]);

        $imageContent->update($validated);

        return response()->json($imageContent);
    }

    /**
     * Delete image content.
     */
    public function destroy($id)
    {
        $imageContent = ImageContent::findOrFail($id);
        $imageContent->delete();

        return response()->json(['message' => 'Image content deleted successfully.']);
    }
}
