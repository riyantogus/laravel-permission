<?php

namespace App\Contracts\Authentication;

use Illuminate\Http\Request;

interface RoleInterface
{
  public function paginate(Request $request);
  public function findAll();
  public function findWithPermissions();
  public function findById(int | string $id);
  public function create(string $name);
  public function update(string $id, string $name);
  public function delete(int | string $id);
}
