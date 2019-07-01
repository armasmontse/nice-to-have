@foreach ($page->sections as $section)

@endforeach

@forelse ($page->sections as $section)
    @include('client.pages.sections.'.$section->template_path, ['section' => $section ])
@empty
    @include('client.pages._empty-page')
@endforelse
