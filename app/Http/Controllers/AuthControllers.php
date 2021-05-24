<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\MemberStoreRequest;
use App\Http\Requests\LoginStoreRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\MySendPasswordMail;

class AuthControllers extends Controller
{
    //
    public function register(MemberStoreRequest  $request)
    {
        $fields = $request->validated();

        $fields['status'] = isset($fields['status']) ? $fields['status'] : 'active';
        $fields['user_type'] = isset($fields['user_type']) ? $fields['user_type'] : 'thirdparty';
        $getuser = Member::where('email', $fields['email'])->first();
        $user = Member::create([
            'firstname' => $fields['firstname'],
            'lastname' => $fields['lastname'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'status' => $fields['status'],
            'position' => $fields['position'],
            'user_type' => $fields['user_type'],
            'name' => isset($fields['name']) ? $fields['name'] : null,
            'picture' => isset($fields['picture']) ? $fields['picture'] : null,
            'phone' => isset($fields['phone']) ? $fields['phone'] : null,
            'birthday' => isset($fields['birthday']) ? $fields['birthday'] : null,
            'gender' => isset($fields['gender']) ? $fields['gender'] : null,
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response, 201);
    }

    public function login(LoginStoreRequest  $request)
    {
        $fields = $request->validated();

        $user = Member::where('email', $fields['email'])->first();
        // dd($fields);
        if ($fields['user_type'] !== 'thirdparty' && $fields['user_type'] !== 'other') {

            $fields['status'] = isset($fields['status']) ? $fields['status'] : 'active';
            $fields['user_type'] = isset($fields['user_type']) ? $fields['user_type'] : 'thirdparty';

            if (!$user) {
                // dd($fields['id_sso']);
                $string = $this->rand_Pass();
                $pass   = strtoupper(md5(str_replace(" ", "", $string)));
                $addUser = Member::create([
                    'firstname' => $fields['firstname'],
                    'lastname' => $fields['lastname'],
                    'email' => $fields['email'],
                    'password'        => bcrypt($pass),
                    'status' => $fields['status'],
                    'position' => $fields['position'],
                    'user_type' => $fields['user_type'],
                    'id_sso' => $fields['id_sso'],
                    'name' => isset($fields['name']) ? $fields['name'] : null,
                    'picture' => isset($fields['picture']) ? $fields['picture'] : null,
                    'phone' => isset($fields['phone']) ? $fields['phone'] : null,
                    'birthday' => isset($fields['birthday']) ? $fields['birthday'] : null,
                    'gender' => isset($fields['gender']) ? $fields['gender'] : null,
                ]);
                $token = $addUser->createToken('myapptoken')->plainTextToken;

                $response = [
                    'user' => $addUser,
                    'token' => $token
                ];
                $detailss = ['password' => $pass];
                Mail::to($fields['email'])->send(new MySendPasswordMail($detailss));
                return  response()->json($response, 200);
            } else {
                $token = $user->createToken('myapptoken')->plainTextToken;

                if (!Hash::check($fields['password'], $user->password)) {
                    return  response()->json(['message' => 'Password is incorrect'], 401);
                } else if ($user->status === 'inactive') {
                    return  response()->json(['message' => 'Your account is inactive'], 401);
                } else {


                    $response = [
                        'user' => $user,
                        'token' => $token
                    ];

                    return response()->json($response, 200);
                }
            }
        } else {
            if (!$user) {
                return response()->json(['message' => 'Email Address is not registered.'], 401);
            } else  if (!Hash::check($fields['password'], $user->password)) {
                return  response()->json(['message' => 'Password is incorrect'], 401);
            } else if ($user->status === 'inactive') {
                return  response()->json(['message' => 'Your account is inactive'], 401);
            } else {
                $token = $user->createToken('myapptoken')->plainTextToken;

                $response = [
                    'user' => $user,
                    'token' => $token
                ];

                return  response()->json($response, 200);
            }
        }
    }

    function rand_Pass($upper = 2, $lower = 5, $numeric = 1)
    {

        $pass_order = [];
        $passWord   = '';

        //Create contents of the password
        for ($i = 0; $i < $upper; $i++) {
            $pass_order[] = chr(rand(65, 90));
        }
        for ($i = 0; $i < $lower; $i++) {
            $pass_order[] = chr(rand(97, 122));
        }
        for ($i = 0; $i < $numeric; $i++) {
            $pass_order[] = chr(rand(48, 57));
        }

        //using shuffle() to shuffle the order
        shuffle($pass_order);

        //Final password string
        foreach ($pass_order as $char) {
            $passWord .= $char;
        }
        return $passWord;
    }
}
