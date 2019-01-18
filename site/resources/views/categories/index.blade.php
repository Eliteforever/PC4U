@extends('layouts.header')

@section('content')


<div class="categoryPage">
    <div id="container">
        <p class="headerText" style="margin-top: 0px;">
            &nbsp;
        </p>
        <div class="innerContainer">

            <div class="row">
                <div class="col s12 m3">
                    <div class="categoryCollection collection with-header z-depth-1">
                        <div class="collection-header">
                            Categorieen
                        </div>
                        @foreach ($categories as $key => $category)
                            
                            <a class="collection-item" href="/categories/{{$category['name']}}">
                                {{ $category['name'] }}
                            </a>
                            
                        @endforeach
                    </div>
                </div>
                <div class="col s12 m9">
                    <div class="categoryExpand">
                        <div class="row">
                        @foreach ($categories as $key => $category)
                            <a href="/categories/{{$category['name']}}">
                                <div class="col s12 m6 l3 categroryCollumn">
                                    <div class="categoryExpandedItem z-depth-1">
                                        <div class="categoryImgContainer">
                                            <img class="categoryImage" alt="" src="{{ 'imgs/' . $category['image']['folder'] . $category['image']['filename'] }}"/>
                                        </div>
                                        <p class="categoryName">
                                            {{ $category['name'] }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('external-scripts')
<script src="{{ asset('js/matchHeight.js') }}"></script>
@endsection
