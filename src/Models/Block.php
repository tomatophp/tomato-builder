<?php

namespace TomatoPHP\TomatoBuilder\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $type
 * @property string $group
 * @property string $key
 * @property string $place
 * @property integer $ordering
 * @property boolean $activated
 * @property string $created_at
 * @property string $updated_at
 * @property BlockMeta[] $blockMetas
 */
class Block extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['type', 'group', 'key', 'place', 'ordering', 'activated', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blockMetas()
    {
        return $this->hasMany('TomatoPHP\TomatoBuilder\Models\BlockMeta');
    }
}
