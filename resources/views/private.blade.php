<script>
  var userid = JSON.parse("{{ json_encode(auth()->user()->id) }}");
  var to_user = JSON.parse("{{ json_encode($toUser->id) }}");
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
            <!-- <div class="col-md-4">
                <div class="card-header">Online</div>
                <ul class="list-group">
                    <li class="list-group-item"  v-for="user in allusers">

                        <a :href="'private/' + user.id" v-if="user.id!={{ auth()->user()->id }}">
                            @{{ user.name }} <span v-if="user.typing" class="badge badge-primary">typing...</span>
                        </a>
                        <div v-if="user.id=={{ auth()->user()->id }}">
                            @{{ user.name }} <span v-if="user.typing" class="badge badge-primary">typing...</span>
                        </div>

                    </li>
                </ul>
            </div> -->
        </div>
    </div>
@endsection
