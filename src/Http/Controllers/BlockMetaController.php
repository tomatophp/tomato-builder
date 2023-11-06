<?php

namespace TomatoPHP\TomatoBuilder\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use TomatoPHP\TomatoAdmin\Facade\Tomato;

class BlockMetaController extends Controller
{
    public string $model;

    public function __construct()
    {
        $this->model = \TomatoPHP\TomatoBuilder\Models\BlockMeta::class;
    }

    /**
     * @param Request $request
     * @return View|JsonResponse
     */
    public function index(Request $request): View|JsonResponse
    {
        return Tomato::index(
            request: $request,
            model: $this->model,
            view: 'tomato-builder::block-metas.index',
            table: \TomatoPHP\TomatoBuilder\Tables\BlockMetaTable::class
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function api(Request $request): JsonResponse
    {
        return Tomato::json(
            request: $request,
            model: \TomatoPHP\TomatoBuilder\Models\BlockMeta::class,
        );
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return Tomato::create(
            view: 'tomato-builder::block-metas.create',
        );
    }

    /**
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $response = Tomato::store(
            request: $request,
            model: \TomatoPHP\TomatoBuilder\Models\BlockMeta::class,
            validation: [
                'block_id' => 'required|exists:blocks,id',
                'type' => 'nullable|max:255|string',
                'model_id' => 'nullable',
                'model_type' => 'nullable|max:255|string',
                'text' => 'required',
                'html' => 'nullable',
                'css' => 'nullable',
                'ordering' => 'nullable'
            ],
            message: __('BlockMeta updated successfully'),
            redirect: 'admin.block-metas.index',
        );

        if($response instanceof JsonResponse){
            return $response;
        }

        return back();
    }

    /**
     * @param \TomatoPHP\TomatoBuilder\Models\BlockMeta $model
     * @return View|JsonResponse
     */
    public function show(\TomatoPHP\TomatoBuilder\Models\BlockMeta $model): View|JsonResponse
    {
        return Tomato::get(
            model: $model,
            view: 'tomato-builder::block-metas.show',
        );
    }

    /**
     * @param \TomatoPHP\TomatoBuilder\Models\BlockMeta $model
     * @return View
     */
    public function edit(\TomatoPHP\TomatoBuilder\Models\BlockMeta $model): View
    {
        return Tomato::get(
            model: $model,
            view: 'tomato-builder::block-metas.edit',
        );
    }

    /**
     * @param Request $request
     * @param \TomatoPHP\TomatoBuilder\Models\BlockMeta $model
     * @return RedirectResponse|JsonResponse
     */
    public function update(Request $request, \TomatoPHP\TomatoBuilder\Models\BlockMeta $model): RedirectResponse|JsonResponse
    {
        $response = Tomato::update(
            request: $request,
            model: $model,
            validation: [
                'block_id' => 'sometimes|exists:blocks,id',
                'type' => 'nullable|max:255|string',
                'model_id' => 'nullable',
                'model_type' => 'nullable|max:255|string',
                'text' => 'sometimes',
                'html' => 'nullable',
                'css' => 'nullable',
                'ordering' => 'nullable'
            ],
            message: __('BlockMeta updated successfully'),
            redirect: 'admin.block-metas.index',
        );

         if($response instanceof JsonResponse){
             return $response;
         }

        return back();
    }

    /**
     * @param \TomatoPHP\TomatoBuilder\Models\BlockMeta $model
     * @return RedirectResponse|JsonResponse
     */
    public function destroy(\TomatoPHP\TomatoBuilder\Models\BlockMeta $model): RedirectResponse|JsonResponse
    {
        $response = Tomato::destroy(
            model: $model,
            message: __('BlockMeta deleted successfully'),
            redirect: 'admin.block-metas.index',
        );

        if($response instanceof JsonResponse){
            return $response;
        }

        return back();
    }
}
