<?php

namespace TomatoPHP\TomatoBuilder\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use TomatoPHP\TomatoAdmin\Facade\Tomato;

class BlockController extends Controller
{
    public string $model;

    public function __construct()
    {
        $this->model = \TomatoPHP\TomatoBuilder\Models\Block::class;
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
            view: 'tomato-builder::blocks.index',
            table: \TomatoPHP\TomatoBuilder\Tables\BlockTable::class
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
            model: \TomatoPHP\TomatoBuilder\Models\Block::class,
        );
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return Tomato::create(
            view: 'tomato-builder::blocks.create',
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
            model: \TomatoPHP\TomatoBuilder\Models\Block::class,
            validation: [
                'type' => 'nullable|max:255|string',
                'group' => 'nullable|max:255|string',
                'key' => 'required|max:255|string',
                'place' => 'nullable|max:255|string',
                'ordering' => 'nullable',
                'activated' => 'nullable'
            ],
            message: __('Block updated successfully'),
            redirect: 'admin.blocks.index',
        );

        if($response instanceof JsonResponse){
            return $response;
        }

        return $response->redirect;
    }

    /**
     * @param \TomatoPHP\TomatoBuilder\Models\Block $model
     * @return View|JsonResponse
     */
    public function show(\TomatoPHP\TomatoBuilder\Models\Block $model): View|JsonResponse
    {
        return Tomato::get(
            model: $model,
            view: 'tomato-builder::blocks.show',
        );
    }

    /**
     * @param \TomatoPHP\TomatoBuilder\Models\Block $model
     * @return View
     */
    public function edit(\TomatoPHP\TomatoBuilder\Models\Block $model): View
    {
        return Tomato::get(
            model: $model,
            view: 'tomato-builder::blocks.edit',
        );
    }

    /**
     * @param Request $request
     * @param \TomatoPHP\TomatoBuilder\Models\Block $model
     * @return RedirectResponse|JsonResponse
     */
    public function update(Request $request, \TomatoPHP\TomatoBuilder\Models\Block $model): RedirectResponse|JsonResponse
    {
        $response = Tomato::update(
            request: $request,
            model: $model,
            validation: [
                'type' => 'nullable|max:255|string',
                'group' => 'nullable|max:255|string',
                'key' => 'sometimes|max:255|string',
                'place' => 'nullable|max:255|string',
                'ordering' => 'nullable',
                'activated' => 'nullable'
            ],
            message: __('Block updated successfully'),
            redirect: 'admin.blocks.index',
        );

         if($response instanceof JsonResponse){
             return $response;
         }

         return $response->redirect;
    }

    /**
     * @param \TomatoPHP\TomatoBuilder\Models\Block $model
     * @return RedirectResponse|JsonResponse
     */
    public function destroy(\TomatoPHP\TomatoBuilder\Models\Block $model): RedirectResponse|JsonResponse
    {
        $response = Tomato::destroy(
            model: $model,
            message: __('Block deleted successfully'),
            redirect: 'admin.blocks.index',
        );

        if($response instanceof JsonResponse){
            return $response;
        }

        return $response->redirect;
    }
}
