<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class Project extends Model
{
    protected $table = "projects";
    protected $primaryKey = "id";
    public $incrementing = false;


    public function getProject()
    {
        try {
            $result = $this->all();
            if (count($result) > 0) {
                return $result;
            }
            return null;
        } catch (QueryException $ex) {
            Log::info("ProjectModel Error", ["getProject" => $ex->getMessage(), "line" => $ex->getLine()]);
            return null;
        }
    }

    public function addProject($name,$budget)
    {
        try {
            $this->name = $name;
            $this->budget = $budget;
            if ($this->save()) {
                return true;
            }
            return false;
        } catch (QueryException $ex) {
            Log::info("ProjectModel Error", ["addProject" => $ex->getMessage(), "line" => $ex->getLine()]);
            return false;
        }
    }

    public function getSingleProject($id)
    {
        try {
            $result = $this->where('id', $id)->first();
            if (isset($result) & !empty($result)) {
                return $result;
            }
            return null;
        } catch (QueryException $ex) {
            Log::info("ProjectModel Error", ["getSingleProject" => $ex->getMessage(), "line" => $ex->getLine()]);
            return null;
        }
    }

    public function updateProject($id, $name, $budget)
    {
        try {
            $result = $this->where('id', $id)
                ->update(['name' => $name, 'budget' => $budget]);
            if ($result) {
                return true;
            }
            return false;
        } catch (QueryException $ex) {
            Log::info("ProjectModel Error", ["addProject" => $ex->getMessage(), "line" => $ex->getLine()]);
            return false;
        }
    }

    public function deleteProject($id)
    {
        try {
            $result = $this->where('id', $id)->delete();
            if ($result) {
                return true;
            }
            return false;
        } catch (QueryException $ex) {
            Log::info("ProjectModel Error", ["deleteProject" => $ex->getMessage(), "line" => $ex->getLine()]);
            return false;
        }
    }

}
