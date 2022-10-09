<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Constants;
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
        $dataSourceLookup = self::where('key', Constants::BCA_EXCHANGE_RATE_TODAY)->first();

        if ($dataSourceLookup) {
            $lookupId = Arr::get($dataSourceLookup, 'lookup_id');
            $endpoint = Arr::get($dataSourceLookup, 'value');

            if (!$lookupId || !$endpoint) throw new \Exception('Lookup ID or endpoint not found!');

            try {
                $sourceUrl = Lookup::findOrFail($lookupId);
                $sourceUrl = Arr::get($sourceUrl, 'value');
                if (!$sourceUrl) throw new \Exception('Source URL not found!');
                return $sourceUrl . $endpoint;
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                return $th->getMessage();
            }
        }
    }

    public static function getEndpoint($dataSourceKey)
    {
        if ($dataSourceKey == null) {
            return response('Data source key must be filled!', 400, ['Content-Type' => 'application/json']);
        }
        $dataSource = self::where('key', $dataSourceKey)->first();
        if ($dataSource == null) {
            return response('Data source not found!', 404, ['Content-Type' => 'application/json']); 
        }
        $lookupId = Arr::get($dataSource, 'lookup_id');
        $endpoint = Arr::get($dataSource, 'value');
        if ($lookupId == null) {
            return response('Lookup ID must be filled!', 400, ['Content-Type' => 'application/json']);
        }
        $lookup = Lookup::find($lookupId);
        if ($lookup == null) {
            return response('Lookup not found!', 404, ['Content-Type' => 'application/json']); 
        }
        $url = Arr::get($lookup, 'value');
        return $url.$endpoint;
    }
}
