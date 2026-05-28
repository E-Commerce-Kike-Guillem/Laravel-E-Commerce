<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function index($productId)
    {
        Product::findOrFail($productId);

        $comments = Comment::with('user')
            ->where('product_id', $productId)
            ->latest() 
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'text' => $comment->text,
                    'rating' => $comment->rating,
                    'created_at' => $comment->created_at,
                    'user_id' => $comment->user_id,
                    'user_name' => $comment->user ? $comment->user->name : 'Usuari', 
                ];
            });

        return response()->json($comments);
    }


    public function store(Request $request, $productId)
    {
        $request->validate([
            'text' => 'required|string|min:3',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $comment = Comment::create([
            'product_id' => $productId,
            'user_id' => Auth::id(), 
            'text' => $request->text,
            'rating' => $request->rating,
        ]);

        return response()->json(['message' => 'Comentari creat amb èxit', 'data' => $comment], 201);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'No tens permís per editar aquest comentari'], 403);
        }

        $request->validate([
            'text' => 'required|string|min:3',
        ]);

        $comment->update([
            'text' => $request->text
        ]);

        return response()->json(['message' => 'Comentari actualitzat']);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $user = Auth::user();

        if ($comment->user_id !== $user->id && $user->role !== 'admin') {
            return response()->json(['message' => 'No tens permís per esborrar aquest comentari'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comentari esborrat']);
    }
}