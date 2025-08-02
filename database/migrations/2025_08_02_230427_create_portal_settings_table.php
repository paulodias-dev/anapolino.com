<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('portal_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title');
            $table->string('site_description')->nullable();
            $table->string('domain')->unique();
            $table->string('default_language')->default('pt_BR');
            $table->json('supported_languages')->default('["pt_BR", "en"]');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable();
            $table->json('seo_meta')->nullable();
            $table->json('payment_methods')->nullable();
            $table->timestamps();
        });

        // Inserir registro inicial
        DB::table('portal_settings')->insert([
            'site_title' => 'Anapolino Classificados',
            'domain' => 'anapolino.com.br',
            'contact_email' => 'contato@anapolino.com.br',
            'contact_phone' => '(62) 3333-3333',
            'address' => 'Av. Goiás, 1000',
            'city' => 'Anápolis',
            'state' => 'GO',
            'zip_code' => '75000-000',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('portal_settings');
    }
};
