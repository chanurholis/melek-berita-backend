<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\DataSourceConstants;
use Illuminate\Support\Facades\Log;

class DataSourceLookup extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'data_source_lookups';
    protected $primaryKey = 'id';

    /**
     * Get data source.
     * 
     * @return Object
     */
    public static function getKursBCAToday() 
    {
        $dataSourceLookup = self::where('key', DataSourceConstants::BCA_KURS_HARI_INI)->first();

        if ($dataSourceLookup) {
            $lookupId = Arr::get($dataSourceLookup, 'lookup_id');
            $endpoint = Arr::get($dataSourceLookup, 'value');

            if (!$lookupId || !$endpoint) throw new \Exception('Lookup ID or endpoint not found!');

            try {
                $sourceUrl = Lookup::findOrFail($lookupId);
                $sourceUrl = Arr::get($sourceUrl, 'value');
                if (!$sourceUrl) throw new \Exception('Source URL not found!');
                return $sourceUrl.$endpoint;
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                return $th->getMessage();
            }
        }
    }
}
