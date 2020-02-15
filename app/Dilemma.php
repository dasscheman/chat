<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dilemma extends Model
{
    protected $fillable = ['naam', 'dilemma', 'goed', 'fout', 'status'];

    public function uitkomsten()
    {
        return $this->hasMany(DilemmaUitkomst::class);
    }

    public function showResult($toUser)
    {
          return $this->uitkomsten()
              ->where('status', DilemmaUitkomst::STATUS_AFGESLOTEN)
              ->where('user_id_sender', auth()->user()->id)
              ->Where('user_id_receiver', $toUser)
              ->exists();
    }

    public function getResult($toUser)
    {
          if(!$this->showResult($toUser)) {
              return false;
          }

          if($this->currentUserWon($toUser)) {
              return $this->goed;
          }
          if(!$this->currentUserWon($toUser)) {
              return $this->fout;
          }
          return;
    }

    public function currentUserWon($toUser)
    {
        $uikomstCurrentUser =  $this->uitkomsten()
            ->where('user_id_sender', auth()->user()->id)
            ->Where('user_id_receiver', $toUser)
            ->Where('status', DilemmaUitkomst::STATUS_AFGESLOTEN)
            ->first();

        $uikomstOtherUser =  $this->uitkomsten()
            ->where('user_id_sender', $toUser)
            ->Where('user_id_receiver', auth()->user()->id)
            ->Where('status', DilemmaUitkomst::STATUS_AFGESLOTEN)
            ->first();

        if(!$uikomstCurrentUser || !$uikomstOtherUser) {
            return;
        }

        if($uikomstCurrentUser->choise == DilemmaUitkomst::CHOISE_COORPORATE &&
           $uikomstOtherUser->choise == DilemmaUitkomst::CHOISE_COORPORATE) {
             return true;
        }


        if($uikomstCurrentUser->choise == DilemmaUitkomst::CHOISE_SABOTAGE &&
           $uikomstOtherUser->choise == DilemmaUitkomst::CHOISE_COORPORATE) {
             return true;
        }
        return false;
    }

    public function showButtons($toUser)
    {
        if($this->finishedOtherUser($toUser)) {
            // Als de ander dit dilemma al uitgewerkt heeft
            return false;
        }
        if($this->finishedCurrentUser()) {
            return false;
        }
        if($this->startedCurrentUserWithOtherUser($toUser)) {
            return false;
        }
        return true;
    }

    public function waitOtherUser($toUser)
    {
        $wait = DilemmaUitkomst::where('dilemma_id', $this->id)
            ->where('user_id_sender', auth()->user()->id)
            ->where('user_id_receiver', $toUser)
            ->where('status', DilemmaUitkomst::STATUS_INDEWACHT)
            ->exists();
        if($wait) {
            return true;
        }
        return false;
    }

    public function finishedCurrentUser()
    {
        return DilemmaUitkomst::where('dilemma_id', $this->id)
            ->where('user_id_sender', auth()->user()->id)
            ->where('status', DilemmaUitkomst::STATUS_AFGESLOTEN)
            ->exists();
    }

    public function finishedOtherUser($toUser)
    {
        return DilemmaUitkomst::where('dilemma_id', $this->id)
            ->where('user_id_sender', $toUser)
            ->where('status', DilemmaUitkomst::STATUS_AFGESLOTEN)
            ->exists();
    }

    public function startedCurrentUserWithOtherUser($toUser)
    {
        return DilemmaUitkomst::where('dilemma_id', $this->id)
            ->where('user_id_sender', auth()->user()->id)
            ->where('user_id_receiver', $toUser)
            ->exists();
    }
}
