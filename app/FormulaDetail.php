<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormulaDetail extends Model
{
  protected $table = 'formula_details';
  protected $guarded  = ['id'];

  public function formula()
  {
      return $this->belongsTo(Formula::class,'formula_id');
  }    

  public function material()
  {
      return $this->belongsTo(Material::class,'material_id');
  }    

  public function sampleMaterial()
  {
      return $this->belongsTo(SampleMaterial::class,'material_id');
  }    

}
