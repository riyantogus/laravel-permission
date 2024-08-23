<?php

namespace App\Contracts\Authentication;

use Illuminate\Http\Request;

interface UserInterface
{
  public function paginate(Request $request);
  public function findById(int | string $id);
  public function create(object $request);
  public function update(string $id, object $request);
  public function resetPassword(string $id, object $request);
  public function delete(int | string $id);
}
