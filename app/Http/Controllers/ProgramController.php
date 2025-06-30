<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProgramTransformer;
use App\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{
    public function index()
    {
        return view('admin.v1.layouts.app');
    }

    public function list(Request $request)
    {
        try {
            $program = new Program();
            $program = $program->list($request);

            return ProgramTransformer::collection($program);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.program.show.failed'),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $program = new Program();
            $program_store = $program->store($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.program.store.success'),
                'data' => new ProgramTransformer($program_store)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => true,
                'message' => trans('messages.program.store.failed'),
            ], 500);
        }
    }

    public function find($id)
    {
        try {
            $program = Program::find($id);

            if (!$program) {
                abort(500);
            }

            return new ProgramTransformer($program);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.program.show.failed'),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $program = Program::find($id);

            if (!$program) {
                abort(500);
            }

            $program_update = $program->updateProgram($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.program.update.success'),
                'data' => new ProgramTransformer($program_update)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => trans('messages.program.update.failed'),
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

            $program = Program::find($id);

            if (!$program) {
                abort(500);
            }

            $program->delete();

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.program.delete.success'),
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => trans('messages.program.delete.failed'),
            ], 500);
        }
    }
}
