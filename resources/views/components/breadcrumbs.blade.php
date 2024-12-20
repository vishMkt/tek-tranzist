@props(['title' => "",'data'=>""])
<div class="row mb-2">
    <div class="col-sm-6">
        {{-- resources/views/home.blade.php --}}
         {{ Breadcrumbs::render({{$title}},{{$data}}) }}
    </div>
</div>