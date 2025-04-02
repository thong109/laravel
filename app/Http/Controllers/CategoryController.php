<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return CategoryResource::collection(
            Category::orderBy('id', 'desc')->paginate(10)
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $user = $request->user();
        if (!$user) {
            return abort(403, 'Unauthorized action.');
        }
        $data = $request->validated();
        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
        }
        $category = Category::create($data);
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category, Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return abort(403, 'Unauthorized action.');
        }

        return new CategoryResource($category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            $relativePath = $this->saveImage($data['image']);
            $data['image'] = $relativePath;
        }

        $category->update($data);

        // $exitstingIds = $category->

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return abort(403, 'Unauthorized action.');
        }

        $category->delete();

        if ($category->image) {
            $absolutePath = public_path($category->image);
            File::delete($absolutePath);
        }

        return response('', 204);
    }

    private function saveImage($image)
    {
        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            $image = substr($image, strpos($image, ',') + 1);
            $type = strtolower($type[1]);

            if (!in_array($type, array('jpg', 'jpeg', 'png', 'gif'))) {
                throw new \Exception('Invalid image type');
            }
            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);

            if ($image === false) {
                throw new \Exception('base64_decode failed');
            }
        } else {
            throw new \Exception('Did not match data URL with image data.');
        }

        // Convert the decoded image back to base64
        $base64Image = base64_encode($image);

        // Add the data URI prefix back to the base64 string
        $dataUri = 'data:image/' . $type . ';base64,' . $base64Image;

        return $dataUri; // Return the full data URI
    }

    // public function createQuestion($data)
    // {
    //     if (in_array($data['data'])) {
    //         $data['data'] = json_encode($data['data']);
    //     }

    //     $validator = Validator::make($data, [
    //         'question' => 'required|string',
    //         'type' => ['required', new Enum(QuestionTypeEnum::class)],
    //         'description' => 'required|string',
    //         'data' => 'present',
    //         'survey_id' => 'exists:Survay::class, id'
    //     ]);

    //     return SurveyQuestion::create($validator->validated());
    // }

    public function search(Request $request)
    {
        $searchValue = $request->query('n');
        $categories = Category::where('name', 'LIKE', '%' . $searchValue . '%')
            ->orWhere('slug', 'LIKE', '%' . $searchValue . '%')
            ->get();

        return CategoryResource::collection($categories);
    }

    public function changeStatus(Request $request)
    {
        $category = Category::find($request->id);
        if (!$category) {
            return response()->json([
                'message' => 'Category not found.'
            ], 404);
        }
        $category->status = $request->status;
        $category->save();
        return new CategoryResource($category);
    }
}
