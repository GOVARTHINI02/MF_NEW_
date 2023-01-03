<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnualReportFinancial extends Model
{
    use HasFactory;
    protected $fillable = [
        'MStarID',
        'ISIN',
        'AnnualReportTurnoverRatio',
        'AnnualReportTurnoverRatioDate',
        'InterimTurnoverRatio',
        'InterimTurnoverRatioDate',
    ];
}
