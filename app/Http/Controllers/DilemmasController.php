<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Events\PrivateMessageSent;
use App\Events\UitkomstSent;
use App\Models\Message;
use App\Models\User;
use App\Models\Dilemma;
use App\Models\DilemmaUitkomst;
use Illuminate\Http\Request;

class DilemmasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function fetchDilemmas(Request $request)
    {
        $toUser = $request->to_user;
        $dilemmas = Dilemma::with('uitkomsten', 'uitkomsten.userSender', 'uitkomsten.userReceiver')
            ->get();

        foreach($dilemmas as $key => $dilemma) {
            $dilemmas[$key]['show_buttons'] =  $dilemma->showButtons($toUser);
            $dilemmas[$key]['show_result'] =  $dilemma->showResult($toUser);
            $dilemmas[$key]['result'] = $dilemma->getResult($toUser);
            $dilemmas[$key]['wait_on_other_player'] = $dilemma->waitOtherUser($toUser);
            $dilemmas[$key]['current_user_finished'] = $dilemma->finishedCurrentUser();
            $dilemmas[$key]['other_user_finished'] = $dilemma->finishedOtherUser($toUser);
            $dilemmas[$key]['startd_with_other_user'] = $dilemma->startedCurrentUserWithOtherUser($toUser);

            $dilemmas[$key]['to_user'] = $toUser;
            $dilemmas[$key]['current_user'] = auth()->user()->id;
        }
        return $dilemmas;
    }

    public function fetchDilemmaUitkomsten()
    {
        $uitkomst = DilemmaUitkomst::with('dilemma')
            ->where('user_1_id', auth()->user()->id)
            ->get();

        return $uitkomst;
    }

    public function saveUitkomst(Request $request)
    {
          $uitkomst1 = DilemmaUitkomst::where('dilemma_id', $request->dilemma)
              ->where('user_id_sender', $request->to_user)
              ->where('user_id_receiver', auth()->user()->id)
              ->first();

          $uitkomst2 = new DilemmaUitkomst();
          $uitkomst2->dilemma_id = $request->dilemma;
          $uitkomst2->user_id_sender = auth()->user()->id;
          $uitkomst2->user_id_receiver = $request->to_user;
          $uitkomst2->choise = $request->choise;
          $uitkomst2->status = DilemmaUitkomst::STATUS_INDEWACHT;
          if($uitkomst1) {
              $uitkomst1->status = DilemmaUitkomst::STATUS_AFGESLOTEN;
              $uitkomst1->save();

              $uitkomst2->status = DilemmaUitkomst::STATUS_AFGESLOTEN;
          }

          $uitkomst2->save();

  	      broadcast(new UitkomstSent(auth()->user(), $uitkomst2));
          return ['status' => 'Keuze vastgelegd!'];
    }
}
