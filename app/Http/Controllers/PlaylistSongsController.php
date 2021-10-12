<?php

namespace App\Http\Controllers;

use App\Exceptions\PbeNotAuthorizedException;
use App\Model\Playlist;
use App\Model\Playlistsong;
use App\Model\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class PlaylistSongsController extends Controller
{
    public function songuser()
    {
        /*Untuk mendapatkan token user yang sedang login*/
        $token = request()->header('token');
        $user = User::where('token','=',$token)->first();

        return $user;
    }

    public function getAll()
    {
        /*
         * untuk mendapatkan semua data playlist users
         * @return JsonResponse
         */
        $playlistsongs = Playlistsong::all();
        return $this->successResponse(['playlistsongs' => $playlistsongs]);
    }

    /**
     * function untuk menambah song di playlist miliknya
     * @return JsonResponse
     */
    public function create($id)
    {
        /*validasi*/
        $validate = Validator::make(request()->all(), [
            'song_id' => 'required|numeric',
        ]);

        $user=$this->songuser();
        $playlistsong = Playlist::where('user_id','=',$user->id)
            ->where('playlists.id','=',$id)
            ->first();

        #Kondisi ketika id tidak ada
        if ($playlistsong == null){
            throw new PbeNotAuthorizedException();

        #Kondisi jika validasi gagal
        }elseif ($validate->fails()){
            return $this->failResponse($validate->errors()->getMessages(), 400);
        }
        #Kondisi ketika tidak terjadi error
        $playlistsong = new Playlistsong();
        $playlistsong->song_id = request('song_id');
        $playlistsong->playlist_id = $id;
        $playlistsong->save();
        return $this->successResponse(['playlists' => $playlistsong], 201);
    }

}
