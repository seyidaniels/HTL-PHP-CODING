<?
use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent{
    protected $table = "users";
    
    protected $fillable = ['username', 'mobile_number', 'amount_to_bill'];
}