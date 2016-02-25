<?php

  /**
  * @backupGlobals disabled
  * @backupStaticAttributes disabled
  */

  require_once "src/Restaurant.php";

  $server = 'mysql:host=localhost;dbname=food_test';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server, $username, $password);

  class RestaurantTest extends PHPUnit_Framework_TestCase
  {
      protected function tearDown()
      {
        Restaurant::deleteAll();
      }

      function test_getName()
      {
        //Arrange
        $name = "Pho Shizzle";
        $test_Restaurant = new Restaurant($name);
        //Act
        $result = $test_Restaurant->getName();
        //Assert
        $this->assertEquals($name, $result);
      }
      function test_save()
      {
        //Arrange
        $name = "Pho Shizzle";
        $test_Restaurant = new Restaurant($name);
        $test_Restaurant->save();
        //Act
        $result = Restaurant::getAll();
        //Assert
        $this->assertEquals($test_Restaurant, $result[0]);
      }
      function test_getAll()
      {
        //Arrange
        $name = "Pho Shizzle";
        $name2 = "El Tarasco";
        $test_Restaurant = new Restaurant($name);
        $test_Restaurant->save();
        $test_Restaurant2 = new Restaurant($name2);
        $test_Restaurant2->save();
        //Act
        $result = Restaurant::getAll();
        //Assess
        $this->assertEquals($result, [$test_Restaurant, $test_Restaurant2]);
      }

      function test_deleteAll()
      {
        //Arrange
        $name = "Pho Shizzle";
        $name2 = "El Tarasco";
        $test_Restaurant = new Restaurant($name);
        $test_Restaurant->save();
        $test_Restaurant2 = new Restaurant($name2);
        $test_Restaurant2->save();

        //Act
        Restaurant::deleteAll();
        $result = Restaurant::getAll();

        //Assert
        $this->assertEquals([], $result);
      }
      function test_find()
      {
        //Arrange
        $name = "Pho Shizzle";
        $name2 = "El Tarasco";
        $test_Restaurant = new Restaurant($name);
        $test_Restaurant->save();
        $test_Restaurant2 = new Restaurant($name2);
        $test_Restaurant2->save();
        //Act
        $id = $test_Restaurant->getId();
        $result = Restaurant::find($id);
        //Assert
        $this->assertEquals($test_Restaurant, $result);
      }
      
        function testUpdate()
      {
        //Arrange
        $name = "Pho Shizzle";
        $id = null;
        $test_Restaurant = new Restaurant($name, $id);
        $test_Restaurant->save();
        $new_name = "Pho Kim";
        //Act
        $test_Restaurant->update($new_name);
        //Asses
        $this->assertEquals("Pho Kim", $test_Restaurant->getName());
      }
      function testDelete()
      {
        //Arrange
        $name = "Pho Shizzle";
        $id = null;
        $test_Restaurant = new Restaurant($name, $id);
        $test_Restaurant->save();

        $name2 = "Pho Kim";
        $test_Restaurant2 = new Restaurant($name2, $id);
        $test_Restaurant2->save();
        //Act
        $test_Restaurant->delete();
        //Assert
        $this->assertEquals([$test_Restaurant2], Restaurant::getAll());
      }

  }

?>
