<div>
    <b>Milestone</b>
    <form action="{{route('milestoneCreateInstance', $experience_id)}}" method="post" enctype="multipart/form-data" class="milestone-create">
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
            <x-label class="custom-file-label" for="image">Image</x-label>
            <x-input type="file" name="image" class="block mt-1 w-full" id="image"/>
        </div>
        <input name="experience" class="hidden" id="experience" value="{{$experience_id}}"/>
        <input type="submit" class="hidden">
    </form>
</div>
