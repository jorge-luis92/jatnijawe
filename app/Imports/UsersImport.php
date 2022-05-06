<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    public function model(array $row)
    {
        return new User([
           'id'     => $row[0],
           'name'     => $row[1],
           'email'    => $row[2],
           'password' => Hash::make($row[3]),
           'tipo_usuario'    => $row[4],
        ]);
    }
}
