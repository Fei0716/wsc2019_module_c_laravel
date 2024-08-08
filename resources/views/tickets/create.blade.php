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
                        <h2 class="h4">Create new ticket</h2>
                    </div>
                </div>

                <form class="needs-validation" action="{{route('ticket.store',$event)}}" enctype="multipart/form-data"
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
                            <label for="inputCost">Cost</label>
                            <input type="number" class="form-control  @error('cost')is-invalid @enderror" id="inputCost"
                                   name="cost" placeholder=""
                                   value="0">
                            @error('cost')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="selectSpecialValidity">Special Validity</label>
                            <select class="form-control @error('special_validity')is-invalid @enderror"
                                    id="selectSpecialValidity"
                                    name="special_validity">
                                <option value="" selected>None</option>
                                <option value="amount" {{old('special_validity','')=='amount' ?'selected':''}}>Limited
                                    amount
                                </option>
                                <option value="date" {{old('special_validity','')=='date' ?'selected':''}}>Purchaseable
                                    till date
                                </option>
                            </select>
                            @error('special_validity')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputAmount">Maximum amount of tickets to be sold</label>
                            <input type="number" class="form-control @error('amount')is-invalid @enderror"
                                   id="inputAmount" name="amount" placeholder=""
                                   value="0">
                            @error('amount')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputValidTill">Tickets can be sold until</label>
                            <input type="text"
                                   class="form-control @error('valid_until')is-invalid @enderror"
                                   id="inputValidTill"
                                   name="valid_until"
                                   placeholder="yyyy-mm-dd"
                                   value="">
                            @error('valid_until')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <hr class="mb-4">
                    <button class="btn btn-primary" type="submit">Save ticket</button>
                    <a href="{{route('event.show',$event)}}" class="btn btn-link">Cancel</a>
                </form>

            </main>
        </div>
    </div>

    </body>
    </html>
