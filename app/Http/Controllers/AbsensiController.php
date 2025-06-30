<?php

namespace App\Http\Controllers;

use App\Absensi;
use App\Http\Resources\AbsensiTransformer;
use App\Http\Resources\JadwalTransformer;
use App\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function index()
    {
        return view('admin.v1.layouts.app');
    }

    public function list(Request $request)
    {
        try {
            $jadwal = new Jadwal();
            $jadwal = $jadwal->listAbsensi($request);

            return JadwalTransformer::collection($jadwal);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.jadwal.show.failed'),
            ], 500);
        }
    }

    public function riwayat(Request $request, $id)
    {
        try {
            $absensi = new Absensi();
            $absensi = $absensi->riwayatAbsensi($request, $id);

            return AbsensiTransformer::collection($absensi);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.absensi.show.failed'),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $absensi = new Absensi();
            $absensi_store = $absensi->store($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.absensi.store.success'),
                'data' => new AbsensiTransformer($absensi_store)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => trans('messages.absensi.store.failed'),
            ], 500);
        }
    }
}
