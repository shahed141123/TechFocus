
<option value="{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>
    {{ str_repeat('-', $level) }} {{ $category->name }}
</option>

@if ($category->children && $category->children->isNotEmpty())
    @foreach ($category->children as $child)
        @include('admin.pages.product.partials.edit_category', ['category' => $child, 'level' => $level + 1, 'selectedCategories' => $selectedCategories])
    @endforeach
@endif
