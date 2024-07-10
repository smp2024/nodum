<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function __Construct()
    {
        $this->middleware('auth');
        $this->middleware('user.status');
        $this->middleware('user.permissions');
        $this->middleware('isadmin');
    }

    public function getUsers($status)
    {

        if($status == 'all'):

            $users = User::orderBy('id', 'Desc')->paginate(25);

        else :

            $users = User::where('status', $status)->orderBy('id', 'Desc')->paginate(25);

        endif;

        $data           = ['users' => $users];
        return view('admin.users.home', compact('users'));

    }

    public function getUserEdit($id)
    {
        $user           = User::findOrFail($id);
        $data           = ['user' => $user];
        return view('admin.users.users_edit', $data);

    }

    public function postUserEdit(Request $request, $id)
    {
        $user           = User::findOrFail($id);

        $user->role = $request->input('user_type');
        if($request->input('user_type') == "1" ):
            if($user->permissions  == null):
                $permissions = [

                    'dashboard'                     => true,

                ];
                $permissions = json_encode($permissions);
                $user->permissions = $permissions;
            endif;
        else:
            $user->permissions = null;
        endif;
        if( $request->input('user_type') == "2"):
            if($user->permissions  == null):
                $permissions = [

                    'dashboard'                     => true,
                    'articles'                     => true,
                    'article_delete'                     => true,
                    'article_edit'                     => true,
                    'article_add'                     => true,

                ];
                $permissions = json_encode($permissions);
                $user->permissions = $permissions;
            endif;
        else:
            $user->permissions = null;
        endif;

        if ($user->save()):

            if($request->input('user_type') == "1" || $request->input('user_type') == "2"):
                return redirect('/admin/user/'.$user->id.'/permissions')->with('message', 'El rango del usuario se actualizo con éxito.')->with('typealert', 'success');
            else:
                return back()->with('message', 'El rango del usuario se actualizo con éxito.')->with('typealert', 'success');
            endif;

        endif;

    }

    public function getUserBanned($id)
    {
        $user    = User::findOrFail($id);
        if($user->status == "100"):

            $user->status = "1";
            $msg = "Usuario activado con éxito.";

        else :

            $user->status = "100";
            $msg = "Usuario suspendido con éxito.";

        endif;

        if($user->save()):

            return back()->with('message', $msg)->with('typealert', 'success');

        endif;

        $data           = ['user' => $user];
        return view('admin.users.users_edit', $data);

    }

    public function getUserPermissions($id)
    {
        $user    = User::findOrFail($id);

        $data           = ['user' => $user];
        return view('admin.users.users_permissions', $data);

    }

    public function postUserPermissions(Request $request, $id)
    {
        //return $request->except(['_token']);
        $user    = User::findOrFail($id);
        $user->permissions = $request->except(['_token']);

        if ($user->save()):
            return back()->with('message', 'Los permisos de ususario fueron actualizados con exito')->with('typealert', 'success');
        endif;

    }





}

