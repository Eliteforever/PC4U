@extends('layouts.header')
@section('content')
<div id="container">
    <div class="aboutContainer">
        <div class="story">
            <h1>Over ons</h1>
            <span class="aboutUsText">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis non tincidunt arcu. Aliquam fermentum mauris eu diam sodales, quis tincidunt odio vulputate. Pellentesque feugiat gravida suscipit. Nulla malesuada, sem vitae elementum sodales, sapien leo feugiat risus, vitae consectetur mi magna non ligula. Cras nisl sapien, volutpat at condimentum vel, ornare elementum erat. Aliquam at purus quis ex vehicula hendrerit vel laoreet sapien. Aenean ultrices vulputate lacus, non bibendum tortor cursus vitae. Donec viverra sodales urna, sit amet maximus est euismod eu. Nam egestas turpis at sapien semper, vitae blandit nunc cursus. Etiam at tristique mi. In hac habitasse platea dictumst. Sed tincidunt justo eget eleifend pellentesque. Ut vel ligula at lectus dapibus rutrum et in est. Donec viverra vulputate ipsum. Donec pulvinar, mi id ullamcorper consequat, orci diam porttitor lacus, sed imperdiet purus tellus a mi. Aliquam mi lacus, eleifend sit amet turpis id, semper venenatis sapien.

    Proin sed ligula tellus. Aenean feugiat tellus facilisis, suscipit leo nec, elementum magna. Quisque sit amet interdum tellus. Aenean varius ipsum non nibh blandit, id ultrices felis ultrices. Phasellus semper cursus dignissim. Quisque in sollicitudin purus. Donec aliquet urna eu leo commodo, sed porttitor orci egestas. Vivamus vel velit vehicula, tincidunt magna vitae, dictum elit. Curabitur eleifend ultrices maximus. Nam lacinia nisi id turpis scelerisque commodo. Proin fermentum felis at mollis feugiat. Fusce condimentum arcu nec lectus interdum venenatis.

    Cras augue odio, finibus id turpis a, ullamcorper iaculis risus. In sed erat facilisis, dapibus ante ut, fermentum quam. Suspendisse semper tortor ac nunc egestas viverra. Pellentesque dui augue, pretium sit amet risus tempus, iaculis laoreet lectus. Suspendisse potenti. Proin eget velit quam. Mauris sit amet rutrum ex, vitae eleifend nibh. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Phasellus vestibulum lacus nec orci ornare, vitae vestibulum augue consequat. In a ligula nisi. Proin id fermentum justo. Fusce tempor porttitor mauris, vel luctus ex rhoncus ut. Ut ut ornare nulla. Proin mattis neque vitae justo vestibulum ultricies. Proin egestas sem vel pulvinar placerat.
            </span>
        </div>
        <hr>
        <div class="creators">
            <h1>Ons team</h1>
            <div class="row">
                @for($i = 0; $i < 3; $i++)
                    <div class="col s12 m4">
                        <div class="card">
                            <div class="card-image">
                                <img src="http://via.placeholder.com/200x200">
                                <span class="card-title">Naam {{ $i }}</span>
                            </div>
                            <div class="card-content">
                                <p>Dit is een verhaal over persoon {{ $i }}
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi culpa earum, harum labore laudantium nam nihil non nostrum, nulla porro quae quos rem soluta suscipit tempore velit voluptas voluptatem voluptatum.</p>
                            </div>
                            <div class="card-action">
                                <a href="#"><i class="material-icons">email</i></a>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection