<div class="w-full aspect-[21/9] rounded-[3rem] overflow-hidden mb-20 shadow-2xl relative group">
    <img src="{{ $article->thumbnail ? $article->thumbnail_url : 'https://images.unsplash.com/photo-1576091160550-217359f4ecf8?q=80&w=2070&auto=format&fit=crop' }}" 
         alt="{{ $article->title }}" 
         class="w-full h-full object-cover transition-transform duration-[3s] group-hover:scale-105">
</div>
