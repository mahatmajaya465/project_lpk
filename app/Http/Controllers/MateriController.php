<?php

namespace App\Http\Controllers;

use App\Http\Resources\MateriTransformer;
use App\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MateriController extends Controller
{
    public function index()
    {
        return view('admin.v1.layouts.app');
    }

    public function list(Request $request)
    {
        try {
            $materi = new Materi();
            $materi = $materi->list($request);

            return MateriTransformer::collection($materi);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.materi.show.failed'),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $materi = new Materi();
            $materi_store = $materi->store($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.materi.store.success'),
                'data' => new MateriTransformer($materi_store)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => trans('messages.materi.store.failed'),
            ], 500);
        }
    }

    public function find($id)
    {
        try {
            $materi = Materi::find($id);

            if (!$materi) {
                abort(500);
            }

            return new MateriTransformer($materi);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.materi.show.failed'),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $materi = Materi::find($id);

            if (!$materi) {
                abort(500);
            }

            $materi_update = $materi->updateMateri($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.materi.update.success'),
                'data' => new MateriTransformer($materi_update)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => trans('messages.materi.update.failed'),
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

            $materi = Materi::find($id);

            if (!$materi) {
                abort(500);
            }

            $materi->delete();

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.materi.delete.success'),
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => trans('messages.materi.delete.failed'),
            ], 500);
        }
    }
}
