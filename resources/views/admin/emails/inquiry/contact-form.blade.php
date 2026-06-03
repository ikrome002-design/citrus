<!-- contact-form.blade.php -->
<p>Hi {{config('app.name')}}!, </p>

<p>This is {!! $form_data['name'] ?: 'User'  !!}</p>
@if(!empty($form_data['email']))
<p>Email: {{ $form_data['email'] }}</p>
@endif
@if(!empty($form_data['phone']))
<p>Phone: {{ $form_data['phone'] }}</p>
@endif

@foreach ($form_data['contact_meta'] as $key => $value)
	@if( !empty($value) )
	<p>{{$key}} : {{ $value }}
	@endif
@endforeach
@if(!empty($form_data['message']))
<p>I have some query like: {{ $form_data['message'] }}.</p>
@endif
<p>It would be appriciative, if you gone through this feedback.</p>
<p><a >Website</a></p>