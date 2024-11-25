<h2 class="mb-4 text-xl font-semibold text-text">
  {{ $title }}
</h2>

<div class="overflow-hidden categories">
  <div class="flex items-center">
    @foreach ($categories as $category)
      <a href={{ route('categories.show', $category->slug) }}
        class="flex items-center flex-none mr-4 border rounded-xl border-border bg-card">
        <img src="{{ $category->imageurl ?? asset('placeholder.jpg') }}" alt="{{ $category->category_name }}"
          class="object-cover h-14 rounded-l-xl aspect-square bg-border/50">
        <span class="px-4 text-sm font-medium text-text">{{ $category->category_name }}</span>
      </a>
    @endforeach
  </div>
</div>
