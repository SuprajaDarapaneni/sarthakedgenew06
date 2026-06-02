<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable("certificate_templates")) {
            Schema::create("certificate_templates", static function (Blueprint $table) {
                $table->id();
                $table->string("name");
                $table->string("type");
                $table->string("page_layout");
                $table->string("height");
                $table->string("width");
                $table->integer("user_image_shape");
                $table->string("image_size");
                $table->string("background_image");
                $table->longText("description");
                $table->foreignId("school_id")->references("id")->on("schools")->onDelete("cascade");
                $table->timestamps();
            });
        }

        if (Schema::hasTable("sliders") && !Schema::hasColumn("sliders", "type")) {
            Schema::table("sliders", static function (Blueprint $table) {
                $table->integer("type")->default(1)->comment("1 => App, 2 => web, 3 => Both")->after("link");
            });
        }

        if (Schema::hasTable("faqs") && !Schema::hasColumn("faqs", "school_id")) {
            Schema::table("faqs", static function (Blueprint $table) {
                $table->foreignId("school_id")->after("description")->nullable(true)->references("id")->on("schools")->onDelete("cascade");
            });
        }

        if (!Schema::hasTable("class_groups")) {
            Schema::create("class_groups", static function (Blueprint $table) {
                $table->id();
                $table->string("name");
                $table->string("description")->nullable();
                $table->foreignId("school_id")->references("id")->on("schools")->onDelete("cascade");
                $table->timestamps();
            });
        }

        if (!Schema::hasTable("payroll_settings")) {
            Schema::create("payroll_settings", static function (Blueprint $table) {
                $table->id();
                $table->string("name");
                $table->double("amount")->nullable();
                $table->float("percentage")->nullable();
                $table->string("type")->nullable();
                $table->foreignId("school_id")->references("id")->on("schools")->onDelete("cascade");
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable("staff_salaries")) {
            Schema::create("staff_salaries", static function (Blueprint $table) {
                $table->id();
                $table->foreignId("staff_id")->references("id")->on("staffs")->onDelete("cascade");
                $table->foreignId("payroll_setting_id")->references("id")->on("payroll_settings")->onDelete("cascade");
                $table->double("amount");
                $table->foreignId("school_id")->references("id")->on("schools")->onDelete("cascade");
                $table->unique(["staff_id", "payroll_setting_id"], "unique_ids");
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
    }
};
