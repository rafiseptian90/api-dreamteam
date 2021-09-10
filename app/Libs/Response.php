<?php

namespace App\Libs;

use Illuminate\Http\Response as HttpResponse;

class Response {
   // 200 JsonResponse
   public static function success($msg){
      return response()->json([
         'status_code' => HttpResponse::HTTP_OK,
         'message' => $msg
      ], HttpResponse::HTTP_OK);
   }

   public static function successWithData($msg, $data){
      return response()->json([
         'status_code' => HttpResponse::HTTP_OK,
         'message' => $msg,
         'data' => $data
      ], HttpResponse::HTTP_OK);
   }

   // 422 JsonResponse
   public static function error($msg, $data){
      return response()->json([
         'status_code' => HttpResponse::HTTP_UNPROCESSABLE_ENTITY,
         'message' => $msg,
         'data' => $data
      ], HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
   }

   // 403
   public static function forbidden($msg, $data){
      return response()->json([
         'status_code' => HttpResponse::HTTP_FORBIDDEN,
         'message' => $msg,
         'data' => $data
      ], HttpResponse::HTTP_FORBIDDEN);
   }

   public static function notFound($msg){
      return response()->json([
         'status_code' => HttpResponse::HTTP_NOT_FOUND,
         'message' => $msg
      ], HttpResponse::HTTP_NOT_FOUND);
   }
}