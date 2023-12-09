<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandPage extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function rowFour()
    {
        return $this->belongsTo(Row::class, 'row_four_id');
    }
    public function rowFive()
    {
        return $this->belongsTo(Row::class, 'row_five_id');
    }
    public function rowSeven()
    {
        return $this->belongsTo(Row::class, 'row_seven_id');
    }
    public function rowEight()
    {
        return $this->belongsTo(Row::class, 'row_eight_id');
    }
    public function solutionCardOne()
    {
        return $this->belongsTo(SolutionDetail::class, 'solution_card_one_id');
    }
    public function solutionCardTwo()
    {
        return $this->belongsTo(SolutionDetail::class, 'solution_card_two_id');
    }
    public function solutionCardThree()
    {
        return $this->belongsTo(SolutionDetail::class, 'solution_card_three_id');
    }
}
