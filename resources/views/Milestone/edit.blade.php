<div>
    <b>Edit Milestone: {{$existing_values['title']}}<span>Delete</span></b>
    <form action="{{route('milestoneUpdateInstance', $milestone_id)}}" method="post" enctype="multipart/form-data" class="milestone-edit milestone-form">
        @csrf
        <div class="mt-4">
            <x-label class="custom-file-label" for="title">Title</x-label>
            <x-input type="text" name="title" class="block mt-1 w-full" id="title" value="{{$existing_values['title']}}"/>
        </div>
        <div class="mt-4">
            <x-label class="custom-file-label" for="description">Description</x-label>
            <x-textarea type="textarea" name="description" class="block mt-1 w-full" id="description">@section('initial_value'){{$existing_values['description']}}@endsection</x-textarea>
        </div>
        <div class="mt-4">
            <div class="mt-2">
                @if(!empty($existing_values['image']))
                    <img height="50" src="{{$existing_values['image']}}" class="h-20 photo-preview" id="photo_preview">
                @else
                    <img height="50" src="" class="h-20 photo-preview hidden" id="photo_preview">
                @endif
            </div>
            <x-label class="custom-file-label" for="image">Image</x-label>
            <x-input type="file" name="image" class="hidden" id="image" class="milestone-image hidden"/>
            <x-secondary-button class="mt-2 mr-2" type="button" id="select_photo" class="select-photo">
                {{ __('Select A New Photo') }}
            </x-secondary-button>
            <x-secondary-button type="button" class="mt-2 remove-photo" id="remove_photo">
                {{ __('Remove Photo') }}
            </x-secondary-button>
        </div>
        <input type="hidden" name="id" class="milestone-id" value="{{$milestone_id}}">
        <input type="submit" class="hidden">
    </form>
</div>
