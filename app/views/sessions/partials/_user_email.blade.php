{{ Form::open(['route'=> ['sessions.store'], 'id' => 'sign_in_form']) }}

  {{ Form::hidden('candidate_id', (isset($id) ? $id : null)) }}

  {{ Form::label('first_name', 'First Name') }}
  {{ form_error('first_name', $errors) }}
  {{ Form::text('first_name', null, ['placeholder' => 'What\'s your name?']) }}

  {{ Form::label('birthdate', 'Birthdate') }}
  {{ form_error('birthdate', $errors) }}
  {{ Form::text('birthdate',  null, ['placeholder' => 'MM/DD/YYYY']) }}

  {{--@TODO email or phone number depending on country code--}}
  {{ Form::label('email', 'Email') }}
  {{ form_error('email', $errors) }}
  {{ Form::text('email', null, ['placeholder' => 'you@example.com']) }}

  {{ Form::submit('Count My Vote', ['class' => 'button -primary']) }}
{{ Form::close() }}
