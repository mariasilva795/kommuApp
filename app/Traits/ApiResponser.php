<?php

namespace App\Traits;
use Illuminate\Http\Response;

trait ApiResponser
{
  /**
   * Construye respuesta con status 200
   */

  public function successResponse($data, $code = Response::HTTP_OK){
      return response()->json(['data'=>$data], $code);
  }

  /**
   * Construye respuesta con status failed 400, 422 etc.
  */

  public function failedResponse($message, $code){   
      return  response()->json(['error'=>$message, 'code'=>$code]);
  }

}
