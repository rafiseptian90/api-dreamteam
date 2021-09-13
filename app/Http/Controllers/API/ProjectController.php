<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Libs\Response;
use Str;

class ProjectController extends Controller
{
    public function __construct()
    {
        // add middleware
        $this->middleware('auth.jwt', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if user want to show only the project using technology they used
        if(request()->query('technologies')){
            $projects = Project::with(['owner', 'tags'])
                                ->whereHas('tags', function($tag){
                                    $tag->whereIn('tag_id', request()->query('technologies'));
                                })
                                ->latest()
                                ->get();
        } else {
            $projects = Project::with(['owner', 'tags'])->latest()->get();
        }

        Response::successWithData('Project has been loaded', $projects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProjectRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $requests = $request->all();

        // check is request has image
        if($request->hasFile('logo'))
        {
            $requests['logo'] = $request->file('logo')->storeOnCloudinaryAs("projects", Str::slug($request->name))->getSecurePath();
        }

        $project = Project::create($requests);
        $project->tags()->attach($request->tags);

        return Response::success('Project has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return Response::successWithData('Project has been loaded', $project);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProjectRequest $request
     * @param  \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $requests = $request->all();

        if($request->hasFile('logo'))
        {
            // check logo is available
            if($project->logo !== NULL){
                cloudinary()->destroy('projects/' . $project->slug);
            }

            // store logo again
            $requests['logo'] = $request->file('logo')->storeOnCloudinaryAs('projects', Str::slug($request->name));
        }

        // delete project tags
        $project->tags()->delete();

        // update the project
        $project->update($requests);

        // add again project tags
        $project->tags()->attach($request->tags);

        return Response::success('Project has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        // delete project logo
        if($project->logo !== NULL){
            cloudinary()->destroy('projects/' . $project->slug);
            
            $project->update([
                'logo' => NULL
            ]);
        }

        $project->delete();
        $project->tags()->delete();

        return Response::success('Project has been deleted');
    }
}
