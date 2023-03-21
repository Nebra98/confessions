<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Confession;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        if($request->ajax())
        {

            $comment = new Comment();

            if($request->comment_id != null){
                $comment->parent_comment_id = $request->comment_id;
            }else{
                $comment->parent_comment_id = null;
            }
            $comment->comment = $request->input('comment');
            $comment->comment_sender_name = $request->input('name');
            $comment->confession_id = $request->input('confession_id');

            $comment->save();

            return response($comment);
        }

    }

    public function getComments(Confession $confession)
    {

        //$comments = Comment::all();

        //$comments = Comment::whereNull('parent_comment_id')->get(); // Get top-level comments

        $comments = Comment::where('confession_id', $confession->id)->whereNull('parent_comment_id')->with('replies')->get(); // Get top-level comments and their replies


        return view('comments.commentslist', compact('comments'));

    }
}
