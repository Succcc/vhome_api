<?php
/**
 * Created by PhpStorm.
 * User: sl
 * Date: 2017/10/29
 * Time: 下午11:02
 * Hope deferred makes the heart sick,but desire fulfilled is a tree of life.
 */

namespace App\Mapper;
use App\Controller\TestController;
use App\Controller\UsersController;

class Route
{
  public static function map(){
      return [
          UsersController::class,
          TestController::class
      ];
  }
}