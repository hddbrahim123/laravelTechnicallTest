<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;
use App\Http\Requests\FileRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class documentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Document::all();

            return response()->json([
                'success'=>true,
                'message'=>"Documents sent successFully",
                "data"=>DocumentResource::collection($documents) 
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();

        $document = Document::create($data);

        return response()->json([
            "success" => true,
            "message" => "Document Created SuccessFully",
            "data" => new DocumentResource($document)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        return response()->json(new DocumentResource($document));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentRequest $request, Document $document)
    {

        $this->authorize("update", $document);

        $data = $request->all();

        $document->Title = $data['Title'];
        $document->subtitle = $data['subtitle'];
        $document->summary = $data['summary'];
        $document->keywords = $data['keywords'];

        $document->save();
        
        return response()->json([
            "success"=>true,
            "message"=>"Document Updated SuccessFully",
            "data"=> new DocumentResource($document)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        $this->authorize("delete", $document);

        if($document->file){
            Storage::delete($document->file->path);
        }

        $document->delete();

        return response()->json([
            "success"=>true,
            'message' => "Document Deleted SuccessFully"
        ]);
    }

    public function search($keyword)
    {
        $document = Document::where("keywords","like","%".$keyword."%")->get();
        return response()->json([
            "success"=>true,
            "data" => DocumentResource::collection($document)]);
    }

    public function uploadFile(FileRequest $request ,  $id)
    {
        $document = Document::find($id);
        
        
        if($request->hasFile('file')){
            $path = $request->file('file')->store('documents');

            $file = new File(['path'=>$path]);

            $document->file()->save($file);

            return response()->json([
                "success"=>true,
                "file"=>$path                
            ]);
        }else{
            return response()->json([
                "success"=>false,             
            ]);
        }
            
    }
}
