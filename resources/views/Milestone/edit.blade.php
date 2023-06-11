<div>
    <b>Edit Milestone<span>Delete</span></b>
    <form action="{{route('milestoneUpdateInstance', $milestone_id)}}" method="post" enctype="multipart/form-data" class="milestone-create">
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
            <x-label class="custom-file-label" for="image">Image</x-label>
            <x-input type="file" name="image" class="block mt-1 w-full" id="image"/>
        </div>
        <input type="submit" class="hidden">
    </form>
</div>
