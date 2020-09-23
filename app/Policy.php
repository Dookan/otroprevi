<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;


class Policy extends Model
{
	use SoftDeletes, LogsActivity;

    protected static $logName = "Poliza";

    protected $table = "policies";

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'price_id',
        'vehicle_class_id',
        'client_name', 
        'client_lastname', 
        'client_ci', 'client_phone', 
        'client_email', 
        'client_address',
        'client_name_contractor',
        'client_lastname_contractor',
        'client_ci_contractor',
        'id_estado', 
        'id_parroquia',
        'id_municipio', 
        'vehicle_id', 
        'vehicle_type', 
        'vehicle_model', 
        'vehicle_brand', 
        'vehicle_weight', 
        'vehicle_bodywork_serial', 
        'vehicle_certificate_number', 
        'vehicle_motor_serial', 
        'vehicle_year', 
        'vehicle_color',
        'vehicle_registration'
    ];

    public function vehicle(){
    	return $this->belongsTo('App\Vehicle');
    }

    public function user(){					//aqui     //alla
    	return $this->belongsTo('App\User', 'user_id', 'id')->withTrashed();
    }

    public function price(){                 //aqui     //alla
        return $this->belongsTo('App\Price', 'price_id', 'id')->withTrashed();
    }

    public function class(){
        return $this->belongsTo('App\VehicleClass', 'vehicle_class_id')->withTrashed();
    }

    public function estado(){
        return $this->belongsTo('App\Estado', 'id_estado', 'id_estado');
    }

    public function municipio(){
        return $this->belongsTo('App\Municipio', 'id_municipio', 'id_municipio');
    }

    public function parroquia(){
        return $this->belongsTo('App\Parroquia', 'id_parroquia', 'id_parroquia');
    }    
}
