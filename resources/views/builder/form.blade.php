<x-tomato-admin-layout>
    <x-slot:header>
        {{__('Builder Form For Table') }} : [{{ $model->key }}]
    </x-slot:header>

    <x-slot:buttons>
        <x-tomato-admin-button href="{{route('admin.builder.preview', $model->key)}}">
            {{__('Preview')}}
        </x-tomato-admin-button>
        <x-tomato-admin-button type="link" href="{{route('admin.builder.index')}}">
            <x-heroicon-s-arrow-left class="w-4 h-4" />
            {{__('Back')}}
        </x-tomato-admin-button>
    </x-slot:buttons>

    <x-splade-form method="POST" action="{{route('admin.forms.options', $model->id)}}">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-2 mb-4">
            <x-splade-link method="POST" href="{{route('admin.forms.options', $model->id)}}" data="{type: 'text'}" class="cursor-pointer flex flex-col jusitify-center items-center gap-2 w-full border rounded-lg p-4">
                <x-tomato-icon icon="text" class="w-8 h-8" />
                <h3 class="text-sm text-center">{{__('Text')}}</h3>
            </x-splade-link>
            <x-splade-link method="POST" href="{{route('admin.forms.options', $model->id)}}" data="{type: 'number'}" class="cursor-pointer flex flex-col jusitify-center items-center gap-2 w-full border rounded-lg  p-4">
                <x-tomato-icon icon="number" class="w-8 h-8" />
                <h3 class="text-sm text-center">{{__('Number')}}</h3>
            </x-splade-link>
            <x-splade-link method="POST" href="{{route('admin.forms.options', $model->id)}}" data="{type: 'date'}" class="cursor-pointer flex flex-col jusitify-center items-center gap-2 w-full border rounded-lg  p-4">
                <x-tomato-icon icon="date" class="w-8 h-8" />
                <h3 class="text-sm text-center">{{__('Date')}}</h3>
            </x-splade-link>
            <x-splade-link method="POST" href="{{route('admin.forms.options', $model->id)}}" data="{type: 'time'}" class="cursor-pointer flex flex-col jusitify-center items-center gap-2 w-full border rounded-lg  p-4">
                <x-tomato-icon icon="time" class="w-8 h-8" />
                <h3 class="text-sm text-center">{{__('Time')}}</h3>
            </x-splade-link>
            <x-splade-link method="POST" href="{{route('admin.forms.options', $model->id)}}" data="{type: 'checkbox'}" class="cursor-pointer flex flex-col jusitify-center items-center gap-2 w-full border rounded-lg  p-4">
                <x-tomato-icon icon="checkbox" class="w-8 h-8" />
                <h3 class="text-sm text-center">{{__('Checkbox')}}</h3>
            </x-splade-link>
            <x-splade-link method="POST" href="{{route('admin.forms.options', $model->id)}}" data="{type: 'radio'}" class="cursor-pointer flex flex-col jusitify-center items-center gap-2 w-full border rounded-lg  p-4">
                <x-tomato-icon icon="radio" class="w-8 h-8" />
                <h3 class="text-sm text-center">{{__('Radio')}}</h3>
            </x-splade-link>
            <x-splade-link method="POST" href="{{route('admin.forms.options', $model->id)}}" data="{type: 'range'}" class="cursor-pointer flex flex-col jusitify-center items-center gap-2 w-full border rounded-lg  p-4">
                <x-tomato-icon icon="range" class="w-8 h-8" />
                <h3 class="text-sm text-center">{{__('Range')}}</h3>
            </x-splade-link>
            <x-splade-link method="POST" href="{{route('admin.forms.options', $model->id)}}" data="{type: 'datetime'}" class="cursor-pointer flex flex-col jusitify-center items-center gap-2 w-full border rounded-lg  p-4">
                <x-tomato-icon icon="datetime" class="w-8 h-8" />
                <h3 class="text-sm text-center">{{__('Date Time')}}</h3>
            </x-splade-link>
            <x-splade-link method="POST" href="{{route('admin.forms.options', $model->id)}}" data="{type: 'rich'}" class="cursor-pointer flex flex-col jusitify-center items-center gap-2 w-full border rounded-lg p-4">
                <x-tomato-icon icon="rich" class="w-8 h-8" />
                <h3 class="text-sm text-center">{{__('Rich Text')}}</h3>
            </x-splade-link>
            <x-splade-link method="POST" href="{{route('admin.forms.options', $model->id)}}" data="{type: 'select'}" class="cursor-pointer flex flex-col jusitify-center items-center gap-2 w-full border rounded-lg p-4">
                <x-tomato-icon icon="select" class="w-8 h-8" />
                <h3 class="text-sm text-center">{{__('Select')}}</h3>
            </x-splade-link>
            <x-splade-link method="POST" href="{{route('admin.forms.options', $model->id)}}" data="{type: 'color'}" class="cursor-pointer flex flex-col jusitify-center items-center gap-2 w-full border rounded-lg p-4">
                <x-tomato-icon icon="color" class="w-8 h-8" />
                <h3 class="text-sm text-center">{{__('Color')}}</h3>
            </x-splade-link>
            <x-splade-link method="POST" href="{{route('admin.forms.options', $model->id)}}" data="{type: 'textarea'}" class="cursor-pointer flex flex-col jusitify-center items-center gap-2 w-full border rounded-lg p-4">
                <x-tomato-icon icon="textarea" class="w-8 h-8" />
                <h3 class="text-sm text-center">{{__('Textarea')}}</h3>
            </x-splade-link>
            <x-splade-link method="POST" href="{{route('admin.forms.options', $model->id)}}" data="{type: 'file'}" class="cursor-pointer flex flex-col jusitify-center items-center gap-2 w-full border rounded-lg p-4">
                <x-tomato-icon icon="file" class="w-8 h-8" />
                <h3 class="text-sm text-center">{{__('File')}}</h3>
            </x-splade-link>
        </div>
        @if(count($options))
            <x-tomato-admin-draggable
                class="cursor-move"
                :levels="1" :options="$options->map(function($item){
                    if(!$item->validation){
                        $item->validation = [
                            'type' => 'string',
                            'max' => 255,
                            'min' => 1
                        ];
                    }
                    return $item;
                })->toArray()" order-by="order" url="{{route('admin.forms.order', $model->id)}}">
                <x-splade-data
                    default="{showLabel:false, showOptions:false, showInput: true}"
                    v-bind:remember="'input-'+drag.item.id"
                    local-storage
                >
                    <div class="rounded-lg border bg-white">
                        <x-splade-form default="drag.item" preserve-scroll method="POST" v-bind:action="'{{url('admin/form-options')}}/'+drag.item.id">
                            <div class="p-4 flex justifiy-between gap-2">
                                <div class="flex justifiy-start gap-2 w-full mt-2">
                                    <div>
                                        <x-tomato-icon icon="`${drag.item.type}`" class="w-5 h-5" />
                                    </div>
                                    <h1 class="font-bold">@{{ drag.item.type.toUpperCase() }}</h1>
                                </div>

                                <div class="flex justifiy-start gap-4">
                                    <x-tomato-admin-button confirm method="DELETE" danger v-bind:href="'{{url('admin/form-options')}}/'+drag.item.id">
                                        <x-heroicon-s-trash class="w-4 h-4" />
                                        {{__('Delete')}}
                                    </x-tomato-admin-button>
                                    <x-tomato-admin-button type="button" @click.prevent="data.showInput = !data.showInput">
                                        <span v-if="!data.showInput">{{__('Preview')}}</span>
                                        <span v-else>{{__('Options')}}</span>
                                    </x-tomato-admin-button>
                                </div>
                            </div>
                            <hr>
                            <div class="flex flex-col space-y-4 justify-start p-4 w-full">

                                <div v-if="data.showInput">
                                    <label v-if="form.type === 'text' || form.type === 'number'">
                                        <span class="block text-sm font-medium leading-6 text-gray-950 dark:text-white"
                                              v-text="form.label?.{{  app()->getLocale() }}"
                                        >
                                        </span>
                                        <div  class="flex rounded-lg border border-gray-300 dark:border-gray-700 shadow-sm dark:text-white">
                                            <input
                                                :type="form.validation?.type ? form.validation?.type : 'text'"
                                                class="fi-input block w-full border-none bg-transparent py-1.5 text-base text-gray-950 outline-none transition duration-75 placeholder:text-gray-400 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 ps-3 pe-3 focus:ring-2 ring-primary-500 focus:ring-2 focus:ring-primary-500 rounded-lg"
                                                v-model="form.payload[form.name]"
                                                :placeholder="form.placeholder?.{{app()->getLocale()}}"
                                            />
                                        </div>
                                    </label>
                                    <label class="flex items-center" v-else-if="form.type === 'checkbox'">
                                        <input
                                            v-model="form.payload[form.name]"
                                            type="checkbox"
                                            class="dark:bg-gray-700 dark:border-gray-600 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:opacity-50"
                                            value="value"
                                            :checked="form.default == 1"
                                        >
                                        <span class="ml-2 rtl:mr-2 rtl:ml-0 dark:text-gray-200" v-text="form.label?.{{  app()->getLocale() }}"></span>
                                    </label>
                                    <label class="flex items-center" v-else-if="form.type === 'radio'">
                                        <input
                                            v-model="form.payload[form.name]"
                                            type="radio"
                                            class="dark:bg-gray-700 dark:border-gray-600 rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:opacity-50"
                                            value="value"
                                            :checked="form.default == 1"
                                        >
                                        <span class="ml-2 rtl:mr-2 rtl:ml-0 dark:text-gray-200" v-text="form.label?.{{  app()->getLocale() }}"></span>
                                    </label>
                                    <label class="flex flex-col items-start " v-else-if="form.type === 'range'">
                                        <span class="block text-sm font-medium leading-6 text-gray-950 dark:text-white"
                                              v-text="form.label?.{{  app()->getLocale() }}"
                                        >
                                        </span>
                                        <input
                                            v-model="form.payload[form.name]"
                                            type="range"
                                            class="w-full dark:bg-gray-700 dark:border-gray-600 rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:opacity-50"
                                        >
                                    </label>
                                    <label class="flex flex-col items-start" v-else-if="form.type === 'date'">
                                        <span class="block text-sm font-medium leading-6 text-gray-950 dark:text-white"
                                              v-text="form.label?.{{  app()->getLocale() }}"
                                        >
                                        </span>
                                        <x-splade-input
                                            class="w-full"
                                            v-bind:placeholder="form.placeholder?.{{  app()->getLocale() }}"
                                            v-model="form.payload[form.name]"
                                            date
                                        />
                                    </label>
                                    <label class="flex flex-col items-start" v-else-if="form.type === 'datetime'">
                                        <span class="block text-sm font-medium leading-6 text-gray-950 dark:text-white"
                                              v-text="form.label?.{{  app()->getLocale() }}"
                                        >
                                        </span>
                                        <x-splade-input
                                            class="w-full"
                                            v-bind:placeholder="form.placeholder?.{{  app()->getLocale() }}"
                                            v-model="form.payload[form.name]"
                                            date
                                            time
                                        />
                                    </label>
                                    <label class="flex flex-col items-start" v-else-if="form.type === 'time'">
                                        <span class="block text-sm font-medium leading-6 text-gray-950 dark:text-white"
                                              v-text="form.label?.{{  app()->getLocale() }}"
                                        >
                                        </span>
                                        <x-splade-input
                                            class="w-full"
                                            v-bind:placeholder="form.placeholder?.{{  app()->getLocale() }}"
                                            v-model="form.payload[form.name]"
                                            time
                                        />
                                    </label>
                                    <label class="flex flex-col items-start" v-else-if="form.type === 'textarea'">
                                        <span class="block text-sm font-medium leading-6 text-gray-950 dark:text-white"
                                              v-text="form.label?.{{  app()->getLocale() }}"
                                        >
                                        </span>
                                        <x-splade-textarea
                                            class="w-full"
                                            v-bind:placeholder="form.placeholder?.{{  app()->getLocale() }}"
                                            v-model="form.payload[form.name]"
                                        />
                                    </label>
                                    <label class="flex flex-col items-start" v-else-if="form.type === 'file'">
                                        <span class="block text-sm font-medium leading-6 text-gray-950 dark:text-white"
                                              v-text="form.label?.{{  app()->getLocale() }}"
                                        >
                                        </span>
                                        <x-splade-file
                                            filepond
                                            preview
                                            class="w-full"
                                            v-bind:placeholder="form.placeholder?.{{  app()->getLocale() }}"
                                            v-model="form.payload[form.name]"
                                        />
                                    </label>
                                    <label class="flex flex-col items-start" v-else-if="form.type === 'color'">
                                        <span class="block text-sm font-medium leading-6 text-gray-950 dark:text-white"
                                              v-text="form.label?.{{  app()->getLocale() }}"
                                        >
                                        </span>
                                        <x-tomato-admin-color
                                            class="w-full"
                                            v-bind:placeholder="form.placeholder?.{{  app()->getLocale() }}"
                                            v-model="form.payload[form.name]"
                                        />
                                    </label>
                                    <label class="flex flex-col items-start" v-else-if="form.type === 'rich'">
                                        <span class="block text-sm font-medium leading-6 text-gray-950 dark:text-white"
                                              v-text="form.label?.{{  app()->getLocale() }}"
                                        >
                                        </span>
                                        <x-tomato-admin-rich
                                            class="w-full"
                                            v-bind:placeholder="form.placeholder?.{{  app()->getLocale() }}"
                                            v-model="form.payload[form.name]"
                                        />
                                    </label>
                                    <label class="flex flex-col items-start" v-else-if="form.type === 'select'">
                                        <span class="block text-sm font-medium leading-6 text-gray-950 dark:text-white"
                                              v-text="form.label?.{{  app()->getLocale() }}"
                                        >
                                        </span>
                                        <x-splade-select
                                            v-if="form.has_options"
                                            choices
                                            class="w-full"
                                            v-bind:placeholder="form.placeholder?.{{  app()->getLocale() }}"
                                            v-model="form.payload[form.name]"
                                        >
                                            <option v-for="(option, optionIndex) in form.options" v-bind:value="option.key" v-text="option.value_{{app()->getLocale()}}"></option>
                                        </x-splade-select>
                                        <x-splade-select
                                            v-if="form.is_from_table"
                                            remote-url="`${form.table_name}`"
                                            remote-root="data"
                                            option-label="name"
                                            option-value="id"
                                            choices
                                            class="w-full"
                                            v-bind:placeholder="form.placeholder?.{{  app()->getLocale() }}"
                                            v-model="form.payload[form.name]"
                                        />
                                    </label>
                                </div>
                                <div v-else class="flex flex-col gap-4">
                                    <div class="flex justify-between gap-2">
                                        <x-splade-select choices class="w-full" name="type" :label="__('Type')" :placeholder="__('Type')">
                                            <option value="text">{{__('Text')}}</option>
                                            <option value="textarea">{{__('Text Area')}}</option>
                                            <option value="rich">{{__('Rich Text Editor')}}</option>
                                            <option value="number">{{__('Number')}}</option>
                                            <option value="date">{{__('Date')}}</option>
                                            <option value="time">{{__('Time')}}</option>
                                            <option value="datetime">{{__('Datetime')}}</option>
                                            <option value="checkbox">{{__('Checkbox')}}</option>
                                            <option value="radio">{{__('Radio')}}</option>
                                            <option value="range">{{__('Range')}}</option>
                                            <option value="select">{{__('Select')}}</option>
                                            <option value="color">{{__('Color')}}</option>
                                            <option value="file">{{__('File')}}</option>
                                        </x-splade-select>
                                        <x-splade-input class="w-full" name="name" :label="__('Key')" :placeholder="__('Key')" />
                                        <x-splade-input class="w-full" name="default" :label="__('Default')" :placeholder="__('Default')" />
                                        <button title="{{__('Label')}}" @click.prevent="data.showLabel = !data.showLabel">
                                            <x-heroicon-s-chevron-double-up v-show="data.showLabel" class="w-5 h-5 mt-5 mx-2" />
                                            <x-heroicon-s-chevron-double-down v-show="!data.showLabel" class="w-5 h-5 mt-5 mx-2" />
                                        </button>
                                        <button title="{{__('Options')}}" @click.prevent="data.showOptions = !data.showOptions">
                                            <x-heroicon-s-cog class="w-5 h-5 mt-5 mx-2" />
                                        </button>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4" v-show="data.showLabel">
                                        <div class="col-span-2">
                                            <x-tomato-translation  name="label" :label="__('Label')" :placeholder="__('Label')"/>
                                        </div>
                                        <x-tomato-translation name="placeholder" :label="__('Placeholder')" :placeholder="__('Placeholder')"/>
                                        <x-tomato-translation name="hint" :label="__('Hint')" :placeholder="__('Hint')"/>
                                    </div>

                                    <div v-show="data.showOptions">
                                        <x-splade-checkbox class="w-full" name="is_required" :label="__('Is Required?')" :placeholder="__('Is Required?')" />
                                        <div v-if="form.is_required" class="my-4">
                                            <x-tomato-translation name="required_message" :label="__('Required Message')" :placeholder="__('Required Message')"/>
                                        </div>
                                        <x-splade-checkbox class="w-full" name="has_validation" :label="__('Has Validation')" :placeholder="__('Has Validation')" />
                                        <div v-if="form.has_validation">
                                            <div class="border p-4 rounded-lg grid grid-cols-2 lg:grid-cols-4 gap-4 my-4">
                                                <x-splade-radio class="w-full" name="validation[type]" value="email"  :label="__('Is Email?')" :placeholder="__('Is Email?')" />
                                                <x-splade-radio class="w-full" name="validation[type]" value="array"  :label="__('Is Array?')" :placeholder="__('Is Array?')" />
                                                <x-splade-radio class="w-full" name="validation[type]" value="int"  :label="__('Is Number?')" :placeholder="__('Is Number?')" />
                                                <x-splade-radio class="w-full" name="validation[type]" value="file"  :label="__('Is File?')" :placeholder="__('Is File?')" />
                                                <x-splade-radio class="w-full" name="validation[type]" value="string"  :label="__('Is Text?')" :placeholder="__('Is Text?')" />
                                                <x-splade-radio class="w-full" name="validation[type]" value="dight"  :label="__('Is Dights?')" :placeholder="__('Is Dights?')" />
                                                <x-splade-radio class="w-full" name="validation[type]" value="password"  :label="__('Is Password?')" :placeholder="__('Is Password?')" />
                                                <x-splade-checkbox class="w-full col-span-4" value="1" name="validation[unique]"  :label="__('Is Unique?')" :placeholder="__('Is Unique?')" />
                                                <x-splade-input class="w-full col-span-2" name="validation[min]" type="number" :label="__('Min Length')" :placeholder="__('Min Length')" />
                                                <x-splade-input class="w-full col-span-2" name="validation[max]" type="number" :label="__('Max Length')" :placeholder="__('Max Length')" />
                                                <x-splade-input class="w-full col-span-4" v-if="form.validation.type === 'file'" name="validation[max_file_size]" type="number" :label="__('Max File Size')" :placeholder="__('Max File Size')" />
                                            </div>
                                        </div>
                                        <x-splade-checkbox class="w-full" name="is_reactive" :label="__('Is Reactive')" :placeholder="__('Is Reactive')" />
                                        <div v-if="form.is_reactive">
                                            <div class="flex justifiy-between gap-2 my-4">
                                                <x-splade-input class="w-full" name="reactive_field"  :label="__('Reactive When Field')" :placeholder="__('Reactive When Field')" />
                                                <x-splade-input class="w-full" name="reactive_where"   :label="__('Is Equle To')" :placeholder="__('Is Equle To')" />
                                            </div>
                                        </div>
                                        <div v-if="drag.item.type === 'select'">
                                            <x-splade-checkbox class="w-full" name="has_options" :label="__('Has Options')" :placeholder="__('Has Options')" />
                                            <div v-if="form.has_options" class="my-4">
                                                <x-tomato-admin-repeater name="options" :options="['key', 'value_ar', 'value_en']">
                                                    <div class="flex justifiy-between gap-2">
                                                        <x-splade-input class="w-full" v-model="repeater.main[key].key"  :label="__('Option Value')" :placeholder="__('Option Value')" />
                                                        <x-splade-input class="w-full" v-model="repeater.main[key].value_ar"   :label="__('Option Label [AR]')" :placeholder="__('Option Label [AR]')" />
                                                        <x-splade-input class="w-full" v-model="repeater.main[key].value_en"   :label="__('Option Label [EN]')" :placeholder="__('Option Label [EN]')" />
                                                    </div>
                                                </x-tomato-admin-repeater>
                                            </div>
                                        </div>
                                        <div v-if="drag.item.type === 'select'">
                                            <x-splade-checkbox class="w-full" name="is_from_table" :label="__('Get Data From Endpoint')" :placeholder="__('Get Data From Table')" />
                                            <div v-if="form.is_from_table" class="my-4">
                                                <x-splade-input class="w-full" name="table_name"  :label="__('Endpoint')" :placeholder="__('Table Name')" />
                                            </div>
                                        </div>
                                        <x-splade-checkbox v-if="drag.item.type === 'select' || drag.item.type === 'file'" class="w-full" name="is_multi" :label="__('Is Multi')" :placeholder="__('Is Multi')" />

                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="flex justify-start gap-2 text-center p-2">
                                <x-tomato-admin-submit :label="__('Update')" :spinner="true" />
                            </div>
                        </x-splade-form>
                    </div>
                </x-splade-data>
            </x-tomato-admin-draggable>
        @else
            <div class="cursor-move flex flex-col gap-4 items-center text-center justifiy-center w-full border rounded-lg p-4">
                <x-heroicon-s-arrows-pointing-in class="w-12 h-12" />
                {{__('Click On Any Input Type To Add It Here')}}
            </div>
        @endif
    </x-splade-form>
</x-tomato-admin-layout>
