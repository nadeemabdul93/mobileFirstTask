<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
   
    public function editUser(Request $request,$id)
    {   $user=User::findOrFail($id);
        // dd($user);
        $error='';
        return view('editUser',compact('user','error'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUser(Request $request)
    {       
       
            $user=User::where("id",'!=',$request->id)->where('email',$request->email)->first();
            if($user){               
                return redirect()->back()->with('error',"Email already exist you can't update this");
            }
            $updateUser=User::findOrfail($request->id);
            $updateUser->name=$request->name;
            $updateUser->email=$request->email;
            $query=$updateUser->save();
            if($query==true){
                
                return redirect()->route('admin.home');
            }else{
                return redirect()->back()->withErrors("error","failed try again");
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request,$id)
    {
        $user=User::findOrfail($id);
        if(!$user){               
            return redirect()->back()->with('error',"User not found");
        }
        $user->delete();
      
        return redirect()->route('admin.home')->with('success',"successfully delete");
    }
}
