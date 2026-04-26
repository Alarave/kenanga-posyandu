@props(['items'])

<nav class="flex" aria-label="Breadcrumb">
  <ol class="inline-flex items-center space-x-1 md:space-x-3">
    @foreach($items as $item)
      <li class="inline-flex items-center">
        @if(!$loop->first)
          <svg class="w-4 h-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
          </svg>
        @endif
        
        @if(isset($item['active']) && $item['active'])
          <span class="text-sm font-medium text-gray-500">{{ $item['label'] }}</span>
        @else
          <a href="{{ $item['url'] ?? '#' }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
            {{ $item['label'] }}
          </a>
        @endif
      </li>
    @endforeach
  </ol>
</nav>
