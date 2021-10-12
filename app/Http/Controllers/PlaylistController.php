<?php

namespace App\Http\Controllers;

use App\Exceptions\PbeNotAuthorizedException;
use App\Model\Playlist;
use App\Model\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class PlaylistController extends Controller
{
    public function user()
    {
        $token = request()->header('token');
        $user = User::where('token','=',$token)->first();

        return $user;

    }

    public function getAll()
    {
        /*
         * untuk mendapatkan semua data users
         * @return JsonResponse
         */
        $user=$this->user();

        $playlists = Playlist::where('user_id','=',$user->id)->get();
        if ($playlists->count()==0){
            throw new NotFoundHttpException();
        }
        return $this->successResponse(['users' => $playlists]);
    }

    #untuk menampilkan semua detail playlists
    public function getallplaylistsongById($id)
    {
        $user=$this->user();
        $playlists = Playlist::join('playlistsongs', 'playlists.id', '=', 'playlistsongs.playlist_id')
            ->join('songs','playlistsongs.song_id','=','songs.id')
            ->where('user_id','=',$user->id)
            ->where('user_id','=',$id)
            ->select('playlists.user_id','playlistsongs.playlist_id','playlists.name','playlistsongs.song_id','songs.title','songs.year','songs.artist','songs.gendre','songs.duration')
            ->get();
        if ($playlists->count()==0){
            throw new PbeNotAuthorizedException();
        }
        return $this->successResponse(['All Playlist Songs' => $playlists]);

    }

    /**
     * function untuk mengambil 1 data dari user berdasarkan primary key
     * @param $id
     * @return JsonResponse
     */
    public function getById($id)
    {
        $playlist = Playlist::find($id);
        if ($playlist == null){
            throw new NotFoundHttpException();
        }
        return $this->successResponse(['playlist' => $playlist]);
    }

    #untuk mendapatkan lagu dari playlists dengan id tertentu dari user
    public function getplaylistsongById($id,$playlist_id)
    {
        $playlist = Playlist::join('playlistsongs', 'playlists.id', '=', 'playlistsongs.playlist_id')
            ->join('songs','playlistsongs.song_id','=','songs.id')
            ->where('playlists.id','=', $playlist_id)
            ->where('playlists.user_id','=', $id)
            ->select('playlists.name','songs.title','songs.year','songs.artist','songs.gendre','songs.duration','playlists.user_id','playlistsongs.playlist_id')
            ->get();
        if ($playlist->count()==0){
            throw new NotFoundHttpException();
        }
        return $this->successResponse(['Playlist Song'=> $playlist]);
    }

    #untuk mendapatkan detail playlists dengan id tertentu dari user
    public function getdetailplaylistById($id)
    {
        $user=$this->user();
        $playlists = Playlist::where('user_id','=',$user->id)
            ->where('playlists.id','=',$id)
            ->first();

        if ($playlists == null){
            throw new PbeNotAuthorizedException();
        }
        return $this->successResponse(['playlists' => $playlists]);

    }
    /**
     * function untuk menambah data di song
     * @return JsonResponse
     */
    public function create()
    {
        /*validasi*/
        $validate = Validator::make(request()->all(), [
            'name' => 'required',
            'user_id' => '',
        ]);
        if($validate->fails()){
            return $this->failResponse($validate->errors()->getMessages(), 400);
        }
        /*Jika tidak ada error yang terjadi*/
        $playlist = new Playlist();
        $playlist->name = request('name');
        $playlist->user_id = request('user_id');
        $playlist->save();
        return $this->successResponse(['playlists' => $playlist], 201);
    }
    public function createplaylist()
    {
        $user=$this->user();
        $playlist = new Playlist();
        $playlist->name = request('name');
        $playlist->user_id = $user->id;
        $playlist->save();
        return $this->successResponse(['playlists' => $playlist], 201);
    }

}
