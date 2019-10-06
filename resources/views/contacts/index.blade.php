@extends('base')

@section('main')

</style>
<div class="row">
<div class="col-sm-12">
    <h3>Contacts</h3>
    <a class="btn btn-primary" href="{{ route('contacts.create')}}">Add Contact</a>
  <table class="table table-striped">
    <thead>
        <tr>
          <td>S.No.</td>
          <td>First Name</td>
          <td>Last Name</td>
          <td>Email</td>
          <td>Phone</td>
          <td>Subject</td>
          <td>Message</td>
          <td colspan = 2>Action</td>
        </tr>
    </thead>
    <tbody>
        @if(count($contacts) > 0)
          @php
            $count=1;
          @endphp
          @foreach($contacts as $contact)
          <tr>
              <td>{{$count}}</td>
              <td>{{$contact->first_name}}</td>
              <td>{{$contact->last_name}}</td>
              <td>{{$contact->email}}</td>
              <td>{{$contact->phone}}</td>
              <td>{{$contact->subject}}</td>
              <td>{{$contact->message}}</td>
              <td>
                  <a href="{{ route('contacts.edit',$contact->id)}}" class="btn btn-primary">Edit</a>
              </td>
              <td>
                  <form action="{{ route('contacts.destroy', $contact->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Delete</button>
                  </form>
              </td>
          </tr>
          @php
            $count++;
          @endphp
          @endforeach
        @else
        <tr class="text-center">
          <td colspan="8">No Record Found</td>
        </tr>
        @endif

    </tbody>
  </table>

  {{ $contacts->links() }}
<div>
</div>
@endsection
