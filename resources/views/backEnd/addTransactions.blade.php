@extends('backEnd.master')

@section('styles')
    <link rel="stylesheet" href="{{asset('public/assets/css/addTransaction.css')}}">
@endsection

@section('mainContent')

<div class="card">
    @if(session()->has('message-success'))
        <div class="alert alert-success mb-3 background-success" role="alert">
            {{ session()->get('message-success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif(session()->has('message-danger'))
        <div class="alert alert-danger">
            {{ session()->get('message-danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session()->has('message-success-delete'))
        <div class="alert alert-danger mb-3 background-danger" role="alert">
            {{ session()->get('message-success-delete') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif(session()->has('message-danger-delete'))
        <div class="alert alert-danger">
            {{ session()->get('message-danger-delete') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card-header">
        <h5>Add Transaction</h5>
    </div>
    <div class="card-block">
        <div id="app">
            <add-transaction :user-id={{Auth::id()}}></add-transaction>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script type="text/javascript" src="node_modules/vuejs/dist/vue.min.js"></script>
    <script type="text/javascript" src="node_modules/vue-simple-search-dropdown/dist/vue-simple-search-dropdown.min.js"></script>
    <script type="text/javascript">
        Vue.use(Dropdown);
    </script>
@endsection
