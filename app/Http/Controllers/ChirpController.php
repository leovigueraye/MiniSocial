<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;


class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('chirps.index', [
            'chirps' => Chirp::with('user')->latest()->get(),
        ]);
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $request->user()->chirps()->create($validated);
 
        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id, Chirp $chirp)
    {
        $chirp = Chirp::find($id);

        if (!$chirp) {
            return abort(404);
        }

        return view('chirps.show', ['chirp' => $chirp]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        Gate::authorize('update', $chirp);
 
        return view('chirps.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        Gate::authorize('update', $chirp);
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
 
        $chirp->update($validated);
 
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        Gate::authorize('delete', $chirp);
 
        $chirp->delete();
 
        return redirect(route('chirps.index'));
    }

    public function search(Request $request)
    {
        $query = $request->query('query');
        $chirps = Chirp::search($query)->get() ?? [];

        return view('index', ['chirps' => $posts]);
    }

    public function comment($id, Request $request)
    {
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = $request->user()->id;
        $comment->chirp_id = $id;
        $comment->created_at = now();
        $comment->updated_at = now();
        $comment->save();
        return redirect("/chirps/{$id}");
    }

    public function like($id, Request $request)
    {
        $like = new Like();
        $like->user_id = $request->user()->id;
        $like->chirp_id = $id;
        $like->created_at = now();
        $like->updated_at = now();

        $like->save();

        return redirect("/chirps/{$id}");
    }

    public function dislike($id, Request $request)
    {
        $like = Like::where(['user_id' => $request->user()->id, 'chirp_id' => $id]);
        $like->delete();

        return redirect("/chirps/{$id}");
    }
}
