@extends('layout.main')
@include('layout.nav')

@section('content')

    <div class="container-fluid">
        <div class="row">
            @include('layout.sideNav')
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="border-bottom mb-3 pt-3 pb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h1 class="h2">{{$event->name}}</h1>
                    </div>
                    <span class="h6">{{date('M d,Y',strtotime($event->date))}}</span>
                </div>

                <div class="mb-3 pt-3 pb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h2 class="h4">Create new room</h2>
                    </div>
                </div>

                <form class="needs-validation" action="{{route('room.store',$event)}}" enctype="multipart/form-data"
                      method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputName">Name</label>
                            <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                            <input type="text" class="form-control @error('name')is-invalid @enderror" id="inputName"
                                   name="name" placeholder=""
                                   value="{{old('name')}}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="selectChannel">Channel</label>
                            <select class="form-control" id="selectChannel" name="channel">
                                @foreach($event->channels  as $channel)
                                    <option value="{{$channel->id}}">{{$channel->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputCapacity">Capacity</label>
                            <input type="number" class="form-control @error('capacity')is-invalid @enderror"
                                   id="inputCapacity" name="capacity" placeholder=""
                                   value="{{old('capacity')}}">
                            @error('capacity')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <hr class="mb-4">
                    <button class="btn btn-primary" type="submit">Save room</button>
                    <a href="{{route('event.show',$event)}}" class="btn btn-link">Cancel</a>
                </form>

            </main>
        </div>
    </div>
@endsection
