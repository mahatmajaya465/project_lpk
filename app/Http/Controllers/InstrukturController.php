<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstrukturTransformer;
use App\Instruktur;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstrukturController extends Controller
{
    public function index()
    {
        return view('admin.v1.layouts.app');
    }

    public function list(Request $request)
    {
        try {
            $instruktur = new Instruktur();
            $instruktur = $instruktur->list($request);

            return InstrukturTransformer::collection($instruktur);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.instruktur.show.failed'),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $instruktur = new Instruktur();
            $instruktur_store = $instruktur->store($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.instruktur.store.success'),
                'data' => new InstrukturTransformer($instruktur_store)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => trans('messages.instruktur.store.failed'),
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

            $instruktur = Instruktur::find($id);

            if (!$instruktur) {
                abort(500);
            }

            return new InstrukturTransformer($instruktur);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.instruktur.show.failed'),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $instruktur = Instruktur::find($id);

            if (!$instruktur) {
                abort(500);
            }

            $instruktur_update = $instruktur->updateInstruktur($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.instruktur.update.success'),
                'data' => new InstrukturTransformer($instruktur_update)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => trans('messages.instruktur.update.failed'),
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

            $instruktur = Instruktur::find($id);

            if (!$instruktur) {
                abort(500);
            }

            $users = User::find($instruktur->user_id);
            $users->deleted_at = date('Y-m-d H:i:s');
            $users->email = $users->email . '_' . date('YmdHis') . '_deleted';
            $users->save();

            $instruktur->delete();

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.users.delete.success'),
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => trans('messages.users.delete.failed'),
            ], 500);
        }
    }
}
