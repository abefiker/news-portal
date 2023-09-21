@foreach($subcategories as $subcategory)
    <option value="{{ $subcategory->id }}">{{ $prefix }} {{ $subcategory->title }}</option>

    @if($subcategory->children->count())
        @include('partials.subcategories', ['subcategories' => $subcategory->children, 'prefix' => $prefix . '--'])
    @endif
@endforeach
