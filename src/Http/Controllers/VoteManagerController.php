<?php

namespace Inani\Larapoll\Http\Controllers;

use Exception;
use Inani\Larapoll\Poll;
use Inani\Larapoll\Guest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Inscrit\Entities\Inscrit;

class VoteManagerController extends Controller
{
    /**
     * Make a Vote
     *
     * @param Poll $poll
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function vote(Poll $poll, Request $request)
    {

        try {
           
            $vote = $this->resolveVoter($request, $poll)
                ->poll($poll)
                ->vote($request->get('options'));

            if($vote){
                return back()->with('success', 'Vote Done');
            }
        }catch (Exception $e){
            return back()->with('errors', $e->getMessage());
        }
    }

    /**
     * Get the instance of the voter
     *
     * @param Request $request
     * @param Poll $poll
     * @return Guest|mixed
     */
    protected function resolveVoter(Request $request, Poll $poll)
    {
       /*  if($poll->canGuestVote()){
            return new Guest($request);
        } */
       
        if ($request->inscritId) { 
            return Inscrit::find($request->inscritId); 
        } 
    //  return $request->user(config('larapoll_config.admin_guard'));       
        
    }
}
