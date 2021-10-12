<?php

namespace App\Http\Controllers;

use App\Model\Playlist;
use App\Model\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    public function getAll()
    {
        /*
         * untuk mendapatkan semua data users
         * @return JsonResponse
         */
        $users = User::all();
        return $this->successResponse(['users' => $users]);
    }

    /**
     * function untuk mengambil 1 data dari user berdasarkan primary key
     * @param $id
     * @return JsonResponse
     */
    public function getById($id)
    {
        $user = User::find($id);
        if ($user == null){
            throw new NotFoundHttpException();
        }
        return $this->successResponse(['user' => $user]);
    }

    #untuk mendapatkan playlist dari user dengan id tertentu
    public function getplaylistById($id)
    {
        $user = Playlist::where('user_id','=',$id)->first();
        if ($user == null){
            $user = User::find($id);
            throw new NotFoundHttpException();
        }
        return $this->successResponse(['user'=> $user]);
    }

    /**
     * function untuk menambah data song
     * @return JsonResponse
     */
    public function create()
    {
        /*validasi*/
        $validate = Validator::make(request()->all(), [
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
            'fullname' =>  'required',
        ]);
        if($validate->fails()){
            return $this->failResponse($validate->errors()->getMessages(), 400);
        }
        /*Jika tidak ada error yang terjadi*/
        $user = new User();
        $user->email = request('email');
        $user->password = Hash::make(request('password'));
        $user->role = request('role');
        $user->fullname = request('fullname');
        $user->save();
        return $this->successResponse(['users' => $user], 201);
    }
}
