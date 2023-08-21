<?php

namespace App\Services;

use App\Models\Issue;
use App\Models\Category;
use App\Http\Resources\IssueResource;
use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use Illuminate\Validation\ValidationException;

class IssueService
{
    protected $category;
    public function __construct()
    {
    }

    public function create(StoreIssueRequest $request)
    {

        try {

            $category = $this->fetchOrCreateCategory($request->category,$request->new_category);
            $this->validateCategory($category);

            $issue = Issue::create(array_merge($request->except(['category','new_category']), ['category_id' => $category->id]));

            return response()->json([
                'status' => 'success',
                'issue' => new IssueResource($issue)
            ]);
        } catch (\Exception $e) {
            logger(' Error storing issue' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error storing ' . $e->getMessage(),
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $issue = Issue::findOrFail($id);
            return response()->json([
                'status' => 'success',
                'issue' => new IssueResource($issue)
            ]);
        } catch (\Exception $e) {
            logger(' Error finding issue ' . $id . ' ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Issue not found',
            ], 400);
        }
    }

    public function update(UpdateIssueRequest $request, $id)
    {
        try {
            $issue = Issue::with('category')->findOrFail($id);

            $category = $this->fetchOrCreateCategory($request->category,$request->new_category);
            $this->validateCategory($category);
            $issue->update(array_merge($request->except(['category','new_category']), ['category_id' => $category->id]));

            return response()->json([
                'status' => 'success',
                'issue' => new IssueResource($issue)
            ]);
        } catch (\Exception $e) {
            logger(' Error updating issue ' . $id . ' ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error updating',
            ], 400);
        }
    }

    public function delete($id)
    {
        try {
            $issue = Issue::findOrFail($id)->delete();
            return response()->json([
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            logger(' Error deleting issue ' . $id . ' ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting',
            ], 400);
        }
    }

    private function fetchOrCreateCategory($category,$new_category)
    {
        if ($category != '') {
            $category = Category::find($category);
            if (!$category) {
                return false;
            }
        }

        if ($new_category != '') {
            $category = Category::updateOrCreate(['name'=> $new_category],['name'=> $new_category]);
        }
        return $category;
    }

    private function validateCategory($category)
    {
        if (!$category) {
            throw ValidationException::withMessages(['category' => 'Category not found']);
        }
    }
}
