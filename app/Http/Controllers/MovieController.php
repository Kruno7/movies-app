<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{

    /**
     *  @OA\Get(
     **  path="/api/movie",
     *   tags={"Movie By Title"},
     *   summary="Get the details of movie. Using only title or title and year params",
     *   operationId="movie",
     *
     *  @OA\Parameter(
     *      name="title",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="year",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *     
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *  
     *   @OA\Response(
     *       response=400,
     *       description="Bad Request"
     *   ),
     * 
     *   @OA\Response(
     *      response=404,
     *      description="Not found"
     *   ),
     * 
     *)
     **/
    /**
     * movie api
     */
    
    
    public function getMovieByTitle (Request $request)
    {
        $title = $request->get('title');
        $year  = $request->get('year');

        if ($title && !$year) {
            $data = Movie::where('title', 'like', "%$title%")->first();
            if ($data) {
                return response()->json($data, 200);
            }
            return response()->json([
                'message' => 'The movie was not found in the local database'
            ], 404);
            
        } else if ($title && $year) {
            $data = Movie::where('title', 'like', "%$title%")
            ->where('year', $year)->first();
            if ($data) {
                return response()->json($data, 200);
            }
            return response()->json([
                'message' => 'The movie was not found in the local database'
            ], 404);
            
        } else {
            return response([
                'message' => 'Parameters are required'
            ], 400);
        }
    }

    /**
     * @OA\Get(
     ** path="/api/movie-id",
     *   tags={"Movie By Id"},
     *   summary="Get the details of movie. Using only imdb Id params",
     *   operationId="movie_id",
     *
     *   @OA\Parameter(
     *      name="imdbid",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
 
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Not found"
     *   ),
     *   @OA\Response(
     *      response=403,
     *      description="Forbidden"
     *   )
     *)
     **/
    /**
     * movie id api
     */


    public function getMovieById (Request $request)
    {
        $imdbid  = $request->get('imdbid');

        $data = Movie::where('imdbid', $imdbid)->first();
        if ($data) {
            return Movie::where('imdbid', $imdbid)->first();
        } 
        return response([
            'message' => 'Not found',
        ], 404);
    }


    public function storeMovieByTitle (Request $request)
    {
        if ($request->data) {
            return $request->data;
        } else {
            return Movie::create($request->get('dataMovie'));
        }
    }

    
    public function storeMovieById (Request $request)
    {
        if ($request->data) {
            return $request->data;
        } else {
            return Movie::create($request->get('dataMovie'));
        }
    }

    /**
     *  @OA\Post(
     **  path="/api/store-movie",
     *   tags={"Store Movie"},
     *   summary="Store movie",
     *   operationId="movie",
     *
     *  @OA\Parameter(
     *      name="title",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="year",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   
     *   @OA\Parameter(
     *      name="released",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * 
     *    @OA\Parameter(
     *      name="runtime",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * 
     *    @OA\Parameter(
     *      name="genre",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * 
     *    @OA\Parameter(
     *      name="director",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * 
     *    @OA\Parameter(
     *      name="actors",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * 
     *   @OA\Parameter(
     *      name="plot",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="language",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="country",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * 
     *  @OA\Parameter(
     *      name="type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     * 
     *  @OA\Parameter(
     *      name="imdbid",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   
     *   @OA\Response(
     *       response=422,
     *       description="Unprocessable Entity"
     *   )
     *)
     **/

    public function storeMovie (Request $request)
    {
        $movie = Movie::create($request->all());
        if ($movie) {
            return response()->json([
                'message' => 'success',
                'movie'   => $movie
            ], 201);
        }
        return response()->json([
            'message' => 'Something is wrong'
        ], 500);
    }
}
