<?php


Route::middleware(['web','auth', 'splade', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/builder', [\TomatoPHP\TomatoBuilder\Http\Controllers\BuilderController::class, 'index'])->name('builder.index');
    Route::get('/builder/form/{model}', [\TomatoPHP\TomatoBuilder\Http\Controllers\BuilderController::class, 'form'])->name('builder.form');
    Route::get('/builder/form/{model}/preview', [\TomatoPHP\TomatoBuilder\Http\Controllers\BuilderController::class, 'preview'])->name('builder.preview');
    Route::get('/builder/generate', [\TomatoPHP\TomatoBuilder\Http\Controllers\BuilderController::class, 'confirm'])->name('builder.confirm');
    Route::post('/builder/generate', [\TomatoPHP\TomatoBuilder\Http\Controllers\BuilderController::class, 'generate'])->name('builder.generate');
    Route::post('/builder', [\TomatoPHP\TomatoBuilder\Http\Controllers\BuilderController::class, 'store'])->name('builder.store');
    Route::get('/builder/clear', [\TomatoPHP\TomatoBuilder\Http\Controllers\BuilderController::class, 'clear'])->name('builder.clear');
});
//
//Route::middleware(['web','auth', 'splade', 'verified'])->name('admin.')->group(function () {
//    Route::get('admin/blocks', [\TomatoPHP\TomatoBuilder\Http\Controllers\BlockController::class, 'index'])->name('blocks.index');
//    Route::get('admin/blocks/api', [\TomatoPHP\TomatoBuilder\Http\Controllers\BlockController::class, 'api'])->name('blocks.api');
//    Route::get('admin/blocks/create', [\TomatoPHP\TomatoBuilder\Http\Controllers\BlockController::class, 'create'])->name('blocks.create');
//    Route::post('admin/blocks', [\TomatoPHP\TomatoBuilder\Http\Controllers\BlockController::class, 'store'])->name('blocks.store');
//    Route::get('admin/blocks/{model}', [\TomatoPHP\TomatoBuilder\Http\Controllers\BlockController::class, 'show'])->name('blocks.show');
//    Route::get('admin/blocks/{model}/edit', [\TomatoPHP\TomatoBuilder\Http\Controllers\BlockController::class, 'edit'])->name('blocks.edit');
//    Route::post('admin/blocks/{model}', [\TomatoPHP\TomatoBuilder\Http\Controllers\BlockController::class, 'update'])->name('blocks.update');
//    Route::delete('admin/blocks/{model}', [\TomatoPHP\TomatoBuilder\Http\Controllers\BlockController::class, 'destroy'])->name('blocks.destroy');
//});
//
//Route::middleware(['web','auth', 'splade', 'verified'])->name('admin.')->group(function () {
//    Route::get('admin/block-metas', [\TomatoPHP\TomatoBuilder\Http\Controllers\BlockMetaController::class, 'index'])->name('block-metas.index');
//    Route::get('admin/block-metas/api', [\TomatoPHP\TomatoBuilder\Http\Controllers\BlockMetaController::class, 'api'])->name('block-metas.api');
//    Route::get('admin/block-metas/create', [\TomatoPHP\TomatoBuilder\Http\Controllers\BlockMetaController::class, 'create'])->name('block-metas.create');
//    Route::post('admin/block-metas', [\TomatoPHP\TomatoBuilder\Http\Controllers\BlockMetaController::class, 'store'])->name('block-metas.store');
//    Route::get('admin/block-metas/{model}', [\TomatoPHP\TomatoBuilder\Http\Controllers\BlockMetaController::class, 'show'])->name('block-metas.show');
//    Route::get('admin/block-metas/{model}/edit', [\TomatoPHP\TomatoBuilder\Http\Controllers\BlockMetaController::class, 'edit'])->name('block-metas.edit');
//    Route::post('admin/block-metas/{model}', [\TomatoPHP\TomatoBuilder\Http\Controllers\BlockMetaController::class, 'update'])->name('block-metas.update');
//    Route::delete('admin/block-metas/{model}', [\TomatoPHP\TomatoBuilder\Http\Controllers\BlockMetaController::class, 'destroy'])->name('block-metas.destroy');
//});
