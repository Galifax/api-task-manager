<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'parent_id',
        'content'
    ];

    public function childTasks()
    {
        return $this->hasMany($this, 'parent_id', 'id');
    }

    public function parentTask()
    {
        return $this->hasOne($this, 'id', 'id_parent_id');
    }

    public function getUserTasks($userId, $paginate = 20)
    {
        return Task::where('user_id', $userId)
                ->where('parent_id', 0)
                ->latest('id')
                ->with('childTasks')
                ->paginate($paginate);;
    }

    public function newTask($request, $userId)
    {
        $input = $request->all();
        $input['user_id'] = $userId;
        $task = self::create($input);
        $task->save();
        return $task;
    }

    public function showTask($id)
    {
        $task = self::where('id', $id)
                 ->with('childTasks')
                 ->get();
        return $task;
    }

    public function updateTask($request, $userId)
    {
        $input = $request->all();
        $input['user_id'] = $userId;
        $task = self::find($userId);
        $task->fill($input);
        $task->save();
        return $task;
    }

    public function deleteTask($id)
    {
        $task = self::find($id);
        $task->delete();
        return $task;
    }
}
