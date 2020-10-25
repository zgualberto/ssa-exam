<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\Users as UsersResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;

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
        return view('users/index', array('users' => User::all()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('users/show', array('user' => User::find($id)));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

        if ($this->validator((array) $request->all(), $id) !== false) {
            $user->prefixname = $request->input('prefixname');
            $user->firstname = $request->input('firstname');
            $user->middlename = $request->input('middlename');
            $user->lastname = $request->input('lastname');
            $user->suffixname = $request->input('suffixname');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));

            if($user->save()) {
                return new UsersResource($user);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();

        return new UsersResource($user);
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
            return Validator::make($data, [
                'prefixname' => ['required', Rule::in($this->prefixnames)],
                'firstname' => ['required', 'string', 'max:255'],
                'middlename' => ['string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'suffixname' => ['string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users', 'id', $id],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users','id', $id],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        } else {
            return Validator::make($data, [
                'prefixname' => ['required', Rule::in($this->prefixnames)],
                'firstname' => ['required', 'string', 'max:255'],
                'middlename' => ['string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'suffixname' => ['string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
        }
    }
}
