<?php

namespace App\Http\Controllers;

use App\Http\Resources\UsersTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index()
    {
        return view('admin.v1.layouts.app');
    }

    public function list(Request $request)
    {
        try {
            $users = new User();
            $users = $users->list($request);

            return UsersTransformer::collection($users);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.users.show.failed'),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $auth = auth()->user();

            if (!(in_array($auth->roles, ['super_admin']))) {
                abort(500);
            }

            $users = new User;
            $users_store = $users->store($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.users.store.success'),
                'data' => new UsersTransformer($users_store)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => trans('messages.users.store.failed'),
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

            $users = User::find($id);

            if (!$users) {
                abort(500);
            }

            return new UsersTransformer($users);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.users.show.failed'),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $users = User::find($id);

            if (!$users) {
                abort(500);
            }

            $users_update = $users->updateUser($request);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => trans('messages.users.update.success'),
                'data' => new UsersTransformer($users_update)
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'error' => true,
                'message' => trans('messages.users.update.failed'),
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

            $user = User::find($id);

            if (!$user) {
                abort(500);
            }

            $user->deleted_at = date('Y-m-d H:i:s');
            $user->email = $user->email . '_' . date('YmdHis') . '_deleted';
            $user->save();

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
