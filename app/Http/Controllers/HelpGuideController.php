<?php

namespace App\Http\Controllers;
use App\Http\Requests\HelpGuide\CreateHelpGuideRequest;
use App\Helpers\APIHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\CommonHelper;
use App\Models\Image;
use App\Helpers\FileHelper;
use App\Models\HelpGuide;
use Illuminate\Support\Facades\Auth;

class HelpGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $help_guides = HelpGuide::with(['images','user'])->where('user_id', '=', $user->id)->get();

        return view('pages.help-guide.index')->with(['help_guides'=> $help_guides]);
    }

    public function loadOwnHelpGuides()
    {
        $help_guides = HelpGuide::orderBy('id', 'desc')->with(['images','user'])->get();

        return DataTables::of($help_guides)
            ->editColumn('created_at', function ($help_guides) {
                return date('d-m-Y H:i:s', strtotime($help_guides->created_at));
            })
            ->addColumn('action', function ($help_guides) {
                return "<a href=" .route('help-guide.show', $help_guides->id). " class='btn btn-primary'>Show</a> <a href=" . route('help-guide.edit', $help_guides->id) . " class='btn btn-success'>Edit</a> ";
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.help-guide.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateHelpGuideRequest $request)
    {
        try{
            $user = Auth::user();
          
            $helpGuide = new HelpGuide();
            $helpGuide->topic = $request->topic;
            $helpGuide->user_id = $user->id;
            $helpGuide->link = $request->link;
            $helpGuide->description = $request->description;
            $helpGuide->save();
    
            if ($request->images){
                FileHelper::saveImages($request->images,$helpGuide,'images/help-guide');
            }
            return APIHelper::makeAPIResponse(true, "Help Guide Added Successfully", ['Help Guide' =>$helpGuide,'image_data' => $helpGuide->images()], 200);
            } catch (Exception $e) {
                return APIHelper::makeAPIResponse(false, "Internal Server Error", null, 500);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $helpGuide = HelpGuide::find($id);
        $images = $helpGuide->images()->get();
        return view('pages.help-guide.view',['helpGuide'=>$helpGuide,'images'=>$images]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $helpGuide = HelpGuide::find($id);
        $images = $helpGuide->images()->get();
        return view('pages.help-guide.edit',['helpGuide'=>$helpGuide,'images'=>$images]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
        $helpGuide = HelpGuide::find($id);
        if(!$helpGuide){
            return APIHelper::makeAPIResponse(false, "Help Guide nor found", null, 400);
        } else {
            $helpGuide->delete();
            return APIHelper::makeAPIResponse(true, "Help Guide deleted Successfully",null, 200);
        }
     
    } catch (Exception $e) {
        return APIHelper::makeAPIResponse(false, "Internal Server Error", null, 500);
    }
    }
}
