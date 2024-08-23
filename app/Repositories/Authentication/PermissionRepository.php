<?php

namespace App\Repositories\Authentication;

use App\Contracts\Authentication\PermissionInterface;
use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionRepository implements PermissionInterface
{
  protected $model;

  public function __construct(Permission $model)
  {
    $this->model = $model;
  }

  public function paginate(Request $request)
  {
    return $this->model->orderBy('created_at', 'desc')
      ->filter($request->only('search'))
      ->paginate(10)
      ->onEachSide(1)
      ->withQueryString()
      ->through(fn($permission) => [
        'id' => $permission->id,
        'name' => $permission->name,
        'created_at' => $permission->created_at,
      ]);
  }

  public function findAll()
  {
    return $this->model->select('name')->orderBy('name', 'asc')->get();
  }

  public function findById(int|string $id)
  {
    return $this->model->select('id', 'name', 'guard_name', 'created_at')->where('id', $id)->orderBy('created_at', 'desc')->first();
  }

  public function create(string $name)
  {
    return $this->model->create([
      'name' => $name
    ]);
  }

  public function update(string $id, string $name)
  {
    return $this->model->where('id', $id)->update([
      'name' => $name
    ]);
  }

  public function delete(int|string $id)
  {
    return $this->model->where('id', $id)->delete();
  }
}
