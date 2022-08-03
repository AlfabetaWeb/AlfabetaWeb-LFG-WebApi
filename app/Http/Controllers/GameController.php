<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    //CREATE NEW GAME
    public function createGame(Request $request)
    {
        try {
            Log::info("Creating a game");

            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => $validator->errors()
                    ],
                    400
                );
            };

            $title = $request->input('title');
            $userId = auth()->user()->id;

            $game = new Game();
            $game->title = $title;
            $game->user_id = $userId;

            $game->save();


            return response()->json(
                [
                    'success' => true,
                    'message' => "Game created"
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::error("Error creating game: " . $exception->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => "Error creating games"
                ],
                500
            );
        }
    }

    //LIST ALL GAMES
    public function getAllGames()
    {
        try {
            Log::info("Getting all Games");
            $userId = auth()->user()->id;

            // $tasks = Task::query()
            //     ->where('user_id',$userId)
            //     ->get()
            //     ->toArray();

            $games = User::query()->find($userId)->games;

            return response()->json(
                [
                    'success' => true,
                    'message' => "Get all Games",
                    'data' => $games
                ],
                200
            );
        } catch (\Exception $exception) {
            Log::error("Error getting gamek: " . $exception->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => "Error getting games"
                ],
                500
            );
        }
    }
}
