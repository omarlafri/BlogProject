<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Tag;
use App\Category;
use App\User;




class AdminController extends Controller
{

  public function index(Request $request){

    if(!Auth::check() && $request->path()!='login'){
      return redirect('/login');

    }
   else if(Auth::check() && $request->path()=='login'){
    return redirect('/home');
    // return '2';
    }
    
    else{
      return view('welcome');

    }

    
    



  }
    public function addTag(Request $request){

        $this->validate($request,[
            'tagName'=>'required'
            ]);


       $tag=new Tag ;
       $tag->tagName=$request->tagName;
       $tag->save();

       return $tag;


    }
  public function addUser(Request $request){

        $this->validate($request,[
            'fullName'=>'required',
            'email'=>'required | email|unique:users',
            'password'=>'required | min:6',
            'userType'=>'required'

            ]);


            $user=new User;
            $user->fullName=$request->fullName;
            $user->email= $request->email;
            $user->password=bcrypt($request->password);
            $user->userType=$request->userType;
            $user->save();
            return $user ;


    }
    public function editTag(Request $request){

        $this->validate($request,[
            'tagName'=>'required',
            'id'=>'required'
            ]);


       $tag=TAG::find($request->id);
       $tag->tagName=$request->tagName;
       $tag->save();
       return $tag;


    }

    public function deleteTag(Request $request){

        $this->validate($request,[
            'id'=>'required'
            ]);


       Tag::find($request->id)->delete();
       return 'done';


    }
    public function deleteCat(Request $request){

            $this->validate($request,[
                'id'=>'required'
                ]);

         $cat= Category::find($request->id);


         $this->removeFileFromServer( $cat->iconeImage);
         $cat->delete();
          return 'done';

        }
        public function deleteUser(Request $request){

            $this->validate($request,[
                'id'=>'required'
                ]);

         $user= User::find($request->id);
         $user->isActivated='1';
         $user->save();
          return 'done';

        }
    public function getTags(Request $request){

      return Tag::orderBy('id','desc')->get();


    }

    public function upload(Request $request){

        $this->validate($request,[
            'file'=>'required | mimes:jpeg,jpg,png'
            ]);

        $img=time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'),$img);

       return $img;
  
  
      }

      
      public function removeFile(Request $request){

        $fileName=$request->img;
        $this->removeFileFromServer($fileName);
        return 'done';
      }

      
      public function removeFileFromServer($fileName){

        $filePath=public_path().'/uploads/'.$fileName;
        if(file_exists($filePath)){
            @unlink($filePath);
        }


      }
      public function addCategory(Request $request){

        $this->validate($request,[
            'categoryName'=>'required',
            'img'=>'required'
            ]);


       $cat=new Category ;
       $cat->categoryName=$request->categoryName;
       $cat->iconeImage=$request->img;
       $cat->save();

       return $cat;


    }

    
    public function getCategories(Request $request){

      return Category::orderBy('id','desc')->get();


    }

     public function getUsers(Request $request){

      return User::where(['isActivated'=>'0'])->orderBy('id','desc')->get();


    }

    public function editCat(Request $request){

      $this->validate($request,[
        'categoryName'=>'required',
        'iconeImage'=>'required',
        'id'=>'required'
        ]);


   $cat=Category::find($request->id);
   if($request->iconeImage !='0'){
    $this->removeFileFromServer( $cat->iconeImage);
    $cat->iconeImage=$request->iconeImage;

   }
   $cat->categoryName=$request->categoryName;
   
   $cat->save();

   return $cat;


    }

    public function editUser(Request $request){

      $this->validate($request,[
        'id'=>'required',
        'fullName'=>'required',
        'email'=>'required | email',
        'userType'=>'required'

        ]);

        $user=User::find($request->id);


        if($request->password!=''){
          $this->validate($request,[
            'password'=>'min:6'
            ]);
            $user->password=bcrypt($request->password);
        }

        $user->fullName=$request->fullName;
        $user->email= $request->email;
        $user->userType=$request->userType;
        $user->save();

        return $user;

        



    }

    public function login(Request $request)
    {
      $this->validate($request,[
        'email'=>'required | email',
        'password'=>'required|min:6'
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
          return response()->json([
            'msg'=>'You are logged in'
          ]);
        }
        else{
          return response()->json([
            'msg'=>'Incorect login details'
          ],401);
        }

    }
    public function logout(Request $request)
    {
      Auth::logout();
      return redirect('/login');

    }


    

}
