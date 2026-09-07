<?php
namespace App\Services;

use App\Models\Appointment;

Class AppointmentService{

    public function __construct(
        protected Appointment $model
    ){}


    public function getAll(){
        return $this->model->all()->toArray();
    }
}