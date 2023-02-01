<div class="py-2">
    <div class="max-w-xl mx-auto bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-4" style="position:relative;">
            {{ $username }}
            <h1 class="text-xl text-center text-gray-800">
                {{ $title }}
            </h1>
            <div class="py-2">
                @if (!empty($file_name))
                <img src="storage/images/{{ $file_name }}" style="margin:auto;" width="500rem">
                @endif
                @if (!empty($content))
                {{ $content }}
                @endif
            </div>
            <a href="/posts/{{ $post_id }}"><span style="position:absolute; width:100%; height:100%; top:0; left:0; z-index:1;"></span></a>
        </div>
    </div>
</div>