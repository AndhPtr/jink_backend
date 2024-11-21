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
            'pages_id' => 'required|exists:pages_content,id',
            'blockable_type' => 'required|string|in:TextContent,LinkContent,ImageContent',
            'data' => 'required|array', // Contains the content-specific data
        ]);

        $blockableModel = '\\App\\Models\\' . $validated['blockable_type'];

        if (!class_exists($blockableModel)) {
            return response()->json(['error' => 'Invalid blockable type.'], 400);
        }

        // Create the content in the related table
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
        $pagesContent = PageContent::findOrFail($id);

        // Delete the related blockable content
        $pagesContent->blockable->delete();

        // Delete the PagesContent record
        $pagesContent->delete();

        return response()->json(['message' => 'Content deleted successfully.']);
    }
}
