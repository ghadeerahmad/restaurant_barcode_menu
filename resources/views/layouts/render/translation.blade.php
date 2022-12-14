
    @if ($selected_language->data[$key] ?? false)
        {{$selected_language->data[$key]}}
    @else
        {{config( 'global.translation.section.'.$default.'.values.'.$key)}}
        @endif

