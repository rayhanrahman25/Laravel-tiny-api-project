<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
class ArticleController extends Controller
{
   function getAllArticles(){
    return Article::all();
   }
  function getArticle($id){
      return Article::findOrFail($id);
  }
  function createArticle(Request $request){
     $title = $request->title;
     $content = $request->content;
     $user = $request->user();

     $article = new Article();
     $article->title = $title;
     $article->content = $content;
     $article->user_id = $user->id;
     $article->save();
  }

  function updateArticle(Request $request, Article $article){
    $user = $request->user();
    if($user->id != $article->user_id){
       return response()->json(["error"=>"You Don't Have Permission To Edit This Article, Try Genuine Api Token"],404);
    }else{
       $title = $request->get('title');
       $content = $request->get('content');
       $article->title = $title;
       $article->content = $content;
       $article->save();
       return $article;
    }
  }
  function deleteArticle(Request $request, Article $article){
    $user = $request->user();
    if($user->id != $article->user_id){
       return response()->json(["error"=>"You Don't Have Permission To Edit This Article, Try Genuine Api Token"],404);
    }else{
       $article->delete();
       return response()->json(['sucess'=>"Article Delettion Completed"],200);
    }
  }

  function getToken(Request $request){
   $email = $request->email;
   $password = $request->password;
   if(Auth::attempt(['email'=>$email,'password'=>$password])){
       return Auth::user();
   }else{
       return response()->json(['error'=>'User Not Found'],404);
   }
}
}
