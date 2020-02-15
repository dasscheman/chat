<script>
  var userid = JSON.parse("{{ json_encode(auth()->user()->id) }}");
  var to_user = JSON.parse("{{ json_encode($toUser->id) }}");
console.log(userid)
</script>
@extends('layouts.app')

@section('content')
    <div class="container chats">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card card-default">
                    <div class="card-header">Private Chats with {{$toUser->name}}</div>
                    <div class="card-body">
                        <private-chat-messages :privatemessages="privatemessages"></private-chat-messages>
                    </div>
                    <div class="card-footer">
                        <private-form
                            @privatemessagesent="addPrivateMessage"
                            :user="{{ auth()->user() }}"
                            :to_user="{{ $toUser->id }}"
                        ></private-form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <dilemma
                    :dilemmas="dilemmas"
                    :dilemma="dilemma"
                    :user="{{ auth()->user() }}"
                    :to_user="{{ $toUser->id }}"


                ></dilemma>
            </div>
        </div>
    </div>
@endsection
