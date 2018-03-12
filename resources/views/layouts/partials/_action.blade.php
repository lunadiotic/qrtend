@if (!empty($form_url))

    {!! Form::model($model, ['url' => $form_url, 'method' => 'delete']) !!}

    @if(!empty($show_url) && !empty($edit_url))

        <a href="{{ $show_url }}" class="btn btn-info   btn-xs">Show</a>
        <a href="{{ $edit_url }}" class="btn btn-primary   btn-xs">Edit</a>

    @elseif(empty($show_url) && !empty($edit_url))

        <a href="{{ $edit_url }}" class="btn btn-primary   btn-xs">Edit</a>

    @elseif(!empty($show_url) && empty($edit_url))

        <a href="{{ $show_url }}" class="btn btn-info   btn-xs">Show</a>

    @endif

    <button type="submit" class="btn btn-danger   btn-xs js-submit-confirm">Delete</button>

    {!! Form::close() !!}

@else

    @if(!empty($show_url) && !empty($edit_url))

        <a href="{{ $show_url }}" class="btn btn-info   btn-xs">Show</a>
        <a href="{{ $edit_url }}" class="btn btn-primary   btn-xs">Edit</a>

    @elseif(empty($show_url) && !empty($edit_url))

        <a href="{{ $edit_url }}" class="btn btn-primary   btn-xs">Edit</a>

    @elseif(!empty($show_url) && empty($edit_url))

        <a href="{{ $show_url }}" class="btn btn-info   btn-xs">Show</a>

    @endif

@endif