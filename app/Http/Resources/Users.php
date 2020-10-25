<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Users extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        // return [
        //     'id' => $this->id,
        //     'prefixname' => $this->prefixname,
        //     'firstname' => $this->firstname,
        //     'middlename' => $this->middlename,
        //     'lastname' => $this->lastname,
        //     'suffixname' => $this->suffixname,
        //     'username' => $this->username,
        //     'email' => $this->email,
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at,
        //     'deleted_at' => $this->deleted_at,
        //     'photo' => $this->photo,
        // ];
    }
}
