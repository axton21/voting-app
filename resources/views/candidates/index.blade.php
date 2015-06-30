@extends('app')

@section('content')
    @if($categories)

        @react('CandidateIndex', compact('categories', 'query'))

        <div class="wrapper -narrow">
            <h4>Was there a {{ setting('candidate_type') }} we missed?</h4>

            <p>
                If you know a {{ setting('candidate_type') }} who's done kickass things in the world, but don't see them
                on our list, <a href="{{ setting('writein_link') }}">let us know</a>.
            </p>
        </div>

        <script type="text/html" id="form-template">
            @include('votes.form', ['candidate' => null, 'winner' => null])
        </script>
    @endif

    @include('users.partials.closed')
@stop
