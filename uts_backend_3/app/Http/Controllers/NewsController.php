<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    // Method to get all news data
    public function index()
    {
        // Retrieve all news data
        $news = News::all();

        // Check if data is empty
        if ($news->isEmpty()) {
            return response()->json(['message' => 'No news found'], 404);
        }

        // Return response with data
        return response()->json([
            'data' => $news,
            'message' => 'Successfully retrieved all news data'
        ], 200);
    }

    // Method to add a new news entry
    public function store(Request $request)
    {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
            'content' => 'required|string',
            'url' => 'required|url|unique:news',
            'url_image' => 'required|url',
            'published_at' => 'required|date',
            'category' => 'required|string'
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid or incomplete data', 'errors' => $validator->errors()], 400);
        }

        // Create new news entry
        $news = News::create($request->all());

        // Return success response
        return response()->json([
            'message' => 'News successfully added',
            'data' => $news
        ], 201);
    }

    // Method to update an existing news entry
    public function update(Request $request, $id)
    {
        // Find news entry by ID
        $news = News::find($id);

        // If news not found
        if (!$news) {
            return response()->json(['message' => 'News not found'], 404);
        }

        // Validate input data for PUT request (all fields required)
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
            'content' => 'required|string',
            'url' => 'required|url|unique:news,url,' . $id,
            'url_image' => 'required|url',
            'published_at' => 'required|date',
            'category' => 'required|string'
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json(['message' => 'Incomplete data. Please fill in all required fields!', 'errors' => $validator->errors()], 400);
        }

        // Update news entry
        $news->update($request->all());

        // Return success response
        return response()->json([
            'message' => 'News data successfully updated',
            'data' => $news
        ], 200);
    }

    // Method for partial update (PATCH)
    public function partialUpdate(Request $request, $id)
    {
        // Find news entry by ID
        $news = News::find($id);

        // If news not found
        if (!$news) {
            return response()->json(['message' => 'News not found'], 404);
        }

        // Validate input data for PATCH request (not all fields required)
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string',
            'author' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'content' => 'sometimes|required|string',
            'url' => 'sometimes|required|url|unique:news,url,' . $id,
            'url_image' => 'sometimes|required|url',
            'published_at' => 'sometimes|required|date',
            'category' => 'sometimes|required|string'
        ]);

        // If validation fails
        if ($validator->fails()) {
            return response()->json(['message' => 'Incomplete data. Please fill in all required fields!', 'errors' => $validator->errors()], 400);
        }

        // Update only the given fields
        $news->update($request->only(['title', 'author', 'description', 'content', 'url', 'url_image', 'published_at', 'category']));

        // Return success response
        return response()->json([
            'message' => 'News data partially updated',
            'data' => $news
        ], 200);
    }

    // Method to delete a news entry
    public function destroy($id)
    {
        // Find news entry by ID
        $news = News::find($id);

        // If news not found
        if (!$news) {
            return response()->json(['message' => 'News not found'], 404);
        }

        // Delete news entry
        $news->delete();

        // Return success response
        return response()->json([
            'message' => 'News successfully deleted',
            'data' => $news
        ], 200);
    }

    // Method to search news by title
    public function search($title)
    {
        // Search for news by title
        $news = News::where('title', 'like', '%' . $title . '%')->get();

        // If no news found
        if ($news->isEmpty()) {
            return response()->json(['message' => 'No news found with that title'], 404);
        }

        // Return success response
        return response()->json([
            'message' => 'Successfully retrieved news by title',
            'data' => $news
        ], 200);
    }

    // Method to get news in the "sport" category
    public function sport()
    {
        $news = News::where('category', 'sport')->get();

        // If no news found in the category
        if ($news->isEmpty()) {
            return response()->json(['message' => 'No news found in the sport category'], 404);
        }

        return response()->json([
            'message' => 'Successfully retrieved sport news',
            'data' => $news
        ], 200);
    }

    // Method to get news in the "finance" category
    public function finance()
    {
        $news = News::where('category', 'finance')->get();

        // If no news found in the category
        if ($news->isEmpty()) {
            return response()->json(['message' => 'No news found in the finance category'], 404);
        }

        return response()->json([
            'message' => 'Successfully retrieved finance news',
            'data' => $news
        ], 200);
    }

    // Method to get news in the "automotive" category
    public function automotive()
    {
        $news = News::where('category', 'automotive')->get();

        // If no news found in the category
        if ($news->isEmpty()) {
            return response()->json(['message' => 'No news found in the automotive category'], 404);
        }

        return response()->json([
            'message' => 'Successfully retrieved automotive news',
            'data' => $news
        ], 200);
    }
}
