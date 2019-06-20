<?php

namespace App\Http\Controllers;
use App\Models\Speaker;
use App\Models\Theme;
use App\Models\Speaker_Theme;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Validator;


class SpeakerController extends Controller
{
    use ApiResponser;

    public function index(Request $request)
    {
      $rules = [
        'initial_page' => 'required_with:end_page|integer',
        'end_page' => 'required_with:initial_page|integer'
      ];

      $this->validate($request, $rules);
      
      if(($request->initial_page < $request->end_page) && ($request->end_page > $request->initial_page)){
      
        $speaker = Speaker::with('theme')->offset($request->initial_page)->limit($request->end_page)->get(); 

        return $this->successResponse(($speaker), Response::HTTP_CREATED);
      
      }else{
        return $this->failedResponse('Verifique datos introducidos', Response::HTTP_UNPROCESSABLE_ENTITY);
      }

      if(empty($speaker)) {       
        return $this->failedResponse('No se encontró ningun dato en la base de datos', Response::HTTP_UNPROCESSABLE_ENTITY);
      }
    }

    public function show(Request $request){
      

      $speaker = Speaker::with('theme')->find($request->id);

      if(empty($speaker))   { 

        return $this->failedResponse('No se encontró ningun dato en la base de datos', Response::HTTP_UNPROCESSABLE_ENTITY); 
      
      }else{
    
        return $this->successResponse(($speaker), Response::HTTP_OK);
      }
    }

    public function destroy(Request $request)
    {
      $speaker = Speaker::with('theme')->find($request->id);
      
      if(empty($speaker))   { 
        return $this->failedResponse('No se encontró ningun dato en la base de datos', Response::HTTP_UNPROCESSABLE_ENTITY); 
      }

      $speaker->delete();

      return $this->successResponse("Datos eliminados existosamente", Response::HTTP_CREATED);
      
    }

    public function store(Request $request){

      $rules =[
        'id' => 'required',
        'name' => 'required|max:200',
        'description' => 'required',
        'event_id' => 'required|max:10',
        'order' => 'required',
        'created_at' => 'required',
        'updated_at' => 'required',
        'theme_id' => 'required'
      ];
      
      $this->validate($request, $rules);

      $theme = Speaker_Theme::find($theme_id);

      if(empty($theme))   { 
        return $this->failedResponse('No se encontró ningun dato en la base de datos', Response::HTTP_UNPROCESSABLE_ENTITY); 
      }

      $speaker = new Speaker();
      $speaker->id = $request->id;
      $speaker->name = $request->name;
      $speaker->description = $request->description;
      $speaker->event_id = $request->event_id;
      $speaker->order = $request->order;
      $speaker->created_at = Carbon::now();
      $speaker->updated_at = Carbon::now();
      $speaker->save();

      $speaker = speaker::find($request->id);
      $speaker->theme()->attach($theme_id);
      
      return $this->successResponse('Registro almacenado', Response::HTTP_OK);

    }

    public function update(Request $request, $id){

      $rules =[
        'name' => 'required|max:200',
        'description' => 'required',
        'event_id' => 'required|max:10',
        'order' => 'required',
        'created_at' => 'required',
        'updated_at' => 'required',
        'theme_id' => 'required'
      ];
      
      $this->validate($request, $rules);

      $speaker = Speaker::with('theme')->find($request->id);
      if(empty($speaker))   { 
        return $this->failedResponse('No se encontró ningun dato en la base de datos', Response::HTTP_UNPROCESSABLE_ENTITY); 
      }

      $speaker->name = $request->name;
      $speaker->description = $request->description;
      $speaker->event_id = $request->event_id;
      $speaker->order = $request->order;
      $speaker->created_at = Carbon::now();
      $speaker->updated_at = Carbon::now();
      $speaker->save();

      return $this->successResponse('Registro actualizado', Response::HTTP_OK);

    }

}

        
?>