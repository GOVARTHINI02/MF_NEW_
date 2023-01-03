<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnualReportFees extends Model
{
    use HasFactory;
    protected $fillable = [
        'MStarID',
        'ISIN',
        'AnnualReportDate',
        'NetExpenseRatio',
        'InterimNetExpenseRatio',
    ];
}
