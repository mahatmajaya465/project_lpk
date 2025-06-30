<?php

namespace App\Http\Controllers;

use App\Http\Resources\PembayaranTransformer;
use App\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index()
    {
        return view('admin.v1.layouts.app');
    }

    public function list(Request $request)
    {
        try {
            $pembayaran = new Pembayaran();
            $pembayaran = $pembayaran->list($request);

            return PembayaranTransformer::collection($pembayaran);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.pembayaran.show.failed'),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $pembayaran = new Pembayaran();
            $pembayaran_store = $pembayaran->store($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.pembayaran.store.success'),
                'data' => new PembayaranTransformer($pembayaran_store)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => trans('messages.pembayaran.store.failed'),
            ], 500);
        }
    }

    public function find($id)
    {
        try {
            $auth = auth()->user();

            if (!(in_array($auth->roles, ['super_admin']))) {
                if ($id != $auth->id) {
                    abort(500);
                }
            }

            $pembayaran = Pembayaran::find($id);

            if (!$pembayaran) {
                abort(500);
            }

            return new PembayaranTransformer($pembayaran);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.pembayaran.show.failed'),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $pembayaran = Pembayaran::find($id);

            if (!$pembayaran) {
                abort(500);
            }

            $pembayaran_update = $pembayaran->updatePembayaran($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.pembayaran.update.success'),
                'data' => new PembayaranTransformer($pembayaran_update)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => trans('messages.pembayaran.update.failed'),
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

            $pembayaran = Pembayaran::find($id);

            if (!$pembayaran) {
                abort(500);
            }

            $pembayaran->delete();

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.pembayaran.delete.success'),
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => trans('messages.pembayaran.delete.failed'),
            ], 500);
        }
    }
}
