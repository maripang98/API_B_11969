<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::all();
        return response()->json($jadwals);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_event' => 'required|integer',
            'judul_sesi' => 'required|string',
            'deskripsi_sesi' => 'string',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'date|after:waktu_mulai',
        ]);

        $judulSesi = $validatedData['judul_sesi'];
        if($judulSesi === 'konser'){
            $validatedData['deskripsi_sesi'] = 'Penampilan music dari suatu band';
        }elseif($judulSesi === 'doorprize'){
            $validatedData['deskripsi_sesi'] = 'pembagian hadian dari panitia ke peserta';
        }elseif($judulSesi === 'Meet and Greet'){
            $validatedData['deskripsi_sesi'] = 'Sesi pertemuan untuk artis dengan penggemar';
        }else{
            return response()->json(['message' => 'judul sesi hanya konser, doorprize, dan Meet and Greet'], 406);
        }

        $validatedData['waktu_selesai'] = date('Y-m-d H:i:s', strtotime($validatedData['waktu_mulai'] . ' +1 day'));

        $userId = Auth::id();
        $eventId = $validatedData['id_event'];
        $event = Event::find($eventId);

        if (!$event || $event->id_user !== $userId) {
            return response()->json(['message' => 'Event tidak ditemukan atau tidak diizinkan'], 403);
        }

        $jadwal = Jadwal::create($validatedData);

        return response()->json(['message' => 'Jadwal created successfully', 'data' => $jadwal]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_event' => 'required|integer',
            'judul_sesi' => 'required|string',
            'deskripsi_sesi' => 'string',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'date|after:waktu_mulai',
        ]);

        $jadwal = Jadwal::find($id);
        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal tidak ditemukan'], 404);
        }

        $judulSesi = $validatedData['judul_sesi'];
        if($judulSesi === 'konser'){
            $validatedData['deskripsi_sesi'] = 'Penampilan music dari suatu band';
        }elseif($judulSesi === 'doorprize'){
            $validatedData['deskripsi_sesi'] = 'pembagian hadian dari panitia ke peserta';
        }elseif($judulSesi === 'Meet and Greet'){
            $validatedData['deskripsi_sesi'] = 'Sesi pertemuan untuk artis dengan penggemar';
        }else{
            return response()->json(['message' => 'judul sesi hanya konser, doorprize, dan Meet and Greet'], 406);
        }

        $validatedData['waktu_selesai'] = date('Y-m-d H:i:s', strtotime($validatedData['waktu_mulai'] . ' +1 day'));

        $userId = Auth::id();
        $eventId = $validatedData['id_event'];
        $event = Event::find($eventId);

        if (!$event || $event->id_user !== $userId) {
            return response()->json(['message' => 'Event tidak ditemukan atau tidak diizinkan'], 403);
        }

        $jadwal->update($validatedData);

        return response()->json(['message' => 'Jadwal updated successfully', 'data' => $jadwal]);
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::find($id);

        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal not found'], 404);
        }

        $jadwal->delete();

        return response()->json(['message' => 'Jadwal deleted successfully']);
    }

    public function search($judul_sesi)
    {
        $results = Jadwal::where('judul_sesi', 'like', '%' . $judul_sesi . '%')->get();

        if ($results->isEmpty()) {
            return response()->json(['message' => 'Judul sesi tidak ada'], 404);
        }

        return response()->json($results);
    }
}

