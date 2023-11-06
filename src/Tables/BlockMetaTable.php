<?php

namespace TomatoPHP\TomatoBuilderr\Tables;

use Illuminate\Http\Request;
use ProtoneMedia\Splade\AbstractTable;
use ProtoneMedia\Splade\Facades\Toast;
use ProtoneMedia\Splade\SpladeTable;
use Illuminate\Database\Eloquent\Builder;

class BlockMetaTable extends AbstractTable
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct(public Builder|null $query=null)
    {
        if(!$query){
            $this->query = \TomatoPHP\TomatoBuilderr\Models\BlockMeta::query();
        }
    }

    /**
     * Determine if the user is authorized to perform bulk actions and exports.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        return true;
    }

    /**
     * The resource or query builder.
     *
     * @return mixed
     */
    public function for()
    {
        return $this->query;
    }

    /**
     * Configure the given SpladeTable.
     *
     * @param \ProtoneMedia\Splade\SpladeTable $table
     * @return void
     */
    public function configure(SpladeTable $table)
    {
        $table
            ->withGlobalSearch(
                label: trans('tomato-admin::global.search'),
                columns: ['id',]
            )
            ->bulkAction(
                label: trans('tomato-admin::global.crud.delete'),
                each: fn (\TomatoPHP\TomatoBuilderr\Models\BlockMeta $model) => $model->delete(),
                after: fn () => Toast::danger(__('BlockMeta Has Been Deleted'))->autoDismiss(2),
                confirm: true
            )
            ->defaultSort('id', 'desc')
            ->column(
                key: 'id',
                label: __('Id'),
                sortable: true
            )
            ->column(
                key: 'block_id',
                label: __('Block id'),
                sortable: true
            )
            ->column(
                key: 'type',
                label: __('Type'),
                sortable: true
            )
            ->column(
                key: 'model_id',
                label: __('Model id'),
                sortable: true
            )
            ->column(
                key: 'model_type',
                label: __('Model type'),
                sortable: true
            )
            ->column(
                key: 'text',
                label: __('Text'),
                sortable: true
            )
            ->column(
                key: 'html',
                label: __('Html'),
                sortable: true
            )
            ->column(
                key: 'css',
                label: __('Css'),
                sortable: true
            )
            ->column(
                key: 'ordering',
                label: __('Ordering'),
                sortable: true
            )
            ->column(key: 'actions',label: trans('tomato-admin::global.crud.actions'))
            ->export()
            ->paginate(10);
    }
}
