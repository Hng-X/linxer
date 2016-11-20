<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Handles requests through the browser ie at the live site
 */
class WebController extends Controller
{
    public function viewLinks()
    {

        if (isset($_GET["query"])) {
            //$results=search($teamName, $_GET["query"]);
            return view('listing', $results);
        } else {
            //$results=getAllLinks($teamName);
            return view('listing');
        }
    }

    /** Retrieves all a team's links
     *
     * @param $team The name of the team
     * @param $queryString The query string
     */
    public function getAllLinks($team)
    {

    }

    /** Searches for a team's links matching a given search query
     *
     * @param $team The name of the team
     * @param $queryString The query string
     */
    public function search($team, $queryString)
    {

    }
}
