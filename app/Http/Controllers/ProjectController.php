<?php

namespace App\Http\Controllers;

use App\Classes\ProjectClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Project;

class ProjectController extends Controller
{
    private $product;
    public function __construct(ProjectClass $product)
    {
        $this->product = $product;
    }
    public function getProject()
    {
        return $this->product->getProject();
    }
    public function addProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'budget' => 'required'
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'message' => $error])->setStatusCode(400);
        }
        $name = $request->name;
        $budget = $request->budget;
        return $this->product->addProject($name,$budget);
    }
    public function getSingleProject($id)
    {
        return $this->product->getSingleProject($id);
    }
    public function updateProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required|string',
            'budget' => 'required'
        ]);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json(['status' => false, 'message' => $error])->setStatusCode(400);
        }
        $id = $request->id;
        $name = $request->name;
        $budget = $request->budget;
        return $this->product->updateProject($id,$name, $budget);
    }
    public function deleteProject($id)
    {
        return $this->product->deleteProject($id);
    }
}
