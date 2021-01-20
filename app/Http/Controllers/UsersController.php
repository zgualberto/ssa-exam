<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\Users as UsersResource;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{

    protected $prefixnames = ['Mr', 'Mrs', 'Ms'];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users/list', array(
            'users' => User::paginate(15),
            'actions' => ['show', 'edit', 'delete'],
            'caption' => 'Active Users'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->validator((array) $request->all())) {

            $user = new User;
            if (!empty($request->input('photo'))) {
                if (preg_match('/^data:image\/(\w+);base64,/', $request->input('photo'))) {
                    $data = substr($request->input('photo'), strpos($request->input('photo'), ',') + 1);
        
                    $data = base64_decode($data);
                    Storage::disk('public')->put($request->input('photo_filename'), $data);
                }
            }

            $user->prefixname = $request->input('prefixname');
            $user->firstname = $request->input('firstname');
            $user->middlename = $request->input('middlename');
            $user->lastname = $request->input('lastname');
            $user->suffixname = $request->input('suffixname');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            if (!empty($request->input('photo'))) {
                $user->photo = $request->input('photo_filename');
            }
            if (!empty($request->input('password'))) {
                $user->password = Hash::make($request->input('password'));
            }

            if($user->save()) {
                return new UsersResource($user);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return view('users/show', array(
            'user' => User::find($id)
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        return view('users/edit', array('user' => User::find($id)));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Get user
        $user = User::findOrFail($id);

        if (!empty($request->input('photo'))) {
            if (preg_match('/^data:image\/(\w+);base64,/', $request->input('photo'))) {
                $data = substr($request->input('photo'), strpos($request->input('photo'), ',') + 1);

                $data = base64_decode($data);
                Storage::disk('public')->put($request->input('photo_filename'), $data);
            }
        }

        if ($this->validator((array) $request->all(), $id)) {
            $user->prefixname = $request->input('prefixname');
            $user->firstname = $request->input('firstname');
            $user->middlename = $request->input('middlename');
            $user->lastname = $request->input('lastname');
            $user->suffixname = $request->input('suffixname');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            if (!empty($request->input('password'))) {
                $user->password = Hash::make($request->input('password'));
            }
            if (!empty($request->input('photo'))) {
                $user->photo = $request->input('photo_filename');
            }

            if($user->save()) {
                return new UsersResource($user);
            }
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(int $id)
    {
        $user = User::onlyTrashed()->where('id', $id)->restore();
        $users = User::onlyTrashed();


        return UsersResource::collection($users->paginate(15));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        User::find($id)->delete();

        return UsersResource::collection(User::paginate(15));
    }

    /**
     * Force remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(int $id)
    {
        User::onlyTrashed()->where('id', $id)->forceDelete();
        $users = User::onlyTrashed();

        return UsersResource::collection($users->paginate(15));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $users = User::onlyTrashed();

        return view('users/list', array(
            'users' => $users->paginate(15),
            'actions' => ['restore', 'force-delete'],
            'caption' => 'Trashed Users'
        ));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @param int $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $id = null)
    {
        if (!empty($id)) {
            $usernameValidator = ['required', 'string', 'max:255', 'unique:users', 'id', $id];
            $emailValidator = ['required', 'string', 'email', 'max:255', 'unique:users','id', $id];
        } else {
            $usernameValidator = ['required', 'string', 'max:255', 'unique:users'];
            $emailValidator = ['required', 'string', 'email', 'max:255', 'unique:users'];
        }

        return Validator::make($data, [
            'prefixname' => ['required', Rule::in($this->prefixnames)],
            'firstname' => ['required', 'string', 'max:255'],
            'middlename' => ['string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'suffixname' => ['string', 'max:255'],
            'username' => $usernameValidator,
            'email' => $emailValidator,
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
