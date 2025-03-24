<?php
namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

final class CategoryController
{
    public function categories(){
        $categories = Category::all();
        return view('admin.dynamcomps.categories', compact('categories'));
    }
    public function addCategory(Request $request){
        $input = $request->validate([
            'category_name' => 'required|unique:categories,category_name'
        ],[
            'category_name.required' => 'the field is empty',
            'category_name.unique' =>  'this category already exist'
        ]);

        $category = new Category;
        $category->category_name = $request->category_name;
        $category->save();

        return redirect()->route('categories')->with('success', 'the category is added succefully');
    }
    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255|unique:categories,category_name,'.$id
        ]);

        try {
            $category = Category::findOrFail($id);
            $category->update([
                'category_name' => $request->category_name
            ]);
            if ($request->ajax()) {
                return response()->json([
                    'success' => 'Category updated successfully!'
                ]);
            }
            return redirect()->back()->with('success', 'Category updated successfully!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Error updating category: '
                ], 500);
            }
            return redirect()->back()->with('error', 'Error updating category!');
        }
    }
    public function deleteCategory($id){
        $category = Category::find($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');;
    }
}
