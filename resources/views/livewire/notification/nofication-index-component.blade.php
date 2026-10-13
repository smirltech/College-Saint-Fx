<div>
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="box-body">
                <div class="row">
                    @foreach($notifications as $notification)
                        <div class="col-md-6">
                            <div
                                class="alert {{$notification->unread()?'alert-warning':'alert-info'}} alert-dismissible">
                                <button wire:click="deleteNotification('{{$notification->id}}')" type="button"
                                        class="close" data-dismiss="alert" aria-hidden="true">×
                                </button>
                                <h4 wire:click="openNotification('{{$notification->id}}')">
                                    <i class=" fa {{$notification->read()?'fa-envelope-open':'fa-envelope'}}"></i>
                                    {{$notification->data['title']??''}}
                                </h4>
                                <p wire:click="openNotification('{{$notification->id}}')">
                                    {!! $notification->data['message']??'' !!}
                                    <small>{{$notification->created_at->diffForHumans()}}</small></p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
