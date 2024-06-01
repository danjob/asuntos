<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('Topics/Index', [
            'topics' => Topic::all(),
            'status' => Session::get('status')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('Topics/Show', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:280'],
        ]);

        $topic = new Topic;
        $topic->title = $request->title;
        $topic->owner_id = Auth::id();
        $topic->category_id = $request->category_id;
        $topic->save();

        // send mail to admin when created
        \Mail::raw($topic->title . ' by ' . Auth::user()->name, function ($message) {
            $message->to(config('mail.from.address'))->subject('New Asunto was created');
        });

        return redirect()
            ->route('topics.index')
            ->with('status', 'You created an asunto!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show(Topic $topic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit(Topic $topic)
    {
        return inertia('Topics/Show', [
            'topic' => $topic,
            'categories' => Category::all(),
            'status' => 'edit'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topic $topic)
    {
        $topic->title = $request->title;
        $topic->category_id = $request->category_id;
        $topic->save();

        return redirect()
            ->route('topics.index')
            ->with('status', 'Asunto updated!');
    }

    public function toggleLike(Topic $topic)
    {
        Auth::user()->likes()->toggle([$topic->id]);

        return redirect()->route('topics.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        $topic->delete();

        return redirect()
            ->route('topics.index')
            ->with('status', 'Asunto deleted!');
    }
}
