<?php

namespace App\Http\Controllers;

use PDF;
use Excel;
use App\Models\Role;
use App\Models\User;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    public function index()
    {
        try{
            $userCollection = User::latest();
            $role = Role::latest()->get();
            if(request('search')){
                $user = $userCollection
                                ->where('name','like', '%'.request('search').'%')
                                ->orWhere('email','like', '%'.request('search').'%');
            }

            $req='';

            if(request('role')){
                $user = $userCollection
                            ->where('role_id',request('role'));
                $req=request('role');
            }

                $user = $userCollection->paginate(5);
                return view('backend.users.index',[
                'users' => $user,
                'roles' => $role,
                'req'=>$req,
            ]);
        }catch(QueryException $e){
            echo $e->getMessage();
        }
    }

    public function show(User $user)
    {
        return view('backend.users.show',[
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        $roles =Role::latest()->get();
        return view('backend.users.edit',[
            'user' => $user,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, User $user)
    {
        $user->update([
            'role_id' => $request->role_id,
        ]);
        return redirect()->route('users.index')->withMessage('Task was successful update!');
    }

    public function destroy(User $user)
    {
        try{
            $user->delete();
            return redirect()->route('users.index')->withMessage('Task was successfully Delete!');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function trash()
    {
        try{
            $user = User::onlyTrashed()->get();
            return view('backend.users.trash',[
                'users' => $user
            ]);
        }catch(QueryException $e){
            echo $e->getMessage();
        }
    }

    public function restore($id)
    {
        try{
            $user = User::onlyTrashed()->findOrFail($id);
            $user->restore();
            return redirect()->route('users.trash')->withMessage('Task was successfully Restore!');
        }catch(QueryException $e){
            echo $e->getMessage();
        }
    }

    public function excel()
    {
        return Excel::download(new UsersExport, 'user.xlsx');
    }

    public function pdf()
    {
        $user = User::all();
        $pdf = PDF::loadView('backend.users.pdf', ['users' => $user]);
        return $pdf->download('users.pdf');
    }
}