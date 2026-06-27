<div class="prose prose-slate prose-xl max-w-none 
            prose-headings:font-black prose-headings:text-on-surface prose-headings:tracking-tight
            prose-p:text-on-surface-variant prose-p:leading-[1.8] prose-p:text-[1.3rem]
            prose-strong:text-on-surface prose-strong:font-black
            prose-a:text-secondary prose-a:font-black prose-a:no-underline hover:prose-a:underline
            prose-blockquote:border-l-4 prose-blockquote:border-indigo-600 prose-blockquote:bg-surface-container-low prose-blockquote:py-4 prose-blockquote:px-8 prose-blockquote:rounded-r-2xl prose-blockquote:italic prose-blockquote:text-on-surface-variant
            prose-img:rounded-2xl prose-img:shadow-xl
            prose-ul:list-disc prose-li:text-on-surface-variant">
    @if($article->content_blocks && count($article->content_blocks) > 0)
        @foreach($article->content_blocks as $block)
            @if($block['type'] === 'text' && isset($block['data']['content']))
                <p class="whitespace-pre-line">{{ $block['data']['content'] }}</p>

            @elseif($block['type'] === 'image' && isset($block['data']['url']) && !empty($block['data']['url']))
                <figure class="my-8">
                    <img src="{{ asset('storage/' . $block['data']['url']) }}" alt="{{ $block['data']['caption'] ?? 'Gambar' }}" class="rounded-2xl shadow-xl w-full">
                    @if(!empty($block['data']['caption']))
                        <figcaption class="text-center text-sm text-outline mt-2 italic">{{ $block['data']['caption'] }}</figcaption>
                    @endif
                </figure>

            @elseif($block['type'] === 'video' && isset($block['data']['url']) && !empty($block['data']['url']))
                @php
                    $ytEmbed = \App\Models\Article::getYoutubeEmbedUrl($block['data']['url']);
                    $gdEmbed = \App\Models\Article::getGoogleDriveEmbedUrl($block['data']['url']);
                @endphp
                <div class="my-8">
                    <div class="relative w-full bg-inverse-surface rounded-2xl overflow-hidden shadow-xl" style="padding-bottom: 56.25%;">
                        @if($ytEmbed)
                            <iframe class="absolute inset-0 w-full h-full" src="{{ $ytEmbed }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @elseif($gdEmbed)
                            <iframe class="absolute inset-0 w-full h-full" src="{{ $gdEmbed }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @else
                            <div class="absolute inset-0 flex flex-col items-center justify-center bg-inverse-surface text-outline-variant p-4">
                                <span class="material-symbols-outlined text-[48px] text-red-400">link_off</span>
                                <p class="text-sm font-bold mt-2">Video link tidak valid</p>
                                <a href="{{ $block['data']['url'] }}" target="_blank" class="text-xs text-indigo-400 underline mt-1 break-all">{{ $block['data']['url'] }}</a>
                            </div>
                        @endif
                    </div>
                    @if(!empty($block['data']['caption']))
                        <p class="text-center text-sm text-outline mt-2 italic">{{ $block['data']['caption'] }}</p>
                    @endif
                </div>

            @elseif($block['type'] === 'divider')
                <div class="flex items-center justify-center py-6">
                    <div class="w-1/4 border-t border-outline-variant"></div>
                    <span class="text-outline-variant mx-4 font-bold">···</span>
                    <div class="w-1/4 border-t border-outline-variant"></div>
                </div>
            @endif
        @endforeach
    @else
        {!! $article->content !!}
    @endif
</div>
