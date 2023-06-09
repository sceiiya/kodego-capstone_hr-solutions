<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\PointsModel;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {   
        $employee = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $pointsModel = new PointsModel();
        $pointsModel->employee_id = $employee->id;
        $pointsModel->save();

        Session::push('user', [
            'name' => $data['first_name'].' '.$data['last_name'],
            'email' => $data['email'],
            'Mid' => $employee->id,
            'Mfirst_name' => $data['first_name'],
            'Mlast_name' => $data['last_name'],
            'Mmiddle_name' => $employee->middle_name,
            'Musername' => $employee->username,
            'Memail' => $data['email'],
            'Mphone_number' => $employee->phone_number,
            'Mapplied_at' => $employee->applied_at,
            'Mjoined_at' => $employee->joined_at,
            'Mstatus' => $employee->status,
            'Mprofile_pic' => $employee->profile_pic,
            'Mjob_position' => $employee->job_position,
            'Mjob_type' => $employee->job_type,
            'Mcountry' => $employee->country,
            'Mcity' => $employee->city,
            'Mprovince_state' => $employee->province_state,
            'Mstreet' => $employee->street,
            'Mpostal_id' => $employee->postal_id,
            'Memail_verified_at' => $employee->email_verified_at,
    
        ]);

        return $employee;
    }

}
