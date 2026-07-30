<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $mailLayouts = DB::table('mail_layouts')->get();
        foreach ($mailLayouts as $mailLayout) {
            $updatedLayout = str_replace('\Main\Models\Image_tool_model::resize', 'media_thumb', $mailLayout->layout);
            DB::table('mail_layouts')
                ->where('layout_id', $mailLayout->layout_id)
                ->update(['layout' => $updatedLayout]);
        }
    }
};
