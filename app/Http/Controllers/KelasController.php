<?php

namespace App\Http\Controllers;

use App\Http\Resources\KelasTransformer;
use App\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    public function index()
    {
        return view('admin.v1.layouts.app');
    }

    public function list(Request $request)
    {
        try {
            $kelas = new Kelas();
            $kelas = $kelas->list($request);

            return KelasTransformer::collection($kelas);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.kelas.show.failed'),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $kelas = new Kelas();
            $kelas_store = $kelas->store($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.kelas.store.success'),
                'data' => new KelasTransformer($kelas_store)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => trans('messages.kelas.store.failed'),
            ], 500);
        }
    }

    public function find($id)
    {
        try {
            $kelas = Kelas::find($id);

            if (!$kelas) {
                abort(500);
            }

            return new KelasTransformer($kelas);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.kelas.show.failed'),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $kelas = Kelas::find($id);

            if (!$kelas) {
                abort(500);
            }

            $kelas_update = $kelas->updateKelas($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.kelas.update.success'),
                'data' => new KelasTransformer($kelas_update)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => trans('messages.kelas.update.failed'),
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

            $kelas = Kelas::find($id);

            if (!$kelas) {
                abort(500);
            }

            $kelas->delete();

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.kelas.delete.success'),
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => trans('messages.kelas.delete.failed'),
            ], 500);
        }
    }
}
