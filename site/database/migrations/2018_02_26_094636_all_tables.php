<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Addresses', function (Blueprint $table){
            $table->increments('id');
            $table->string('streetName', 45);
            $table->string('houseNumber', 10);
            $table->string('postalCode', 10);
            $table->string('city', 45);
            $table->timestamps();
        });

        Schema::create('Categories', function (Blueprint $table){
            $table->increments('id');
            $table->string('name', 45);
            $table->mediumText('description')->nullable();
            $table->integer('imageID')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::create('ContactData', function (Blueprint $table){
            $table->increments('id');
            $table->string('email', 45);
            $table->string('phoneNumber', 20);
            $table->integer('addressID')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::create('OrderProducts', function (Blueprint $table){
            $table->increments('id');
            $table->integer('orderID')->unsigned()->nullable();
            $table->integer('productID')->unsigned()->nullable();
            $table->integer('amount');        
            $table->timestamps();  
        });      

        Schema::create('OrderStatusHistory', function (Blueprint $table){
            $table->increments('id');
            $table->integer('orderID')->unsigned()->nullable();
            $table->integer('orderStatusID')->unsigned()->nullable();
            $table->dateTime('statusDatetime');
            $table->timestamps();
        });

        Schema::create('OrderStatuses', function (Blueprint $table){
            $table->increments('id');
            $table->mediumText('description');
            $table->timestamps();
        });

        Schema::create('Orders', function (Blueprint $table){
            $table->increments('id');
            $table->integer('userID')->unsigned()->nullable();
            $table->string('uniqueOrderID');
            $table->timestamps();
        }); 

        Schema::create('Products', function (Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->mediumText('description')->nullable();
            $table->decimal('price');
            $table->decimal('btw');
            $table->integer('imageID')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::create('Properties', function (Blueprint $table){
            $table->increments('id');
            $table->string('name', 45);
            $table->mediumText('description')->nullable();
            $table->integer('categoryID')->unsigned()->nullable();
            $table->integer('datatype')->unsigned()->nullable();
            $table->string('postfix', 45)->nullable();
            $table->string('prefix', 45)->nullable();
            $table->timestamps();
        }); 

        Schema::create('PropertyValues', function (Blueprint $table){
            $table->increments('id');
            $table->integer('propertyID')->unsigned()->nullable();
            $table->integer('productID')->unsigned()->nullable();
            $table->string('value');
            $table->timestamps();
        });

        Schema::create('RepairProducts', function (Blueprint $table){
            $table->increments('id');
            $table->integer('repairID')->unsigned()->nullable();
            $table->integer('productID')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::create('RepairStatusHistory', function (Blueprint $table){
            $table->increments('id');
            $table->integer('repairID')->unsigned()->nullable();
            $table->integer('repairStatusID')->unsigned()->nullable();
            $table->dateTime('statusDatetime');
            $table->timestamps();
        });

        Schema::create('RepairStatuses', function (Blueprint $table){
            $table->increments('id');
            $table->mediumText('description');
            $table->timestamps();
        });

        Schema::create('Repairs', function (Blueprint $table){
            $table->increments('id');
            $table->integer('userID')->unsigned()->nullable();
            $table->mediumText('password')->nullable();
            $table->string('fileUrl')->nullable();
            $table->mediumText('description')->nullable();
            $table->dateTime('requestedOn');
            $table->timestamps();
        });

        Schema::create('StockProducts', function (Blueprint $table){
            $table->increments('id');
            $table->integer('productID')->unsigned()->nullable();
            $table->integer('amount')->unsigned();
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('firstName', 45);
            $table->string('middleName', 45)->nullable();
            $table->string('lastName', 45);
            $table->integer('admin')->default(0);
            $table->string('phoneNumber', 45);
            $table->integer('addressID')->unsigned()->nullable();
            $table->integer('deliveryAddressID')->unsigned()->nullable();
            $table->integer('disabled')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

        schema::create('Commercials', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('isBanner')->default(0);
            $table->integer('imageID')->unsigned()->nullable();
            $table->string('caption')->nullable();
            $table->timestamps();
        });

        Schema::create('Images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('folder');
            $table->string('filename');
            $table->timestamps();
        });

        Schema::create('SaleProducts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('productID')->unsigned()->nullable();
            $table->decimal('saleAmount');
            $table->boolean('percent');
            $table->dateTime('startDate')->nullable();
            $table->dateTime('endDate')->nullable();
            $table->timestamps();
        });

        Schema::table('ContactData', function ($table){
            $table->foreign('addressID')->references('id')->on('Addresses');
        });

        Schema::table('OrderProducts', function($table) {
            $table->foreign('orderID')->references('id')->on('Orders');
            $table->foreign('productID')->references('id')->on('Products');
        });

        Schema::table('OrderStatusHistory', function ($table){
            $table->foreign('orderID')->references('id')->on('Orders');
            $table->foreign('orderStatusID')->references('id')->on('OrderStatuses');
        });

        Schema::table('Orders', function ($table){
            $table->foreign('userID')->references('id')->on('users');
        }); 

        Schema::table('Properties', function ($table){
            $table->foreign('categoryID')->references('id')->on('Categories');
        });

        Schema::table('PropertyValues', function ($table){
            $table->foreign('propertyID')->references('id')->on('Properties');
            $table->foreign('productID')->references('id')->on('Products');
        });

        Schema::table('RepairProducts', function ($table){
            $table->foreign('repairID')->references('id')->on('Repairs');
            $table->foreign('productID')->references('id')->on('Products');
        });

        Schema::table('RepairStatusHistory', function ($table){
            $table->foreign('repairID')->references('id')->on('Repairs');
        });

        Schema::table('Repairs', function ($table){
            $table->foreign('userID')->references('id')->on('users');
        });

        Schema::table('StockProducts', function ($table){
            $table->foreign('productID')->references('id')->on('Products');
        });

        Schema::table('users', function ($table){
            $table->foreign('addressID')->references('id')->on('Addresses');
            $table->foreign('deliveryAddressID')->references('id')->on('Addresses');
        });

        Schema::table('Categories', function ($table){
            $table->foreign('imageID')->references('id')->on('Images');
        });

        Schema::table('Products', function ($table){
            $table->foreign('imageID')->references('id')->on('Images');
        });

        Schema::table('SaleProducts', function ($table){
            $table->foreign('productID')->references('id')->on('Products');
        });
    }   

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Addresses');
        Schema::dropIfExists('Categories');
        Schema::dropIfExists('ContactData');
        Schema::dropIfExists('OrderProducts');
        Schema::dropIfExists('OrderStatusHistory');
        Schema::dropIfExists('OrderStatuses');
        Schema::dropIfExists('Orders');
        Schema::dropIfExists('Products');
        Schema::dropIfExists('Properties');
        Schema::dropIfExists('PropertyValues');
        Schema::dropIfExists('RepairProducts');
        Schema::dropIfExists('RepairStatusHistory');
        Schema::dropIfExists('RepairStatuses');
        Schema::dropIfExists('Repairs');
        Schema::dropIfExists('StockProducts');
        Schema::dropIfExists('users');
        Schema::dropIfExists('Images');
        Schema::dropIfExists('SaleProducts');
    }
}
