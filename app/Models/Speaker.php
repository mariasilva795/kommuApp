<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model{

  protected $table = "speakers";

  public function Theme(){
  	return $this->belongsToMany(Theme::class, 'speaker_theme');
  }

  public $fillable = ['name'];

}


?>