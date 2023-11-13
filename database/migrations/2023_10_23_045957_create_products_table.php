<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable()->constrained('countries')->cascadeOnDelete();
            $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            $table->string('ref_code', 50)->nullable();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->string('sku_code', 50)->unique()->nullable();
            $table->string('mf_code', 50)->unique()->nullable();
            $table->string('product_code', 50)->nullable();
            $table->json('tags')->nullable();
            $table->json('attribute_id')->nullable();
            $table->json('color_id')->nullable();
            $table->longText('short_desc')->nullable();
            $table->longText('overview')->nullable();
            $table->longText('specification')->nullable();
            $table->longText('accessories')->nullable();
            $table->longText('warranty')->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->integer('qty')->default(1);
            $table->string('stock', 50)->nullable();
            $table->double('price')->nullable();
            $table->double('sas_price')->nullable();
            $table->double('discount')->nullable();
            $table->string('deal', 50)->nullable();
            $table->json('industry')->nullable();
            $table->json('solution')->nullable();
            $table->enum('refurbished', ['0', '1'])->default('0');
            $table->enum('price_status', ['rfq', 'price', 'offer_price', 'starting_price'])->default('price');
            $table->enum('rfq', ['0', '1'])->default('0');
            $table->string('product_type', 50);
            $table->foreignId('category_id')->nullable()->constrained('categories')->cascadeOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->cascadeOnDelete();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('product_status', ['sourcing', 'product'])->default('sourcing');
            $table->double('source_one_price')->nullable();
            $table->double('source_two_price')->nullable();
            $table->string('source_one_name', 255)->nullable();
            $table->string('source_two_name', 255)->nullable();
            $table->string('source_one_link', 255)->nullable();
            $table->string('source_two_link', 255)->nullable();
            $table->double('competitor_one_price')->nullable();
            $table->double('competitor_two_price')->nullable();
            $table->string('competitor_one_name', 255)->nullable();
            $table->string('competitor_two_name', 255)->nullable();
            $table->string('competitor_one_link', 255)->nullable();
            $table->string('competitor_two_link', 255)->nullable();
            $table->enum('source_one_approval', ['0', '1'])->default('0');
            $table->enum('source_two_approval', ['0', '1'])->default('0');
            $table->string('notification_days', 50)->nullable();
            $table->date('create_date')->nullable();
            $table->enum('solid_source', ['yes', 'no'])->default('no');
            $table->enum('direct_principal', ['yes', 'no'])->default('no');
            $table->enum('agreement', ['yes', 'no'])->default('no');
            $table->string('source_type', 50)->nullable();
            $table->text('source_contact')->nullable();
            $table->string('action_status', 50)->nullable();
            $table->string('added_by', 255)->nullable();
            $table->double('source_one_estimate_time')->nullable();
            $table->double('source_one_principal_time')->nullable();
            $table->double('source_one_shipping_time')->nullable();
            $table->string('source_one_location', 255)->nullable();
            $table->string('source_one_country', 255)->nullable();
            $table->double('source_two_estimate_time')->nullable();
            $table->double('source_two_principal_time')->nullable();
            $table->double('source_two_shipping_time')->nullable();
            $table->string('source_two_location', 255)->nullable();
            $table->string('source_two_country', 255)->nullable();
            $table->text('rejection_note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
