<?php

namespace App\Libs;

use Illuminate\Http\Response as HttpResponse;

class Response {
   // 200 JsonResponse
   public static function success(string $msg){
      return response()->json([
         'code_status' => HttpResponse::HTTP_OK,
         'status' => $msg
      ], HttpResponse::HTTP_OK);
   }

   public static function successWithData(string $msg, $data){
      return response()->json([
         'code_status' => HttpResponse::HTTP_OK,
         'status' => $msg,
         'data' => $data
      ], HttpResponse::HTTP_OK);
   }

   // 401 Unauthorized
   public static function unauthorized(string $msg){
      return response()->json([
         'code_status' => HttpResponse::HTTP_UNAUTHORIZED,
         'status' => $msg
      ], HttpResponse::HTTP_UNAUTHORIZED);
   }

   // 422 JsonResponse
   public static function error(string $msg){
      return response()->json([
         'code_status' => HttpResponse::HTTP_UNPROCESSABLE_ENTITY,
         'status' => $msg
      ], HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
   }

   // 403
   public static function forbidden(string $msg){
      return response()->json([
         'code_status' => HttpResponse::HTTP_FORBIDDEN,
         'status' => $msg
      ], HttpResponse::HTTP_FORBIDDEN);
   }

   public static function notFound(string $msg){
      return response()->json([
         'code_status' => HttpResponse::HTTP_NOT_FOUND,
         'status' => $msg
      ], HttpResponse::HTTP_NOT_FOUND);
   }
}