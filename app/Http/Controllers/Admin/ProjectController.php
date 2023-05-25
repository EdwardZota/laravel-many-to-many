<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Type;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        return view('admin.projects.index',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types=Type::all();
        return view('admin.projects.create',compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();

        $data['post_slug'] = Str::slug($request->title,'-');

        $checkProject = Project::where('post_slug', $data['post_slug'])->first();

        if($checkProject){
            return back()->withInput()->withErrors(['post_slug' => 'Con quersto titolo crei uno slug doppiato,perfavore cambia titolo']);
        }

        $newProject = new Project();

        $newProject->fill($data);//
                                 //--> $newProject = Project::create($data);
        $newProject->save();     //

        return redirect()->route('admin.projects.show',['project'=>$newProject->post_slug]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {

        return view('admin.projects.show',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {

        $types=Type::all();
        return view('admin.projects.edit',compact('project','types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        $data['post_slug'] = Str::slug($request->title,'-');

        $checkProject = Project::where('post_slug',$data['post_slug'])->where('id','<>',$project->id)->first();

        if($checkProject){
            return back()->withInput()->withErrors(['slug' => 'impossibile creare uno slug']);
        }

        $project->update($data);

        return redirect()->route('admin.projects.show',['project'=>$project->post_slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index');
    }
}
