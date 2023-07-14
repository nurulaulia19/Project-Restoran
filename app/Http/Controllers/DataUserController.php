<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use App\Models\DataUser;
use Illuminate\Http\Request;

class DataUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $dataUser = DataUser::all();
        // $dataUser->each(function ($user) {
        //     $user->user_photo = asset('storage/photos/'.$user->user_photo);
        // });
        // return view('user', compact('dataUser'));
        $dataUser = DataUser::all();
        return view('user', compact('dataUser'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $User = DB::table('data_user')->select('*')->where('menu_category','master menu')->get();
        $dataRole = Role::all();
        $dataUser = DataUser::all();
        return view('user.create', compact('dataUser','dataRole'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_password' => [
                'required',
                'string',
                'min:6',
                'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\#?!@$%^&*-]).{6,}$/'
            ],
            'user_photo' => 'required|file|mimes:jpeg,jpg,png',
            // Tambahkan aturan validasi lainnya sesuai kebutuhan
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        if ($request->hasFile('user_photo')) {
            $fileName = $request->file('user_photo')->store('public/photos');
        } else {
            $fileName = null;
        }
    
        $dataUser = new DataUser;
        $dataUser->user_id = $request->user_id;
        $dataUser->user_name = $request->user_name;
        $dataUser->user_email = $request->user_email;
        $dataUser->user_password = $request->user_password;
        $dataUser->user_gender = $request->user_gender;
        $dataUser->user_photo = $fileName;
        $dataUser->role_id = $request->role_id;
        $dataUser->user_token = $request->user_token;
        $dataUser->save();
    
        return redirect()->route('user')->with('success', 'User inserted successfully');

       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user_id)
    {
        $dataRole = Role::all();
        $dataUser = DataUser::where('user_id', $user_id)->first();
        return view('user.update', compact('dataUser','dataRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user_id){

        $validator = Validator::make($request->all(), [
            'user_password' => [
                'required',
                'string',
                'min:6',
                'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[\#?!@$%^&*-]).{6,}$/'
            ],

            'user_photo' => 'required|file|mimes:jpeg,jpg,png'
             
            // Tambahkan aturan validasi lainnya sesuai kebutuhan
        ]);

    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('data_user')->where('user_id', $user_id)->update([
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_password' => $request->user_password,
            'user_gender' => $request->user_gender,
            // 'user_photo' => $request->user_photo,
            'role_id' => $request->role_id,
            'user_token' => $request->user_token,
            'created_at' => now(),
            'updated_at' => now()
    ]);

    if ($request->hasFile('user_photo')) {
        $fileName = $request->file('user_photo')->store('public/photos');
        $data['user_photo'] = $fileName;
    }


    

    return redirect()->route('user')->with('success', 'User edited successfully');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_id)
    {
        $dataUser = DataUser::where('user_id', $user_id);
        $dataUser->delete();
        return redirect()->route('user')->with('success', 'Terdelet');
    }
}
