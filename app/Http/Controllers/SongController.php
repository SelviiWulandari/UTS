<?php

namespace App\Http\Controllers;

use App\Model\Playlistsong;
use App\Model\Song;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SongController extends Controller
{
    public function getAll()
    {
        /*
         * untuk mendapatkan semua data songs
         * @return JsonResponse
         */
        $songs = Song::all();
        return $this->successResponse(['songs' => $songs]);
    }

    /**
     * function untuk mengambil 1 data dari song berdasarkan primary key
     * @param $id
     * @return JsonResponse
     */
    public function getById($id)
    {
        $song = Song::find($id);
        if ($song == null){
            throw new NotFoundHttpException();
        }
        return $this->successResponse(['song' => $song]);
    }
    /**
     * function untuk menambah data di song
     * @return JsonResponse
     */
    public function create()
    {
        /*validasi*/
        $validate = Validator::make(request()->all(), [
            'title' => 'required',
            'year' => 'required',
            'artist' => 'required',
            'gendre' =>  'required',
            'duration' =>  'required',
        ]);
        if($validate->fails()){
            return $this->failResponse($validate->errors()->getMessages(), 400);
        }
        /*Jika tidak ada error yang terjadi*/
        $song = new Song();
        $song->title = request('title');
        $song->year = request('year');
        $song->artist = request('artist');
        $song->gendre = request('gendre');
        $song->duration = request('duration');
        $song->save();
        return $this->successResponse(['songs' => $song], 201);
    }
    /**
     * function untuk mengubah data dari database
     * @param Request $id
     * @return JsonResponse
     */
    public function update($id)
    {
        $song = Song::find($id);
        if ($song == null){
            throw new NotFoundHttpException();
        }
        $validate = Validator::make(request()->all(), [
            'title' => 'required',
            'year' => 'required',
            'artist' => 'required',
            'gendre' =>  'required',
            'duration' =>  'required',
        ]);
        if($validate->fails()){
            return $this->failResponse($validate->errors()->getMessages(), 400);
        }
        $song->title = request('title');
        $song->year = request('year');
        $song->artist = request('artist');
        $song->gendre = request('gendre');
        $song->duration = request('duration');
        $song->save();
        return $this->successResponse(['songs' => $song]);
    }
    /**
     * function untuk menghapus data dari database
     * @param Request $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $songs = Playlistsong::where('song_id','=',$id)->first();
        $song = Song::find($id);
        if ($song == null) {
            throw new NotFoundHttpException();
        }elseif ($songs == null){
            $song->delete($id);
            return $this->successResponse(['songs' => 'Lagu berhasil di hapus']);
        }
        return response()->json([
            'status' => 'failed',
            'message' => 'Tidak dapat menghapus, lagu sudah digunakan di dalam playlist'
        ], 400);
    }
}
