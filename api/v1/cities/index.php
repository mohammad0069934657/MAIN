<?php
include_once "../../../autoloder.php";
use \app\Utilities\Response;
use \app\Serviecs\cityServiecs;
use \app\Utilities\CacheUtility;

#check Autohorization  (use a jwt token)
$token = getBearerToken();

// Response::respondAndDie([$token],Response::HTTP_OK);
 $payload = isValidToken($token);
Response::respondAndDie($payload,Response::HTTP_OK);

#get request token and validate it


// CacheUtility::start();
// echo "start chache ".rand(1,10);
// CacheUtility::end();


// echo "endpoints is here ...";
// $cs = new cityServiecs();
//  $result = $cs->getCity((object)[1,2,3,4,5]);
// Response::respondAndDie($result,Response::HTTP_OK);
$request_method = $_SERVER['REQUEST_METHOD'];
$request_body = json_decode(file_get_contents("php://input"),true);
$city_service = new cityServiecs();
switch ($request_method) {
    case 'GET':
        CacheUtility::start();
        $province_id = $_GET['province_id'] ?? null;
        #do validate : $province_id
        // if(!province_validaor->is_valid_province($province_id))#@
        // Response::respondAndDie(["Error : Invalid province .."],Response::HTTP_NOT_FOUND);
        $request_data = ["province_id" => $province_id,
        'page'=>$_GET['page'] ?? null,
        'pagesize'=>$_GET['pagesize'] ?? null,
        'fields'=>$_GET['fields'] ?? null,
        'orderby'=>$_GET['orderby'] ?? null,
    ];
        $response = $city_service->getCity($request_data);
        if(empty($response))
        Response::respondAndDie($response,Response::HTTP_NOT_FOUND);
        echo Response::respond($response,Response::HTTP_OK);
        CacheUtility::end();
        die();
    case 'POST':
        if(!isValidProvince($request_body))
            Response::respondAndDie(['Invalid City Data...'],Response::HTTP_NOT_ACCEPTABLE);
            $response = $city_service->creatCity($request_body);
            Response::respondAndDie($response,Response::HTTP_CREATED);
        //Response::respondAndDie(['POST Request'],Response::HTTP_OK);
    case 'PUT':
       // Response::respondAndDie(['PUT Request'],Response::HTTP_OK);
       [$city_id,$city_name] = [$request_body['city_id'],$request_body['name']];
       if(empty([$city_id,$city_name]) || !is_numeric($city_id))
         Response::respondAndDie(["Invalid Data ... "],Response::HTTP_NOT_FOUND);
         $result = $city_service->updateCityName($city_id,$city_name);
         if($result == 0)
         Response::respondAndDie($result,Response::HTTP_NOT_FOUND);
         Response::respondAndDie($result,Response::HTTP_OK);

    case 'DELETE':
       // Response::respondAndDie(['DELETE Request'],Response::HTTP_OK);
       $cityId = $_GET['city_id'];
       if(empty($cityId) || !is_numeric($cityId))
       Response::respondAndDie(['Inavalid Key ...'],Response::HTTP_NOT_FOUND);
       $result = $city_service->deleteCity($cityId);
       Response::respondAndDie($result,Response::HTTP_OK);
    default:
    Response::respondAndDie(['invalid request Method'],Response::HTTP_METHOD_NOT_ALLOWED);
    
}






