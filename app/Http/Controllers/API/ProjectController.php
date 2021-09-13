<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Libs\Response;
use Str;
use DB;

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
        $projects = Project::with(['owner' => function($owner){
                                    $owner->with(['profile']);
                                }, 'tags']);

        // if user want to show only the project using technology they used
        if(request()->query('technologies')){
            $projects = $projects->whereHas('tags', function($tag){
                                    $tag->whereIn('tag_id', request()->query('technologies'));
                                })
                                ->latest()
                                ->get();
        } else {
            $projects = $projects->latest()->get();
        }

        return Response::successWithData('Project has been loaded', $projects);
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
        $project = $project->load(['owner' => function($owner){
                                $owner->with(['profile']);
                            }, 'tags']);

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
        // check policy
        $this->authorize('delete', $project);
        
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

        // update the project
        $project->update($requests);

        // delete project tags
        DB::table('project_tags')->whereProjectId($project->id)->delete();

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
        // check policy
        $this->authorize('delete', $project);

        // delete project logo
        if($project->logo !== NULL){
            cloudinary()->destroy('projects/' . $project->slug);
            
            // $project->update([
            //     'logo' => NULL
            // ]);
        }

        DB::table('project_tags')->whereProjectId($project->id);
        $project->delete();

        return Response::success('Project has been deleted');
    }
}
