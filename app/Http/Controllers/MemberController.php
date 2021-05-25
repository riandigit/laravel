<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordStoreRequest;
use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\MemberStoreRequest;
use App\Http\Requests\MemberUpdateRequest;
use Illuminate\Support\Facades\Crypt;

class MemberController extends Controller
{
    //

    public function getAllMember(Request  $request)
    {
        $member = Member::all();
        $d = array();
        foreach ($member as $key => $value) {
            $id = Crypt::encrypt("$value->id");
            $d[$key]['id'] = $id;
            $d[$key]['firstname'] = $value->firstname;
            $d[$key]['lastname'] = $value->lastname;
            $d[$key]['email'] = $value->email;
            $d[$key]['status'] = $value->status;
            $d[$key]['position'] = $value->position;
            $d[$key]['id_sso'] = $value->id_sso;
            $d[$key]['user_type'] = $value->user_type;
            $d[$key]['name'] = $value->name;
            $d[$key]['picture'] = $value->picture;
            $d[$key]['phone'] = $value->phone;
            $d[$key]['birthday'] = $value->birthday;
            $d[$key]['gender'] = $value->gender;
        }
        return  response()->json($d, 200);
    }

    public function getMemberbyId(Request $request, $id)
    {

        $iddecrypt = Crypt::decrypt($id);

        return  Member::where('id', $iddecrypt)->first();
    }

    public function updateMember(MemberUpdateRequest $request, $id)
    {
        $fields = $request->validated();
        $iddecrypt = Crypt::decrypt($id);

        $member = Member::find($iddecrypt);
        $member->update([
            'firstname' => $fields['firstname'],
            'lastname' => $fields['lastname'],
            'position' => $fields['position'],
            'name' => isset($fields['name']) ? $fields['name'] : null,
            'picture' => isset($fields['picture']) ? $fields['picture'] : null,
            'phone' => isset($fields['phone']) ? $fields['phone'] : null,
            'birthday' => isset($fields['birthday']) ? $fields['birthday'] : null,
            'gender' => isset($fields['gender']) ? $fields['gender'] : null,
        ]);

        $response = ['message' => 'Data successfully updated'];
        return  response()->json($response, 200);

        // return $member;
    }

    public function changePassword(ChangePasswordStoreRequest $request, $id)
    {
        $fields = $request->validated();
        $iddecrypt = Crypt::decrypt($id);

        $member = Member::find($iddecrypt);
        $member->update([
            'password' => bcrypt($fields['passwordnew']),
        ]);
        $response = ['message' => 'Ypur Password successfully updated'];
        return  response()->json($response, 200);

        // return $member;
    }
}
