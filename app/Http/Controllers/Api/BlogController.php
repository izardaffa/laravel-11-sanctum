<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends BaseController
{
    public function index(): JsonResponse
    {
        $blogs = Blog::all();

        return $this->sendResponse(BlogResource::collection($blogs), 'Blogs retrieved successfully.');
    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'detail' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation error.', $validator->errors());
        }

        $blog = Blog::create($input);

        return $this->sendResponse(new BlogResource($blog), 'Blog created successfully.');
    }

    public function show($id): JsonResponse
    {
        $blog = Blog::find($id);

        if (is_null($blog)) {
            return $this->sendError('Blog not found.');
        }

        return $this->sendResponse(new BlogResource($blog), 'Blog retrieved successfully.');
    }

    public function update(Request $request, Blog $blog): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'detail' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation error.', $validator->errors());
        }

        $blog->title = $input['title'];
        $blog->detail = $input['detail'];
        $blog->save();

        return $this->sendResponse(new BlogResource($blog), 'Blog updated successfully.');
    }

    public function destroy(Blog $blog): JsonResponse
    {
        $blog->delete();

        return $this->sendResponse([], 'Blog deleted successfully.');
    }
}
