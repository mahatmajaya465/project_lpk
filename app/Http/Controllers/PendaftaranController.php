<?php

namespace App\Http\Controllers;

use App\Http\Resources\PendaftaranTransformer;
use App\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    public function index()
    {
        return view('admin.v1.layouts.app');
    }

    public function list(Request $request)
    {
        try {
            $pendaftaran = new Pendaftaran();
            $pendaftaran = $pendaftaran->list($request);

            return PendaftaranTransformer::collection($pendaftaran);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.pendaftaran.show.failed'),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $pendaftaran = new Pendaftaran();
            $pendaftaran_store = $pendaftaran->store($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.pendaftaran.store.success'),
                'data' => new PendaftaranTransformer($pendaftaran_store)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => trans('messages.pendaftaran.store.failed'),
            ], 500);
        }
    }

    public function find($id)
    {
        try {
            $pendaftaran = Pendaftaran::find($id);

            if (!$pendaftaran) {
                abort(500);
            }

            return new PendaftaranTransformer($pendaftaran);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.pendaftaran.show.failed'),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $pendaftaran = Pendaftaran::find($id);

            if (!$pendaftaran) {
                abort(500);
            }

            $pendaftaran_update = $pendaftaran->updatePendaftaran($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.pendaftaran.update.success'),
                'data' => new PendaftaranTransformer($pendaftaran_update)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => trans('messages.pendaftaran.update.failed'),
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

            $pendaftaran = Pendaftaran::find($id);

            if (!$pendaftaran) {
                abort(500);
            }

            $pendaftaran->delete();

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.pendaftaran.delete.success'),
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => trans('messages.pendaftaran.delete.failed'),
            ], 500);
        }
    }
}
