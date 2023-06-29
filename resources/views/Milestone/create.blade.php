<div class="milestone-form-container">
    <div class="flex">
        <b>Add New Milestone</b>
        <div class="flex items-end justify-end grow">
            <x-button class="flex items-end justify-end mt-2 milestone-delete">
                {{ __('Delete') }}
            </x-button>
        </div>
    </div>
    <form action="{{route('milestoneStore', $experience_id)}}" method="post" enctype="multipart/form-data" class="milestone-create milestone-form">
        @csrf
        <div class="mt-4">
            <x-label class="custom-file-label" for="title">Title</x-label>
            <x-input type="text" name="title" class="block mt-1 w-full" id="title"/>
        </div>
        <div class="mt-4">
            <x-label class="custom-file-label" for="description">Description</x-label>
            <x-textarea type="textarea" name="description" class="block mt-1 w-full" id="description"></x-textarea>
        </div>
        <div class="mt-4">
            <div class="mt-2">
                <img height="50" src="" class="h-20 photo-preview hidden">
            </div>
            <x-label class="custom-file-label" for="image">Image</x-label>
            <x-input type="file" name="image" class="hidden" id="image" class="milestone-image hidden"/>
            <x-secondary-button class="mt-2 mr-2" type="button" class="select-photo">
                {{ __('Select A New Photo') }}
            </x-secondary-button>
            <x-secondary-button type="button" class="mt-2 remove-photo">
                {{ __('Remove Photo') }}
            </x-secondary-button>
        </div>
        <input type="submit" class="hidden">
    </form>
</div>
