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
                        <h2 class="h4">Create new session</h2>
                    </div>
                </div>

                <form class="needs-validation" action="{{route('session.store',$event)}}" enctype="multipart/form-data"
                      method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="selectType">Type</label>
                            <select class="form-control" id="selectType" name="type">
                                <option value="talk" selected>Talk
                                </option>
                                <option value="workshop" {{old(
                                'type','')=='workshop' ?'selected':''}}>Workshop
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputTitle">Title</label>
                            <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                            <input type="text" class="form-control @error('title')is-invalid @enderror" id="inputTitle"
                                   name="title"
                                   placeholder="" value="{{old(
                                'title')}}">
                            @error('title')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputSpeaker">Speaker</label>
                            <input type="text" class="form-control  @error('speaker')is-invalid @enderror"
                                   id="inputSpeaker" name="speaker" placeholder=""
                                   value="{{old(
                                'speaker')}}">
                            @error('speaker')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="selectRoom">Room</label>
                            <select class="form-control" id="selectRoom" name="room">
                                @foreach($event->channels as $channel)
                                    @foreach($channel->rooms as $room)
                                        <option value="{{$room->id}}">{{$room->name}}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputCost">Cost</label>
                            <input type="number" class="form-control" id="inputCost" name="cost" placeholder=""
                                   value="{{old(
                                'cost','0')}}">
                            @error('cost')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="inputStart">Start</label>
                            <input type="text"
                                   class="form-control @error('start')is-invalid @enderror"
                                   id="inputStart"
                                   name="start"
                                   placeholder="yyyy-mm-dd HH:MM"
                                   value="{{old(
                                'start','')}}">
                            @error('start')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="inputEnd">End</label>
                            <input type="text"
                                   class="form-control @error('end')is-invalid @enderror"
                                   id="inputEnd"
                                   name="end"
                                   placeholder="yyyy-mm-dd HH:MM"
                                   value="{{old(
                                'end','')}}">
                            @error('end')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="textareaDescription">Description</label>
                            <textarea class="form-control  @error('description')is-invalid @enderror"
                                      id="textareaDescription" name="description" placeholder=""
                                      rows="5">{{old('description','')}}</textarea>
                            @error('description')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <hr class="mb-4">
                    <button class="btn btn-primary" type="submit">Save session</button>
                    <a href="{{route('event.show',$event)}}" class="btn btn-link">Cancel</a>
                </form>

            </main>
        </div>
    </div>
@endsection
