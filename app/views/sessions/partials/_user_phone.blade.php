{{ Form::open(['route'=> ['sessions.store'], 'id' => 'sign_in_form']) }}

  {{ Form::hidden('candidate_id', (isset($id) ? $id : null)) }}

  {{ Form::label('first_name', 'First Name') }}
  {{ form_error('first_name', $errors) }}
  {{ Form::text('first_name') }}

  {{--@TODO email or phone number depending on country code--}}
  {{ Form::label('phone', 'Cell Number') }}
  {{ form_error('phone', $errors) }}
  {{ Form::text('phone') }}

  {{ Form::label('birthdate', 'Birthdate') }}
  {{ form_error('birthdate', $errors) }}
  {{ Form::text('birthdate',  null, ['placeholder' => 'MM/DD/YYYY']) }}

  {{ Form::submit('Sign In', ['class' => 'btn']) }}
{{ Form::close() }}
