<?php

namespace TomatoPHP\TomatoBuilderr\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

/**
 * @property integer $id
 * @property integer $block_id
 * @property string $type
 * @property integer $model_id
 * @property string $model_type
 * @property mixed $text
 * @property string $html
 * @property string $css
 * @property integer $ordering
 * @property string $created_at
 * @property string $updated_at
 * @property Block $block
 */
class BlockMeta extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasTranslations;

    public $translatable = ['text'];
    /**
     * @var array
     */
    protected $fillable = ['block_id', 'type', 'model_id', 'model_type', 'text', 'html', 'css', 'ordering', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function block()
    {
        return $this->belongsTo('TomatoPHP\TomatoBuilderr\Models\Block');
    }
}
