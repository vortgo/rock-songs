<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Radio
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Radio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Radio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Radio query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $on_air
 * @property int|null $song_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Song|null $song
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Radio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Radio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Radio whereOnAir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Radio whereSongId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Radio whereUpdatedAt($value)
 */
class Radio extends Model
{

    public $table = 'radio';
    protected $fillable = ['on_air', 'songs_id'];

    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
