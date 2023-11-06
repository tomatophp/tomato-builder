<x-tomato-admin-container label="{{__('Start generate your tables')}}">
    <x-splade-form confirm method="POST" action="{{route('admin.builder.generate')}}" class="flex flex-col gap-4" :default="[
        'module' => setting('builder_module') ?? '',
        'app_name' => setting('builder_app_name') ?? '',
        'form_type' => 'module'
    ]">
        <x-splade-input name="module" :placeholder="__('Module Name')" :label="__('Module Name')" required/>
        <x-splade-input name="app_name" :placeholder="__('App Name')" :label="__('App Name')" />

        <div class="grid grid-cols-3 gap-4">
            <button  @click.prevent="form.form_type = 'module'; form.submit()" class="hover:bg-green-500 hover:text-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col gap-4 items-center justify-center">
                <i class="bx bx-category bx-md"></i>
                <div class="text-sm text-center">{{__('Generate Module')}}</div>
            </button>
            <button @click.prevent="form.form_type = 'migrations'; form.submit()" class="hover:bg-green-500 hover:text-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col gap-4 items-center justify-center">
                <i class="bx bx-data bx-md"></i>
                <div class="text-sm text-center">{{__('Generate Migration')}}</div>
            </button>
            <button @click.prevent="form.form_type = 'crud'; form.submit()" class="hover:bg-green-500 hover:text-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col gap-4 items-center justify-center">
                <i class="bx bx-window bx-md"></i>
                <div class="text-sm text-center">{{__('Generate CRUD')}}</div>
            </button>
            <button @click.prevent="form.form_type = 'models'; form.submit()" class="hover:bg-green-500 hover:text-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col gap-4 items-center justify-center">
                <i class="bx bx-math bx-md"></i>
                <div class="text-sm text-center">{{__('Generate Models')}}</div>
            </button>
            <button @click.prevent="form.form_type = 'controllers'; form.submit()" class="hover:bg-green-500 hover:text-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col gap-4 items-center justify-center">
                <i class="bx bx-cheese bx-md"></i>
                <div class="text-sm text-center">{{__('Generate Controllers')}}</div>
            </button>
            <button @click.prevent="form.form_type = 'form-request'; form.submit()" class="hover:bg-green-500 hover:text-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col gap-4 items-center justify-center">
                <i class="bx bx-check-circle bx-md"></i>
                <div class="text-sm text-center">{{__('Generate Form Request')}}</div>
            </button>
            <button @click.prevent="form.form_type = 'json-resource'; form.submit()" class="hover:bg-green-500 hover:text-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col gap-4 items-center justify-center">
                <i class="bx bxs-file-json bx-md"></i>
                <div class="text-sm text-center">{{__('Generate JSON Resource')}}</div>
            </button>
            <button @click.prevent="form.form_type = 'views'; form.submit()" class="hover:bg-green-500 hover:text-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col gap-4 items-center justify-center">
                <i class="bx bx-show bx-md"></i>
                <div class="text-sm text-center">{{__('Generate Views')}}</div>
            </button>
            <button @click.prevent="form.form_type = 'tables'; form.submit()" class="hover:bg-green-500 hover:text-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col gap-4 items-center justify-center">
                <i class="bx bx-table bx-md"></i>
                <div class="text-sm text-center">{{__('Generate Tables')}}</div>
            </button>
            <button @click.prevent="form.form_type = 'routes'; form.submit()" class="hover:bg-green-500 hover:text-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col gap-4 items-center justify-center">
                <i class="bx bx-globe bx-md"></i>
                <div class="text-sm text-center">{{__('Generate Routes')}}</div>
            </button>
            <button @click.prevent="form.form_type = 'api-routes'; form.submit()" class="hover:bg-green-500 hover:text-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col gap-4 items-center justify-center">
                <i class="bx bxl-graphql bx-md"></i>
                <div class="text-sm text-center">{{__('Generate API Routes')}}</div>
            </button>
            <button @click.prevent="form.form_type = 'flutter-app'; form.submit()" class="hover:bg-green-500 hover:text-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col gap-4 items-center justify-center">
                <i class="bx bx-phone bx-md"></i>
                <div class="text-sm text-center">{{__('Generate Flutter App')}}</div>
            </button>
            <button @click.prevent="form.form_type = 'flutter-module'; form.submit()" class="hover:bg-green-500 hover:text-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col gap-4 items-center justify-center">
                <i class="bx bx-category bx-md"></i>
                <div class="text-sm text-center">{{__('Generate Flutter Module')}}</div>
            </button>
            <button @click.prevent="form.form_type = 'flutter-crud'; form.submit()" class="hover:bg-green-500 hover:text-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col gap-4 items-center justify-center">
                <i class="bx bxs-phone-call bx-md"></i>
                <div class="text-sm text-center">{{__('Generate Flutter CRUD')}}</div>
            </button>
        </div>
    </x-splade-form>
</x-tomato-admin-container>
