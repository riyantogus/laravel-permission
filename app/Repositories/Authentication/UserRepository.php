<?php

namespace App\Repositories\Authentication;

use App\Contracts\Authentication\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserRepository implements UserInterface
{
  protected $model;

  public function __construct(User $model)
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
      ->through(fn($user) => [
        'id' => $user->id,
        'name' => $user->name,
        'username' => $user->username,
        'email' => $user->email,
        'status' => $user->status,
        'created_at' => $user->created_at,
      ]);
  }

  public function findById(int|string $id)
  {
    return $this->model->select('id', 'name', 'username', 'email', 'created_at')->where('id', $id)->orderBy('created_at', 'desc')->first();
  }

  public function create(object $request)
  {
    return $this->model->create([
      'name' => $request->name,
      'username' => $request->username,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);
  }

  public function update(string $id, object $request)
  {
    return $this->model->where('id', $id)->update([
      'name' => $request->name,
      'email' => $request->email,
    ]);
  }

  public function resetPassword(string $id, object $request)
  {
    return $this->model->where('id', $id)->update([
      'password' => Hash::make($request->password),
    ]);
  }

  public function delete(int|string $id)
  {
    return $this->model->where('id', $id)->delete();
  }
}
