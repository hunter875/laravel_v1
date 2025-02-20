<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('hotel_name');
            $table->string('address1');
            $table->string('address2');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->string('tax_code');
            $table->string('telephone');
            $table->string('fax');
            $table->date('order_date');
            $table->string('email');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        // Có thể chỉ cần drop bảng vì dropIfExists sẽ tự động xóa các ràng buộc
        Schema::dropIfExists('hotels');
    }
};
