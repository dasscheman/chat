<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DilemmaUitkomst extends Model
{
    const STATUS_INDEWACHT = 1;
    const STATUS_AFGESLOTEN = 2;

    const CHOISE_COORPORATE = 1;
    const CHOISE_SABOTAGE = 2;

    /**
     * Return list of type codes and labels
     * @return array
     */
    public static function listStatus()
    {
        return [
            self::STATUS_INDEWACHT => 'In de wacht',
            self::STATUS_AFGESLOTEN => 'Afgesloten',
        ];
    }

    /**
     * Return list of type codes and labels
     * @return array
     */
    public static function listChoise()
    {
        return [
            self::CHOISE_COORPORATE => 'Samenwerken',
            self::CHOISE_SABOTAGE => 'Saboteren',
        ];
    }

    public function typeStatus()
    {
        return self::listStatus()[$this->status];
    }

    public function typeChoise()
    {
        return self::listChoise()[$this->choise];
    }

    protected $fillable = ['dilemma_id', 'user_id_sender',
        'user_id_receiver', 'status', 'choise'];

    public function dilemma()
    {
       return $this->belongsTo(Dilemma::class);
    }

    public function userSender()
    {
       return $this->belongsTo(User::class, 'user_id_sender', 'id');
    }

    public function userReceiver()
    {
       return $this->belongsTo(user::class, 'user_id_receiver', 'id');
    }

}
