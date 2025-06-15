<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $const = [
        'viewFolder' => 'admin.user',
        'route' => 'user'
    ];
    public function index()
    {
        $data['user'] = User::all();
        $data['title'] = 'Data Pegawai';

        return view($this->const['viewFolder'].'.index', $data, $this->const);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id=null)
    {
        return $this->form($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
    {   
        try{
        $id = $request->id;
            DB::transaction(function() use ($request,$id){
                $this->saveData($request,$id);
                session()->flash('success', "Data Berhasil Disimpan");
                
            });
            
            return redirect()->route($this->const['route'].'.index');
        }catch(\Exception $e){
            DB::rollback();
            session()->flash('error', $e->getMessage());
            return redirect()->back();
        }

    }
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id=null)
    {
        return $this->form($request, $id, true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id=null)
    {
        return $this->form($request, $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request, User $user)
    {
        $this->saveData($request,$user->id);
        if ($user) {
            session()->flash('success', 'Data Berhasil Diupdate');
        } else {
            session()->flash('error', 'Data gagal Diupdate');
        }

        return redirect()->route($this->const['route'].'.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        if ($user) {
            session()->flash('success', 'Data Berhasil Dihapus');
        } else {
            session()->flash('error', 'Data Gagal Dihapus');
        }

        return redirect()->route($this->const['route'].'.index');
    }

    public function editProfile(Request $request, User $user)
    {
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
        ]);

        if ($user) {
            session()->flash('success', 'Data Berhasil Diupdate');
        } else {
            session()->flash('error', 'Data Gagal Diupdate');
        }
        return redirect()->route('home');
    }

    public function form(Request $request, $id = false, $only_view = false)
    {
        $data = $id ? User::findOrFail($id) : new User();
        $data->only_view = $only_view;
        $data->title = 'Pegawai Form';
        return view($this->const['viewFolder'] . '.form', ['data'=>$data], $this->const);
    }

    public function saveData($request, $id=false)
    {
        
        
        $data = $id == true ? User::find($id) : new User();
        
        if($data->id){
           
            $validation_username = ['required','min:4',Rule::unique('users')->ignore($data->id)]; 
            $validation_email = ['required','email', Rule::unique('users')->ignore($data->id)];
            $validation_password = '';
        }else{
           
            $validation_username = 'required|min:4|unique:users,username'; 
            $validation_email = 'required|email|unique:users,email';
            $validation_password = 'required|min:4';
        }
        $this->validate($request, [
            'username' => $validation_username,
            'name' => 'required|min:4',
            'email' => $validation_email,
            'roles' => 'required',
            'password' => $validation_password,
        ]);
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->roles = $request->roles;
        if ($request->filled('password')) {
            $data->password = bcrypt($request->password);
        }
        $data->save();
       

    }
}