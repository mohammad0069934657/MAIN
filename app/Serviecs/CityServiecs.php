<?php
namespace app\Serviecs;

class cityServiecs{
    public function getCity($data){
        $result = getCities($data);
        return $result;
    }
    public function creatCity($data){
        $result = addCity($data);
        return $result;
    }
    
    public function updateCityName($city_id,$name){
        $result = changeCityName($city_id,$name);
        return $result;
    }
    
    public function deleteCity($city_id){
        $result = deleteCity($city_id);
        return $result;
}
}