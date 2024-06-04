<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;

class AccountController extends Controller
{
    public function show_register()
    {
        return view('account.register');
    }


    public function store_register(Request $request)
    {

        // validation

        $validator=Validator::make($request->all(),
        [
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required',
        ]
    );

    if($validator->fails())
    {
        return redirect()->route('accounts.register')->withInput()->withErrors($validator);
    }

      $register=new User();
      $register->name=$request->name;
      $register->email=$request->email;
      $register->password=Hash::make($request->password);

      $register->save();

      return redirect()->route('accounts.login')->with('success','you are register successfully.');
  
    }

    public function show_login()
    {
        return view('account.login');
    }

    public function store_login(Request $request)
    {
        // validation

        $validator=Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if($validator->fails())
        {
            return redirect()->route('accounts.login')->withInput()->withErrors($validator);
        }

        $credentials=$request->only('email','password');

        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            return redirect()->route('accounts.profile');
        }

        else{
            return redirect()->route('accounts.login')->with('error','Either Email/Password incorrect.');
        }
    }

    public function profile()
    {
        $users=User::find(Auth::user()->id);
        return view('account.profile',compact('users'));
    }

    public function profile_update(Request $request)
    {
        $rules=[
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.Auth::user()->id.',id',
        ];

        if(!empty($request->image))
        {
            $rules['image']='image';
        }


        $validator=Validator::make($request->all(),$rules);

    if($validator->fails())
    {
        return redirect()->route('accounts.profile')->withInput()->withErrors($validator);
    }


        $user=User::find(Auth::user()->id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->save();

        if(!empty($request->image))
        {

            File::delete(public_path('uploads/profile/'.$user->image));
            File::delete(public_path('uploads/profile/thumb/'.$user->image));

            $image=$request->image;
            $ext=$image->getClientOriginalExtension();
            $imageName=time().'.'.$ext;

            $image->move(public_path('uploads/profile'),$imageName);

            $user->image=$imageName;
            $user->save();

            // image thumbnail

            $manager = new ImageManager(Driver::class);
            $img = $manager->read(public_path('uploads/profile/'.$imageName));

            $img->cover(150, 150);
            $img->save(public_path('uploads/profile/thumb/'.$imageName));
            
        }

        return back()->with('success','Profile Updated Successfully.');
        

    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('accounts.login');
    }

}
