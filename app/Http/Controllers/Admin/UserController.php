<?php

namespace App\Http\Controllers\Admin;

use App\Artist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;

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

            $artist           = Artist::where('email', $user->email)->first();

            if ($artist == null) {
                $c = new Artist;
                $c ->name                       =$user->name ;
                $c ->lastname                       =$user->lastname ;
                $c ->email                       =$user->email ;
                $c ->phone                       =$user->phone ;
                $c ->birthday                       =$user->birthday ;
                $c ->country                       =$user->country ;
                $c ->description_large                       =$user->description_large ;
                $c ->slug                       =Str::slug($user->name) ;
                $c ->status                       = 1 ;
                $c ->file                       =$user->file ;
                $c ->file_path                       =$user->file_path ;
                $c ->user_id                       =$user->id  ;
                $c->save();
            } else {
                $artist ->name                       =$user->name ;
                $artist ->lastname                       =$user->lastname ;
                $artist ->email                       =$user->email ;
                $artist ->phone                       =$user->phone ;
                $artist ->birthday                       =$user->birthday ;
                $artist ->country                       =$user->country ;
                $artist ->description_large                       =$user->description_large ;
                $artist ->slug                       =Str::slug($user->name) ;
                $artist ->status                       = 1 ;
                $artist ->file                       =$user->file ;
                $artist ->file_path                       =$user->file_path ;
                $artist ->user_id                       =$user->id  ;
                $artist->save();
            }


            if($user->permissions  == null):
                $permissions = [

                    'user_profile'                     => true,
                    'articles'                     => true,
                    'article_delete'                     => true,
                    'article_edit'                     => true,
                    'article_add'                     => true,
                    'user_profile_edit'         => true,

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


    public function getUserProfile()
    {
        $user           = User::where('id', Auth::id())->first();
        if ($user->artist_id == null) {
            $user_artist = 'sin informacion';
        } else {
            $user_artist           = Artist::where('id',$user->artist_id)->get();
        }

        $data           = [
            'user' => $user,
            'user_artist' => $user_artist
        ];
        return view('admin.users.profile', $data);

    }

    public function getUserProfileEdit()
    {
        $user           = User::where('id', Auth::id())->first();
        if ($user->artist_id == null) {
            $user_artist = 'sin informacion';
        } else {
            $user_artist           = Artist::where('id',$user->artist_id)->get();
        }

        $data           = [
            'user' => $user,
            'user_artist' => $user_artist
        ];
        return view('admin.users.users_edit_profile', $data);

    }

    public function postUserProfileEdit(Request $request)
    {
        $user           = User::findOrFail(Auth::id());

        if ($user->role == 2) {
            $user ->name                       =e($request->input('name')) ;
            $user ->lastname                       =e($request->input('lastname')) ;
            $user ->email                       =e($request->input('email')) ;
            $user ->phone                       =e($request->input('phone')) ;
            $user ->birthday                       =e($request->input('birthday')) ;
            $user ->country                       =e($request->input('country'));
            $user ->description_large                       =e($request->input('description_large')) ;
            $user ->slug                       =Str::slug($request->input('name').' '.$request->input('lastname')) ;
            if($request->hasFile('file')):
                $path = '/Users/'.$user->id;
                $fileExt = trim($request->file('file')->getClientOriginalExtension());
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $request->file('file')->getClientOriginalName()));
                $filename = rand(1,999).'-'.$name.'.'.$fileExt;
                $file_absolute = $upload_path.'/'.$path.'/'.$filename;
                $user ->file                       =$filename;
                $user ->file_path                       =$path;
            endif;
            if($request->hasFile('file')):

                $fl = $request->file->storeAs($path, $filename, 'uploads');
                $imagT = Image::make($file_absolute);
                $imagT->resize(256, 256, function($constraint){
                    $constraint->upsize();
                });
                $imagW = Image::make($file_absolute);
                // $imagW->resize(1920, 1080, function($constraint){
                //     $constraint->upsize();
                // });
                $imagT->save($upload_path.'/'.$path.'/t_'.$filename);
                $imagW->save($upload_path.'/'.$path.'/'.$filename);

            endif;

            if ($user->save()) {
                $user_artist           = Artist::where('user_id',$user->id)->first();
                $user_artist ->name                       =$user->name ;
                $user_artist ->lastname                       =$user->lastname ;
                $user_artist ->email                       =$user->email ;
                $user_artist ->phone                       =$user->phone ;
                $user_artist ->birthday                       =$user->birthday ;
                $user_artist ->country                       =$user->country ;
                $user_artist ->description_large                       =$user->description_large ;
                $user_artist ->slug                      = $user->slug  ;
                $user_artist ->file                       =$user->file ;
                $user_artist ->file_path                       =$user->file_path ;
                $user_artist->save();
            }
        } else {
            $user ->name                       =e($request->input('name')) ;
            $user ->lastname                       =e($request->input('lastname')) ;
            $user ->email                       =e($request->input('email')) ;
            $user ->phone                       =e($request->input('phone')) ;
            $user ->birthday                       =e($request->input('birthday')) ;
            $user ->country                       =e($request->input('country'));
            $user ->slug                       =Str::slug($request->input('name').' '.$request->input('lastname')) ;
            if($request->hasFile('file')):
                $path = '/Users/'.$user->id;
                $fileExt = trim($request->file('file')->getClientOriginalExtension());
                $upload_path = Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt, '', $request->file('file')->getClientOriginalName()));
                $filename = rand(1,999).'-'.$name.'.'.$fileExt;
                $file_absolute = $upload_path.'/'.$path.'/'.$filename;
                $user ->file                       =$filename;
                $user ->file_path                       =$path;
            endif;
            $user->save();

            if($request->hasFile('file')):

                $fl = $request->file->storeAs($path, $filename, 'uploads');
                $imagT = Image::make($file_absolute);
                $imagT->resize(256, 256, function($constraint){
                    $constraint->upsize();
                });
                $imagW = Image::make($file_absolute);
                // $imagW->resize(1920, 1080, function($constraint){
                //     $constraint->upsize();
                // });
                $imagT->save($upload_path.'/'.$path.'/t_'.$filename);
                $imagW->save($upload_path.'/'.$path.'/'.$filename);

            endif;
        }

        $data           = [
            'user' => $user,
            'user_artist' => $user_artist
        ];
        return redirect('/admin/user-profile')->with('message', ' Datos actualizados con éxito.')->with('typealert', 'success');

    }


}

