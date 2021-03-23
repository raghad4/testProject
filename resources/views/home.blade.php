@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                          <ul>
                            @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                            @endforeach
                          </ul>
                        </div>
                    @endif

                    {{-- @if (session('success')) --}}
                      <div class="alert alert-success" id="success_msg" style="display:none">
                          {{-- {{ session('success') }} --}}
                          saved successfully
                      </div>
                    {{-- @endif --}}

                    <div class="alert alert-danger print-error-msg" id="error_msg" style="display:none">
                        <ul></ul>
                    </div>

                    <div class="container">
                        <form method="POST" id="clientForm" enctype="multipart/form-data">
                          @csrf
                            <div class="form-group">
                              <label for="">Username</label>
                              <input type="text"
                                class="form-control" name="username" id=""  placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="">Email</label>
                              <input type="email"
                                class="form-control" name="email" id="" placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="">Name</label>
                              <input type="text"
                                class="form-control" name="name" id="" placeholder="">
                            </div>
                            <div class="form-group">
                              <label for="">Password</label>
                              <input type="password"
                                class="form-control" name="password" id="" placeholder="">
                            </div>
                           <div class="form-group">
                             <label for="">Age</label>
                             <select class="form-control" name="age" id="">
                               @for($i=10;$i<=85;$i++)
                               <option value="{{$i}}">{{$i}}</option>
                               @endfor
                             </select>
                           </div>
                           <div class="form-group">
                             <label for="">Biography</label>
                             <textarea class="form-control" name="biography" id="" rows="3"></textarea>
                           </div>
                           <div class="form-group">
                             <label for="">Img</label>
                             <input type="file" class="form-control-file" name="img">
                           </div>
                            <div class="form-group row">
                                <div class="offset-sm-0 col-sm-12">
                                    <button  class="btn btn-primary" id="save_client">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
          <div class="card">
              <div class="card-header">{{ __('Clients') }}</div>
              <div class="card-body">
                  <div class="container">
                    <table class="table" id="clients">
                      <thead>
                        <tr>
                          <th scope="col">img</th>
                          <th scope="col">username</th>
                          <th scope="col">email</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($clients as $client)
                        <tr>
                          @if($client->age > $average)
                          <th scope="row"><div style="width:30px;height:30px;background-color:gray"></div></th>
                          @else
                          <th scope="row"><img src="{{$client->img}}" style="width:30px;height:30px"></th>
                          @endif
                          <td>
                            <a href="#" class="xedit" 
                               data-pk="{{$client->id}}"
                               data-name="username">
                               {{$client->username}}</a>
                          </td>
                          {{-- <td>{{$client->username}}</td> --}}
                          <td>{{$client->email}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
              </div>
          </div>
      </div>
    </div>
</div>

@section('scripts')

<script>
  $(document).on('submit','#clientForm',function(e){
    e.preventDefault();

    $(`input,textarea`).css('border', '1px solid #ced4da');
    $('#success_msg').css('display','none');
    $('#error_msg').css('display','none');

    var formData = new FormData($('#clientForm')[0]);
    formData.append('_token', @json(csrf_token())  );
    $.ajax({
          type:'POST',
          url:'{{ route("clients.store") }}',
          enctype:'multipart/form-data',
          processData: false,
          contentType: false,
          data: formData,
          success: function(data) {
            if(data.status == true){
              $('#success_msg').css('display','block');
              $('input,textarea').val('');
              addClient(data.client);
            }
          },
          error: function (msg) {
            let message = msg.responseJSON.message;
            let errors = msg.responseJSON.errors;
            $('#error_msg').html(message);
            $('#error_msg').append(`<ul></ul>`);
            Object.keys(errors).forEach(function(key) {
              $(`input[name=${key}],textarea[name=${key}]`).css('border', '1px solid #ffb1b1');
              $('#error_msg ul').append(`<li>${errors[key]}</li>`);
            })
            $('#error_msg').css('display','block');
          },
    });
  });
  
  
  function addClient(client){
    $('#clients tbody').prepend(`
        <tr>
          <th scope="row">
          `+
          (client.img ? 
          `<img src="${client.img}" style="width:30px;height:30px"></th>`: 
          `<div style="width:30px;height:30px;background-color:#f0f0f0"></div>`)
          +
          `<td>
            <a href="#" class="xedit" 
                data-pk=""
                data-name="username">${client.name}</a>
          </td>
          <td>${client.email}</td>
        </tr>
    `);
  }
</script>
{{-- <script>
  $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }
            });

            $('.xedit').editable({
                url: '{{url("clients/update")}}',
                title: 'Update',
                success: function (response, newValue) {
                    console.log('Updated', response)
                }
            });

    })
</script> --}}
@endsection


@endsection
