<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Theme extends Model{

  protected $table = "themes";

  public function Speaker(){
  	return $this->belongsToMany(Speaker::class, 'speaker_theme');
  }

}


?>