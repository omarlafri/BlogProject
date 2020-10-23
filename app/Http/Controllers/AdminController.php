<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Category;



class AdminController extends Controller
{
    public function addTag(Request $request){

        $this->validate($request,[
            'tagName'=>'required'
            ]);


       $tag=new Tag ;
       $tag->tagName=$request->tagName;
       $tag->save();

       return $tag;


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


    

}
