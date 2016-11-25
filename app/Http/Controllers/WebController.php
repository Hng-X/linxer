<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
/**
 * Handles requests through the browser ie at the live site
 */
class WebController extends Controller
{
    public function viewLinks($teamSlug)
    {
//                      $teamName="HngX";
//$teamId="Txjrd24";
//$query="";
//$results=[];
        
        $team = explode('-', $teamSlug);
        $links = Link::where('team_id', $team[0])->get();
        print_r($links);
        
        
             //parse $teamId and $teamName from $teamSlug
//        if (isset($_GET["query"])) {
//        $query=$_GET["query"];
//            //$results=search($teamId, $query);
//            return view('listing', ["teamName" => $teamName, "query" => $query, "results" => $results]);
//        } else {
//            //$results=getAllLinks($teamId);
//            return view('listing', ["teamName" => $teamName, "results" => $results]);
//        }
    }
    

    /** Retrieves all a team's links
     *
     * @param $team The id of the team
     * @param $queryString The query string
     */
    public function getAllLinks($team)
    {
    
    }

    /** Searches for a team's links matching a given search query
     *
     * @param $team The id of the team
     * @param $queryString The query string
     */
    public function search($team, $queryString)
    {
//parse query string
//perform search

    }
}
