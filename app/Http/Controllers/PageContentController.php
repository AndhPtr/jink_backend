<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageContent;
use App\Models\TextContent;
use App\Models\LinkContent;
use App\Models\ImageContent;

class PageContentController extends Controller
{
    /**
     * Create a new content block.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pages_id' => 'required|exists:pages,id', // Ensure the page exists
            'blockable_type' => 'required|string|in:TextContent,LinkContent,ImageContent', // Validate valid content types
            'data' => 'required|array', // Content-specific data
        ]);

        // Dynamically resolve the blockable model
        $blockableModel = '\\App\\Models\\' . $validated['blockable_type'];

        if (!class_exists($blockableModel)) {
            return response()->json(['error' => 'Invalid blockable type.'], 400);
        }

        // Create the content in the related table (TextContent, LinkContent, or ImageContent)
        $blockable = $blockableModel::create($validated['data']);

        // Attach it to PagesContent
        $pagesContent = PageContent::create([
            'pages_id' => $validated['pages_id'],
            'blockable_id' => $blockable->id,
            'blockable_type' => $blockableModel,
        ]);

        return response()->json($pagesContent->load('blockable'), 201);
    }

    /**
     * Get all content blocks for a specific page.
     */
    public function index($pageId)
    {
        $contentBlocks = PageContent::where('pages_id', $pageId)->with('blockable')->get();

        return response()->json($contentBlocks);
    }

    /**
     * Update a content block.
     */
    public function update(Request $request, $id)
    {
        $pagesContent = PageContent::findOrFail($id);

        $validated = $request->validate([
            'data' => 'required|array', // Contains the updated content-specific data
        ]);

        $blockable = $pagesContent->blockable;

        // Update the related content
        $blockable->update($validated['data']);

        return response()->json($pagesContent->load('blockable'));
    }

    /**
     * Delete a content block.
     */
    public function destroy($id)
    {
        // Find the PageContent by ID
        $pageContent = PageContent::findOrFail($id);

        // Check the blockable type and delete the corresponding content
        $blockable = $pageContent->blockable; // Get the associated content (TextContent, ImageContent, LinkContent)

        if ($blockable) {
            // Delete the blockable content (TextContent, ImageContent, LinkContent)
            $blockable->delete();
        }

        // Now delete the PageContent itself
        $pageContent->delete();

        return response()->json(['message' => 'Content and associated page content deleted successfully.']);
    }
}
