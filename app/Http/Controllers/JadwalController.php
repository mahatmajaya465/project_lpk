<?php

namespace App\Http\Controllers;

use App\Http\Resources\JadwalTransformer;
use App\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index()
    {
        return view('admin.v1.layouts.app');
    }

    public function list(Request $request)
    {
        try {
            $jadwal = new Jadwal();
            $jadwal = $jadwal->list($request);

            return JadwalTransformer::collection($jadwal);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.jadwal.show.failed'),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $jadwal = new Jadwal();
            $jadwal_store = $jadwal->store($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.jadwal.store.success'),
                'data' => new JadwalTransformer($jadwal_store)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => trans('messages.jadwal.store.failed'),
            ], 500);
        }
    }

    public function find($id)
    {
        try {
            $jadwal = Jadwal::find($id);

            if (!$jadwal) {
                abort(500);
            }

            return new JadwalTransformer($jadwal);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.jadwal.show.failed'),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $jadwal = Jadwal::find($id);

            if (!$jadwal) {
                abort(500);
            }

            $jadwal_update = $jadwal->updateKelas($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.jadwal.update.success'),
                'data' => new JadwalTransformer($jadwal_update)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => trans('messages.jadwal.update.failed'),
            ], 500);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $auth = auth()->user();

            if (!(in_array($auth->roles, ['super_admin']))) {
                abort(500);
            }

            $jadwal = Jadwal::find($id);

            if (!$jadwal) {
                abort(500);
            }

            $jadwal->delete();

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.jadwal.delete.success'),
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => trans('messages.jadwal.delete.failed'),
            ], 500);
        }
    }
}
