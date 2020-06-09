<!doctype html>
<html>
  <head>
    <title>De Gouden Draak - Menukaart</title>
    <style>
      .head-heading {
        display: block;
        text-align: center;
        font-weight: bold;
        font-size: 35px;
        margin-top: 1rem;
      }

      .type-heading {
        font-weight: bold;
        font-size: 25px;
        text-align: center;
        display: block;
        margin: 2rem 0;
      }

      .menu {
        display: flex;
        list-style-type: none;
        flex-wrap: wrap;
        padding: 0;
        margin: 0 auto;
        max-width: 960px;
        height: 100%;
      }

      .menu-item {
        display: flex;
        width: 50%;
        list-style-type: none;
        padding: 0 1rem;
        margin: 0 0 1rem;
      }

      .section {
        display: flex;
        flex-direction: column;
        flex: 1;
      }

      .heading {
        display: flex;
        width: 100%;
        justify-content: center;
        align-items: center;
      }

      .spacer {
        content: '';
        width: 100%;
        height: 1px;
        margin: 0 .5rem;
        border-bottom: 1px dashed black;
        flex: 1;
      }

      .title {
        margin: 0;
        font-size: 20px;
        font-weight: bold;
      }
    </style>
  </head>
  <body>
    <span class="head-heading">De Gouden Draak menukaart</span>
    @foreach($types as $type)
      <span class="type-heading">
        {{ $type->name }}
      </span>
      <ul class="menu">
        @foreach($type->dishes as $dish)
          <li class="menu-item">
            <div class="section">
              <div class="heading">
                <span class="title">{{ $dish->number }}. {{ $dish->name }}</span>
                <span class="spacer"></span>
                <span class="price">&euro;{{ round($dish->price, 2) }}</span>
              </div>
              @if($dish->description)
                <p>
                  ({{ $dish->description }})
                </p>
              @endif
            </div>
          </li>
        @endforeach
      </ul>
    @endforeach
    <span class="head-heading">Aanbiedingen</span>
    @foreach($offers as $offer)
      <span class="type-heading">
        {{ $offer->name }} &euro;{{ round($offer->price, 2) }}
      </span>
      <ul class="menu">
        @foreach($offer->dishes as $dish)
          <li class="menu-item">
            <div class="section">
              <div class="heading">
                <span class="title">{{ $dish->number }}. {{ $dish->name }}</span>
              </div>
              @if($dish->description)
                <p>
                  ({{ $dish->description }})
                </p>
              @endif
            </div>
          </li>
        @endforeach
      </ul>
    @endforeach
  </body>
</html>
