<a href="{{ $instagram_auth_url }}">Click to get Instgram permission</a>

@if($was_successful)
 <p>Yes, we can now use your instagram feed</p>
@else
 <p>Sorry, we failed to get permission to use your insagram feed.</p>
@endif