<?php

namespace App\Http\Controllers;

use App\Http\Resources\PesertaTransformer;
use App\Peserta;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesertaController extends Controller
{
    public function index()
    {
        return view('admin.v1.layouts.app');
    }

    public function list(Request $request)
    {
        try {
            $peserta = new Peserta();
            $peserta = $peserta->list($request);

            return PesertaTransformer::collection($peserta);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.peserta.show.failed'),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $peserta = new Peserta();
            $peserta_store = $peserta->store($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.peserta.store.success'),
                'data' => new PesertaTransformer($peserta_store)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => trans('messages.peserta.store.failed'),
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

            $peserta = Peserta::find($id);

            if (!$peserta) {
                abort(500);
            }

            return new PesertaTransformer($peserta);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.peserta.show.failed'),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $peserta = Peserta::find($id);

            if (!$peserta) {
                abort(500);
            }

            $peserta_update = $peserta->updatePeserta($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.peserta.update.success'),
                'data' => new PesertaTransformer($peserta_update)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => trans('messages.peserta.update.failed'),
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

            $peserta = Peserta::find($id);

            if (!$peserta) {
                abort(500);
            }

            $users = User::find($peserta->user_id);
            $users->deleted_at = date('Y-m-d H:i:s');
            $users->email = $users->email . '_' . date('YmdHis') . '_deleted';
            $users->save();

            $peserta->delete();

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.peserta.delete.success'),
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => trans('messages.peserta.delete.failed'),
            ], 500);
        }
    }
}
